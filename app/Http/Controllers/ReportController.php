<?php

namespace App\Http\Controllers;

use App\Models\Material;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function kardex($materialId)
    {
        try {
            $material = Material::findOrFail($materialId);
            $group_material = $material->group()->first()->name_group;

            $kardex = [];
            $stock = 0;
            $totalValuation = 0;

            $entries = $material->noteEntries()->orderBy('created_at', 'asc')->get();
            $requests = $material->noteRequests()->where('state', '=', 'Aceptado')->orderBy('created_at', 'asc')->get();

            $movements = [];

            foreach ($entries as $entry) {
                $movements[] = [
                    'date' => $entry->pivot->created_at,
                    'type' => 'entry',
                    'description' => 'Nota de Entrada #' . $entry->number_note,
                    'quantity' => $entry->pivot->amount_entries,
                    'cost_unit' => number_format($entry->pivot->cost_unit, 2), // Formato con 2 decimales
                ];
            }

            foreach ($requests as $request) {
                $movements[] = [
                    'date' => $request->pivot->created_at,
                    'type' => 'exit',
                    'description' => 'Solicitud #' . $request->id,
                    'quantity' => $request->pivot->delivered_quantity,
                    'cost_unit' => null,
                ];
            }

            usort($movements, function ($a, $b) {
                return strtotime($a['date']) - strtotime($b['date']);
            });

            $fifoQueue = [];

            foreach ($movements as $movement) {
                if ($movement['type'] === 'entry') {
                    $fifoQueue[] = [
                        'quantity' => $movement['quantity'],
                        'cost_unit' => $movement['cost_unit'],
                    ];
                    $stock += $movement['quantity'];
                    $totalValuation += $movement['quantity'] * $movement['cost_unit'];

                    $kardex[] = [
                        'date' => date('Y-m-d', strtotime($movement['date'])),
                        'description' => $movement['description'],
                        'entradas' => $movement['quantity'],
                        'salidas' => 0,
                        'stock_fisico' => $stock,
                        'cost_unit' => number_format($movement['cost_unit'], 2), // Formato con 2 decimales
                        'cost_total' => number_format(max($totalValuation, 0), 2), // Formato con 2 decimales, asegura no negativo
                    ];
                } elseif ($movement['type'] === 'exit') {
                    $quantityToDeliver = $movement['quantity'];
                    $costTotal = 0;

                    while ($quantityToDeliver > 0 && count($fifoQueue) > 0) {
                        $fifoItem = array_shift($fifoQueue);

                        if ($fifoItem['quantity'] > $quantityToDeliver) {
                            $costUnit = $fifoItem['cost_unit'];
                            $costTotal += $quantityToDeliver * $costUnit;

                            $kardex[] = [
                                'date' => date('Y-m-d', strtotime($movement['date'])),
                                'description' => $movement['description'] . ' (Parte del lote)',
                                'entradas' => 0,
                                'salidas' => $quantityToDeliver,
                                'stock_fisico' => $stock - $quantityToDeliver,
                                'cost_unit' => number_format($costUnit, 2), // Formato con 2 decimales
                                'cost_total' => number_format(max($totalValuation - $costTotal, 0), 2), // Formato con 2 decimales, asegura no negativo
                            ];

                            $fifoItem['quantity'] -= $quantityToDeliver;
                            array_unshift($fifoQueue, $fifoItem);
                            $stock -= $quantityToDeliver;
                            $totalValuation = max($totalValuation - $costTotal, 0); // Asegura no negativo
                            $quantityToDeliver = 0;
                        } else {
                            $costUnit = $fifoItem['cost_unit'];
                            $costTotal += $fifoItem['quantity'] * $costUnit;

                            $kardex[] = [
                                'date' => date('Y-m-d', strtotime($movement['date'])),
                                'description' => $movement['description'] . ' (Lote completo)',
                                'entradas' => 0,
                                'salidas' => $fifoItem['quantity'],
                                'stock_fisico' => $stock - $fifoItem['quantity'],
                                'cost_unit' => number_format($costUnit, 2), // Formato con 2 decimales
                                'cost_total' => number_format(max($totalValuation - $costTotal, 0), 2), // Formato con 2 decimales, asegura no negativo
                            ];

                            $quantityToDeliver -= $fifoItem['quantity'];
                            $stock -= $fifoItem['quantity'];
                            $totalValuation = max($totalValuation - $costTotal, 0); // Asegura no negativo
                        }
                    }
                }
            }

            return response()->json([
                'code_material' => $material->code_material,
                'description' => $material->description,
                'unit_material' => $material->unit_material,
                'group' => $group_material,
                'kardex_de_existencia' => $kardex
            ]);
        } catch (\Exception $e) {
            logger($e->getMessage());
            return response()->json(['error' => 'No se pudo generar el Kardex'], 500);
        }
    }
}
