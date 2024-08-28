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
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');

        $note = Note_Entrie::getFirstNoteOfYear();


        if ($note) {
            $formattedDate = Note_Entrie::formatDate($note->created_at);
        }

        $groups = Group::whereHas('materials.noteEntries')
            ->with(['materials' => function ($query) {
                $query->whereHas('noteEntries')
                    ->with(['noteEntries' => function ($q) {
                        $q->withPivot('amount_entries', 'cost_unit', 'cost_total');
                    }]);
            }])
            ->get();

        $result = $groups->map(function ($group) {
            return [
                'group_code' => $group->code,
                'group_name' => $group->name_group,
                'materials' => $group->materials->map(function ($material) {
                    $totalAmountEntries = 0;
                    $totalCost = 0;
                    $costUnitSum = 0;
                    $noteEntriesCount = $material->noteEntries->count();

                    foreach ($material->noteEntries as $noteEntry) {
                        $amountEntries = $noteEntry->pivot->amount_entries;
                        $costUnit = round((float) $noteEntry->pivot->cost_unit, 2);
                        $totalAmountEntries += $amountEntries;
                        $totalCost += round($amountEntries * $costUnit, 2);
                        $costUnitSum += $costUnit;
                    }

                    return [
                        'material_code' => $material->code_material,
                        'description' => $material->description,
                        'unit' => $material->unit_material,
                        'state' => $material->state,
                        'stock' => $material->stock,
                        'barcode' => $material->barcode,
                        'type' => $material->type,
                        'average_cost_unit' => $noteEntriesCount > 0 ? round($costUnitSum / $noteEntriesCount, 2) : 0,
                        'total_amount_entries' => $totalAmountEntries,
                        'total_cost' => $totalCost,
                    ];
                }),
            ];
        });
        return response()->json([
            'data' => $result,
            'date_note' => $formattedDate,
        ]);
    }

    public function PrintValuedPhysical(Request $request)
    {
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');

        $note = Note_Entrie::getFirstNoteOfYear();


        if ($note) {
            $formattedDate = Note_Entrie::formatDate($note->created_at);
        }

        $groups = Group::whereHas('materials.noteEntries')
            ->with(['materials' => function ($query) {
                $query->whereHas('noteEntries')
                    ->with(['noteEntries' => function ($q) {
                        $q->withPivot('amount_entries', 'cost_unit', 'cost_total');
                    }]);
            }])
            ->get();

        $result = $groups->map(function ($group) {
            return [
                'group_code' => $group->code,
                'group_name' => $group->name_group,
                'materials' => $group->materials->map(function ($material) {
                    $totalAmountEntries = 0;
                    $totalCost = 0;
                    $costUnitSum = 0;
                    $noteEntriesCount = $material->noteEntries->count();

                    foreach ($material->noteEntries as $noteEntry) {
                        $amountEntries = $noteEntry->pivot->amount_entries;
                        $costUnit = round((float) $noteEntry->pivot->cost_unit, 2);
                        $totalAmountEntries += $amountEntries;
                        $totalCost += round($amountEntries * $costUnit, 2);
                        $costUnitSum += $costUnit;
                    }

                    return [
                        'material_code' => $material->code_material,
                        'description' => $material->description,
                        'unit' => $material->unit_material,
                        'state' => $material->state,
                        'stock' => $material->stock,
                        'barcode' => $material->barcode,
                        'type' => $material->type,
                        'average_cost_unit' => $noteEntriesCount > 0 ? round($costUnitSum / $noteEntriesCount, 2) : 0,
                        'total_amount_entries' => $totalAmountEntries,
                        'total_cost' => $totalCost,
                    ];
                }),
            ];
        });
        $data = [
            'title' => 'INVENTARIO FISICO VALORADO ALMACENES MUSERPOL',
            'results' => $result,
            'date_note' => $formattedDate,
        ];

        $pdf = Pdf::loadView('ValuedPhysical.ValuedPhysical', $data)->setPaper('letter', 'landscape');
        return $pdf->stream('Inventario Fisico Valorado.pdf');
    }
}
