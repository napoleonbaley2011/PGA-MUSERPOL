<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Group;
use App\Models\Material;
use App\Models\Note_Entrie;
use App\Models\NoteRequest;
use Barryvdh\DomPDF\Facade\Pdf;
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
            $max_total = 0;

            $entries = $material->noteEntries()->orderBy('created_at', 'asc')->get();
            $requests = $material->noteRequests()->where('state', '=', 'Aceptado')->orderBy('created_at', 'asc')->get();

            $movements = [];

            foreach ($entries as $entry) {
                $movements[] = [
                    'date' => $entry->pivot->created_at,
                    'type' => 'entry',
                    'description' => $entry->name_supplier . ' - Nota de Entrada #' . $entry->number_note,
                    'quantity' => $entry->pivot->amount_entries,
                    'cost_unit' => number_format($entry->pivot->cost_unit, 2),
                ];
            }

            foreach ($requests as $request) {
                $employee = Employee::find($request->user_register);
                $movements[] = [
                    'date' => $request->pivot->created_at,
                    'type' => 'exit',
                    'description' => ucwords(strtolower("{$employee->first_name} {$employee->last_name} {$employee->mothers_last_name}")) . ' - Solicitud #' . $request->id,
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
                    $totalValuation = $movement['quantity'] * $movement['cost_unit'];
                    $max_total = $max_total + $totalValuation;

                    $kardex[] = [
                        'date' => date('Y-m-d', strtotime($movement['date'])),
                        'description' => $movement['description'],
                        'entradas' => $movement['quantity'],
                        'salidas' => 0,
                        'stock_fisico' => $stock,
                        'cost_unit' => number_format($movement['cost_unit'], 2),
                        'cost_total' => number_format($max_total, 2),
                    ];
                } elseif ($movement['type'] === 'exit') {
                    $quantityToDeliver = $movement['quantity'];
                    $costTotal = 0;

                    while ($quantityToDeliver > 0 && count($fifoQueue) > 0) {
                        $fifoItem = array_shift($fifoQueue);

                        if ($fifoItem['quantity'] > $quantityToDeliver) {
                            $costUnit = $fifoItem['cost_unit'];
                            $costTotal = $quantityToDeliver * $costUnit;
                            $max_total = $max_total - $costTotal;

                            $kardex[] = [
                                'date' => date('Y-m-d', strtotime($movement['date'])),
                                'description' => $movement['description'],
                                'entradas' => 0,
                                'salidas' => $quantityToDeliver,
                                'stock_fisico' => $stock - $quantityToDeliver,
                                'cost_unit' => number_format($costUnit, 2),
                                'cost_total' => number_format($max_total, 2),
                            ];

                            $fifoItem['quantity'] -= $quantityToDeliver;
                            array_unshift($fifoQueue, $fifoItem);
                            $stock -= $quantityToDeliver;
                            $totalValuation = max($totalValuation - $costTotal, 0);
                            $quantityToDeliver = 0;
                        } else {
                            $costUnit = $fifoItem['cost_unit'];
                            $costTotal = $fifoItem['quantity'] * $costUnit;
                            $max_total = $max_total - $costTotal;

                            $kardex[] = [
                                'date' => date('Y-m-d', strtotime($movement['date'])),
                                'description' => $movement['description'],
                                'entradas' => 0,
                                'salidas' => $fifoItem['quantity'],
                                'stock_fisico' => $stock - $fifoItem['quantity'],
                                'cost_unit' => number_format($costUnit, 2),
                                'cost_total' => number_format($max_total, 2),
                            ];

                            $quantityToDeliver -= $fifoItem['quantity'];
                            $stock -= $fifoItem['quantity'];
                            $totalValuation = max($totalValuation - $costTotal, 0);
                        }
                    }
                }
            }

            return response()->json([
                'code_material' => $material->code_material,
                'description' => $material->description,
                'unit_material' => $material->unit_material,
                'group' => strtoupper($group_material),
                'kardex_de_existencia' => $kardex
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'No se pudo generar el Kardex'], 500);
        }
    }

    public function print_kardex($materialId)
    {

        try {
            $material = Material::findOrFail($materialId);
            $group_material = $material->group()->first()->name_group;

            $kardex = [];
            $stock = 0;
            $totalValuation = 0;
            $max_total = 0;

            $entries = $material->noteEntries()->orderBy('created_at', 'asc')->get();
            $requests = $material->noteRequests()->where('state', '=', 'Aceptado')->orderBy('created_at', 'asc')->get();

            $movements = [];

            foreach ($entries as $entry) {
                $movements[] = [
                    'date' => $entry->pivot->created_at,
                    'type' => 'entry',
                    'description' => $entry->name_supplier . ' - Nota de Entrada #' . $entry->number_note,
                    'quantity' => $entry->pivot->amount_entries,
                    'cost_unit' => number_format($entry->pivot->cost_unit, 2),
                ];
            }

            foreach ($requests as $request) {
                $employee = Employee::find($request->user_register);
                $movements[] = [
                    'date' => $request->pivot->created_at,
                    'type' => 'exit',
                    'description' => ucwords(strtolower("{$employee->first_name} {$employee->last_name} {$employee->mothers_last_name}")) . ' - Solicitud #' . $request->id,
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
                    $totalValuation = $movement['quantity'] * $movement['cost_unit'];
                    $max_total = $max_total + $totalValuation;

                    $kardex[] = [
                        'date' => date('Y-m-d', strtotime($movement['date'])),
                        'description' => $movement['description'],
                        'entradas' => $movement['quantity'],
                        'salidas' => 0,
                        'stock_fisico' => $stock,
                        'cost_unit' => number_format($movement['cost_unit'], 2),
                        'cost_total' => number_format($max_total, 2),
                    ];
                } elseif ($movement['type'] === 'exit') {
                    $quantityToDeliver = $movement['quantity'];
                    $costTotal = 0;

                    while ($quantityToDeliver > 0 && count($fifoQueue) > 0) {
                        $fifoItem = array_shift($fifoQueue);

                        if ($fifoItem['quantity'] > $quantityToDeliver) {
                            $costUnit = $fifoItem['cost_unit'];
                            $costTotal = $quantityToDeliver * $costUnit;
                            $max_total = $max_total - $costTotal;

                            $kardex[] = [
                                'date' => date('Y-m-d', strtotime($movement['date'])),
                                'description' => $movement['description'],
                                'entradas' => 0,
                                'salidas' => $quantityToDeliver,
                                'stock_fisico' => $stock - $quantityToDeliver,
                                'cost_unit' => number_format($costUnit, 2),
                                'cost_total' => number_format($max_total, 2),
                            ];

                            $fifoItem['quantity'] -= $quantityToDeliver;
                            array_unshift($fifoQueue, $fifoItem);
                            $stock -= $quantityToDeliver;
                            $totalValuation = max($totalValuation - $costTotal, 0);
                            $quantityToDeliver = 0;
                        } else {
                            $costUnit = $fifoItem['cost_unit'];
                            $costTotal = $fifoItem['quantity'] * $costUnit;
                            $max_total = $max_total - $costTotal;

                            $kardex[] = [
                                'date' => date('Y-m-d', strtotime($movement['date'])),
                                'description' => $movement['description'],
                                'entradas' => 0,
                                'salidas' => $fifoItem['quantity'],
                                'stock_fisico' => $stock - $fifoItem['quantity'],
                                'cost_unit' => number_format($costUnit, 2),
                                'cost_total' => number_format($max_total, 2),
                            ];

                            $quantityToDeliver -= $fifoItem['quantity'];
                            $stock -= $fifoItem['quantity'];
                            $totalValuation = max($totalValuation - $costTotal, 0);
                        }
                    }
                }
            }

            $data = [
                'title' => 'KARDEX DE EXISTENCIAS',
                'code_material' => $material->code_material,
                'description' => $material->description,
                'unit_material' => $material->unit_material,
                'group' => strtoupper($group_material),
                'kardex_de_existencia' => $kardex
            ];

            $pdf = Pdf::loadView('Report_Kardex.ReportKardex', $data)->setPaper('letter', 'landscape');
            return $pdf->stream('Kardex de Existencia.pdf');
        } catch (\Exception $e) {
            return response()->json(['error' => 'No se pudo generar el Kardex'], 500);
        }
    }

    public function dashboard_data()
    {
        $num_material = Material::where('stock', '>', 0)->count();
        $num_material_total = Material::all()->count();
        $num_order_total = NoteRequest::all()->count();
        $num_order = NoteRequest::where('state', '=', 'En Revision')->count();
        $num_delivery = NoteRequest::where('state', '=', 'Aceptado')->count();

        return response()->json([
            'num_material' => $num_material,
            'num_material_total' => $num_material_total,
            'num_order' => $num_order,
            'num_order_total' => $num_order_total,
            'num_delivery' => $num_delivery,
        ]);
    }

    public function kardexGeneral()
    {
        try {
            $materials = Material::all();
            $kardexGeneral = [];

            foreach ($materials as $material) {
                $stock = 0;
                $totalValuation = 0;

                $entries = $material->noteEntries()->orderBy('created_at', 'asc')->get();
                $requests = $material->noteRequests()->where('state', '=', 'Aceptado')->orderBy('created_at', 'asc')->get();

                $movements = [];

                foreach ($entries as $entry) {
                    $movements[] = [
                        'date' => $entry->pivot->created_at,
                        'type' => 'entry',
                        'description' => $entry->name_supplier . ' - Nota de Entrada #' . $entry->number_note,
                        'quantity' => $entry->pivot->amount_entries,
                        'cost_unit' => number_format($entry->pivot->cost_unit, 2),
                    ];
                }

                foreach ($requests as $request) {
                    $employee = Employee::find($request->user_register);
                    $movements[] = [
                        'date' => $request->pivot->created_at,
                        'type' => 'exit',
                        'description' => ucwords(strtolower("{$employee->first_name} {$employee->last_name} {$employee->mothers_last_name}")) . ' - Solicitud #' . $request->id,
                        'quantity' => $request->pivot->delivered_quantity,
                        'cost_unit' => null,
                    ];
                }
                if (count($movements) === 0) {
                    continue;
                }
                usort($movements, function ($a, $b) {
                    return strtotime($b['date']) - strtotime($a['date']);
                });

                $fifoQueue = [];
                $kardex = [];

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
                            'material' => $material->description,
                            'description' => $movement['description'],
                            'entradas' => $movement['quantity'],
                            'salidas' => 0,
                            'stock_fisico' => $stock,
                            'cost_unit' => number_format($movement['cost_unit'], 2),
                            'cost_total' => number_format(max($totalValuation, 0), 2),
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
                                    'material' => $material->description,
                                    'description' => $movement['description'],
                                    'entradas' => 0,
                                    'salidas' => $quantityToDeliver,
                                    'stock_fisico' => $stock - $quantityToDeliver,
                                    'cost_unit' => number_format($costUnit, 2),
                                    'cost_total' => number_format(max($totalValuation - $costTotal, 0), 2),
                                ];

                                $fifoItem['quantity'] -= $quantityToDeliver;
                                array_unshift($fifoQueue, $fifoItem);
                                $stock -= $quantityToDeliver;
                                $totalValuation = max($totalValuation - $costTotal, 0);
                                $quantityToDeliver = 0;
                            } else {
                                $costUnit = $fifoItem['cost_unit'];
                                $costTotal += $fifoItem['quantity'] * $costUnit;

                                $kardex[] = [
                                    'date' => date('Y-m-d', strtotime($movement['date'])),
                                    'material' => $material->description,
                                    'description' => $movement['description'],
                                    'entradas' => 0,
                                    'salidas' => $fifoItem['quantity'],
                                    'stock_fisico' => $stock - $fifoItem['quantity'],
                                    'cost_unit' => number_format($costUnit, 2),
                                    'cost_total' => number_format(max($totalValuation - $costTotal, 0), 2),
                                ];

                                $quantityToDeliver -= $fifoItem['quantity'];
                                $stock -= $fifoItem['quantity'];
                                $totalValuation = max($totalValuation - $costTotal, 0);
                            }
                        }
                    }
                }
                if (!empty($kardex)) {
                    $kardexGeneral = array_merge($kardexGeneral, $kardex);
                }
            }
            usort($kardexGeneral, function ($a, $b) {
                return strtotime($b['date']) - strtotime($a['date']);
            });
            $kardexGeneral = array_slice($kardexGeneral, 0, 10);

            return response()->json($kardexGeneral);
        } catch (\Exception $e) {
            return response()->json(['error' => 'No se pudo generar el Kardex general'], 500);
        }
    }

    public function ValuedPhysical(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');


        $notesQuery = Note_Entrie::with(['materials.group']);
        if ($startDate && $endDate) {
            $notesQuery->whereBetween('delivery_date', [$startDate, $endDate]);
        }
        $notes = $notesQuery->get();

        $requestsQuery = NoteRequest::with(['materials.group'])->where('state', 'Aceptado');
        if ($startDate && $endDate) {
            $requestsQuery->whereBetween('received_on_date', [$startDate, $endDate]);
        }
        $requests = $requestsQuery->get();

        $materialsByGroup = [];

        foreach ($notes as $note) {
            foreach ($note->materials as $material) {
                $group = $material->group;
                $groupName = $group ? $group->name_group : 'Sin grupo';
                $groupCode = $group ? $group->code : null;

                $materialCode = $material->code_material;
                $materialName = $material->description;
                $materialUnit = $material->unit_material;
                $amountEntries = $material->pivot->amount_entries;
                $costUnit = $material->pivot->cost_unit;

                if (!isset($materialsByGroup[$groupName])) {
                    $materialsByGroup[$groupName] = [
                        'codigo_grupo' => $groupCode,
                        'materiales' => []
                    ];
                }

                if (!isset($materialsByGroup[$groupName]['materiales'][$materialCode])) {
                    $materialsByGroup[$groupName]['materiales'][$materialCode] = [
                        'codigo_material' => $materialCode,
                        'nombre_material' => $materialName,
                        'unidad_material' => $materialUnit,
                        'total_ingresado' => 0,
                        'total_entregado' => 0,
                        'cost_unit_sum' => 0,
                        'num_entries' => 0,
                    ];
                }
                $materialsByGroup[$groupName]['materiales'][$materialCode]['total_ingresado'] += $amountEntries;
                $materialsByGroup[$groupName]['materiales'][$materialCode]['cost_unit_sum'] += $costUnit;
                $materialsByGroup[$groupName]['materiales'][$materialCode]['num_entries'] += 1;
            }
        }

        foreach ($requests as $request) {
            foreach ($request->materials as $material) {
                $group = $material->group;
                $groupName = $group ? $group->name_group : 'Sin grupo';
                $groupCode = $group ? $group->code : null;

                $materialCode = $material->code_material;
                $deliveredQuantity = $material->pivot->delivered_quantity;

                if (!isset($materialsByGroup[$groupName])) {
                    $materialsByGroup[$groupName] = [
                        'codigo_grupo' => $groupCode,
                        'materiales' => []
                    ];
                }

                if (!isset($materialsByGroup[$groupName]['materiales'][$materialCode])) {
                    $materialsByGroup[$groupName]['materiales'][$materialCode] = [
                        'codigo_material' => $materialCode,
                        'nombre_material' => $material->description,
                        'unidad_material' => $material->unit_material,
                        'total_ingresado' => 0,
                        'total_entregado' => 0,
                        'cost_unit_sum' => 0,
                        'num_entries' => 0,
                    ];
                }
                $materialsByGroup[$groupName]['materiales'][$materialCode]['total_entregado'] += $deliveredQuantity;
            }
        }
        $result = [];
        foreach ($materialsByGroup as $groupName => $groupData) {
            $groupResult = [
                'grupo' => $groupName,
                'codigo_grupo' => $groupData['codigo_grupo'],
                'materiales' => []
            ];

            foreach ($groupData['materiales'] as $materialCode => $materialData) {
                $averageCost = $materialData['cost_unit_sum'] / $materialData['num_entries'];
                $groupResult['materiales'][] = [
                    'codigo_material' => $materialData['codigo_material'],
                    'nombre_material' => $materialData['nombre_material'],
                    'unidad_material' => $materialData['unidad_material'],
                    'total_ingresado' => $materialData['total_ingresado'],
                    'total_entregado' => $materialData['total_entregado'],
                    'promedio_costo_unitario' => number_format($averageCost, 2),
                ];
            }

            $result[] = $groupResult;
        }

        $note = Note_Entrie::getFirstNoteOfYear();
        $formattedDate = $note ? Note_Entrie::formatDate($note->delivery_date) : null;

        return response()->json([
            'date_note' => $formattedDate,
            'data' => $result,
        ]);
    }

    public function PrintValuedPhysical(Request $request)
    {

        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');


        $notesQuery = Note_Entrie::with(['materials.group']);
        if ($startDate && $endDate) {
            $notesQuery->whereBetween('delivery_date', [$startDate, $endDate]);
        }
        $notes = $notesQuery->get();

        $requestsQuery = NoteRequest::with(['materials.group'])->where('state', 'Aceptado');
        if ($startDate && $endDate) {
            $requestsQuery->whereBetween('received_on_date', [$startDate, $endDate]);
        }
        $requests = $requestsQuery->get();

        $materialsByGroup = [];

        foreach ($notes as $note) {
            foreach ($note->materials as $material) {
                $group = $material->group;
                $groupName = $group ? $group->name_group : 'Sin grupo';
                $groupCode = $group ? $group->code : null;

                $materialCode = $material->code_material;
                $materialName = $material->description;
                $materialUnit = $material->unit_material;
                $amountEntries = $material->pivot->amount_entries;
                $costUnit = $material->pivot->cost_unit;

                if (!isset($materialsByGroup[$groupName])) {
                    $materialsByGroup[$groupName] = [
                        'codigo_grupo' => $groupCode,
                        'materiales' => []
                    ];
                }

                if (!isset($materialsByGroup[$groupName]['materiales'][$materialCode])) {
                    $materialsByGroup[$groupName]['materiales'][$materialCode] = [
                        'codigo_material' => $materialCode,
                        'nombre_material' => $materialName,
                        'unidad_material' => $materialUnit,
                        'total_ingresado' => 0,
                        'total_entregado' => 0,
                        'cost_unit_sum' => 0,
                        'num_entries' => 0,
                    ];
                }
                $materialsByGroup[$groupName]['materiales'][$materialCode]['total_ingresado'] += $amountEntries;
                $materialsByGroup[$groupName]['materiales'][$materialCode]['cost_unit_sum'] += $costUnit;
                $materialsByGroup[$groupName]['materiales'][$materialCode]['num_entries'] += 1;
            }
        }

        foreach ($requests as $request) {
            foreach ($request->materials as $material) {
                $group = $material->group;
                $groupName = $group ? $group->name_group : 'Sin grupo';
                $groupCode = $group ? $group->code : null;

                $materialCode = $material->code_material;
                $deliveredQuantity = $material->pivot->delivered_quantity;

                if (!isset($materialsByGroup[$groupName])) {
                    $materialsByGroup[$groupName] = [
                        'codigo_grupo' => $groupCode,
                        'materiales' => []
                    ];
                }

                if (!isset($materialsByGroup[$groupName]['materiales'][$materialCode])) {
                    $materialsByGroup[$groupName]['materiales'][$materialCode] = [
                        'codigo_material' => $materialCode,
                        'nombre_material' => $material->description,
                        'unidad_material' => $material->unit_material,
                        'total_ingresado' => 0,
                        'total_entregado' => 0,
                        'cost_unit_sum' => 0,
                        'num_entries' => 0,
                    ];
                }
                $materialsByGroup[$groupName]['materiales'][$materialCode]['total_entregado'] += $deliveredQuantity;
            }
        }
        $result = [];
        foreach ($materialsByGroup as $groupName => $groupData) {
            $groupResult = [
                'grupo' => $groupName,
                'codigo_grupo' => $groupData['codigo_grupo'],
                'materiales' => []
            ];

            foreach ($groupData['materiales'] as $materialCode => $materialData) {
                $averageCost = $materialData['cost_unit_sum'] / $materialData['num_entries'];
                $groupResult['materiales'][] = [
                    'codigo_material' => $materialData['codigo_material'],
                    'nombre_material' => $materialData['nombre_material'],
                    'unidad_material' => $materialData['unidad_material'],
                    'total_ingresado' => $materialData['total_ingresado'],
                    'total_entregado' => $materialData['total_entregado'],
                    'promedio_costo_unitario' => number_format($averageCost, 2),
                ];
            }

            $result[] = $groupResult;
        }

        $note = Note_Entrie::getFirstNoteOfYear();
        $formattedDate = $note ? Note_Entrie::formatDate($note->delivery_date) : null;



        $data = [
            'title' => 'INVENTARIO FISICO VALORADO ALMACENES MUSERPOL',
            'results' => $result,
            'date_note' => $formattedDate,
        ];

        $pdf = Pdf::loadView('ValuedPhysical.ValuedPhysical', $data)->setPaper('letter', 'landscape');
        return $pdf->stream('Inventario Fisico Valorado.pdf');
    }
}
