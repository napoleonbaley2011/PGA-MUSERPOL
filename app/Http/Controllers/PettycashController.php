<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Fund;
use App\Models\Group;
use App\Models\PettyCash;
use App\Models\Product;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PettycashController extends Controller
{
    public function Accountability_sheet()
    {
        $pettyCashes = PettyCash::where('state', 'Finalizado')
            ->with('products')
            ->get();

        $products = $pettyCashes->flatMap(function ($pettyCash) {
            $date = $pettyCash->delivery_date;

            return $pettyCash->products->map(function ($product) use ($date) {
                $group = Group::where('id', $product->group_id)->first();
                $code = $group ? $group->code : null;

                return [
                    'delivery_date' => $date,
                    'number_invoice' => $product->pivot->number_invoice,
                    'partida' => $product->group_id,
                    'code' => $code,
                    'description' => $product->cost_object,
                    'amount' => $product->pivot->costFinal,
                ];
            });
        });

        $allGroups = Group::all();

        $groupsSummary = $allGroups->map(function ($group) use ($products) {
            $groupedProducts = $products->where('partida', $group->id);
            return [
                'code' => $group->code,
                'name_group' => $group->name_group,
                'total_amount' => $groupedProducts->sum('amount'),
            ];
        });
        $fund = Fund::latest()->first();
        logger($fund->received_amount);

        return [
            'products' => $products->values(),
            'groups_summary' => $groupsSummary,
        ];
    }

    public function Print_Accountability_sheet()
    {
        $pettyCashes = PettyCash::where('state', 'Finalizado')
            ->with('products')
            ->get();

        $products = $pettyCashes->flatMap(function ($pettyCash) {
            $date = $pettyCash->delivery_date;

            return $pettyCash->products->map(function ($product) use ($date) {
                $group = Group::where('id', $product->group_id)->first();
                $code = $group ? $group->code : null;

                return [
                    'delivery_date' => $date,
                    'number_invoice' => $product->pivot->number_invoice,
                    'partida' => $product->group_id,
                    'code' => $code,
                    'description' => $product->cost_object,
                    'amount' => $product->pivot->costFinal,
                ];
            });
        });

        $allGroups = Group::all();

        $groupsSummary = $allGroups->map(function ($group) use ($products) {
            $groupedProducts = $products->where('partida', $group->id);
            return [
                'code' => $group->code,
                'name_group' => $group->name_group,
                'total_amount' => $groupedProducts->sum('amount'),
            ];
        });

        $fund = Fund::latest()->first();
        logger($fund->received_amount);

        $data = [
            'title' => 'PLANILLA DE RENDICIÓN DE CUENTAS',
            'date' => Carbon::now()->format('Y'),
            'date_first' => Carbon::now()->format('Y-m-d'),
            'area' => 'UNIDAD ADMINISTRATIVA',
            'date_of_receipt_of_funds' => $fund->reception_date,
            'fund' => $fund->received_amount,
            'products' => $products,
            'groups_summary' => $groupsSummary,
        ];

        $pdf = Pdf::loadView('NotePettyCash.AccountabilitySheet', $data);
        return $pdf->download('Planilla_de_rendicion_de_cuentas.pdf');
    }


    public function Petty_Cash_Record_Book()
    {
        $pettyCashes = PettyCash::where('state', 'Finalizado')
            ->with(['products' => function ($query) {
                $query->select('products.id', 'description', 'group_id', 'cost_object');
            }])
            ->get(['id', 'user_register', 'number_note', 'approximate_cost', 'replacement_cost']);

        $formatted = $pettyCashes->map(function ($pettyCash) {
            $employee = Employee::find($pettyCash->user_register);
            return [
                'user_register' => $employee
                    ? "{$employee->first_name} {$employee->last_name} {$employee->mothers_last_name}"
                    : null,
                'number_note' => $pettyCash->number_note,
                'approximate_cost' => $pettyCash->approximate_cost,
                'replacement_cost' => $pettyCash->replacement_cost,
                'products' => $pettyCash->products->map(function ($product) {
                    $group = Group::where('id', $product->group_id)->first();
                    $codeGroup = $group ? $group->code : null;
                    return [
                        'id' => $product->id,
                        'description' => $product->description,
                        'object_cost' => $product->cost_object,
                        'code' => $codeGroup,
                        'supplier' => $product->pivot->supplier,
                        'invoce_number' => $product->pivot->number_invoice,
                        'costDetail' => number_format($product->pivot->costDetails, 2),
                        'costFinal' => number_format($product->pivot->costFinal, 2),
                    ];
                }),
            ];
        });
        return response()->json($formatted);
    }



    public function Print_Petty_Cash_Record_Book()
    {
        $pettyCashes = PettyCash::where('state', 'Finalizado')
            ->with(['products' => function ($query) {
                $query->select('products.id', 'description', 'group_id', 'cost_object');
            }])
            ->get(['id', 'user_register', 'number_note', 'request_date', 'approximate_cost', 'replacement_cost']);

        $formatted = $pettyCashes->map(function ($pettyCash) {
            $employee = Employee::find($pettyCash->user_register);
            return [
                'user_register' => $employee
                    ? "{$employee->first_name} {$employee->last_name} {$employee->mothers_last_name}"
                    : null,
                'number_note' => $pettyCash->number_note,
                'date_delivery' => $pettyCash->request_date,
                'approximate_cost' => $pettyCash->approximate_cost,
                'replacement_cost' => $pettyCash->replacement_cost,
                'products' => $pettyCash->products->map(function ($product) {
                    $group = Group::where('id', $product->group_id)->first();
                    $codeGroup = $group ? $group->code : null;
                    return [
                        'id' => $product->id,
                        'description' => $product->description,
                        'object_cost' => $product->cost_object,
                        'code' => $codeGroup,
                        'supplier' => $product->pivot->supplier,
                        'invoce_number' => $product->pivot->number_invoice,
                        'costDetail' => number_format($product->pivot->costDetails, 2),
                        'costFinal' => number_format($product->pivot->costFinal, 2),
                    ];
                }),
            ];
        });
        $replacementCostTotal = $formatted->sum('replacement_cost');

        $fund = Fund::latest()->first();


        $balance_total = $fund->received_amount - $replacementCostTotal;
        $dataPettyCash = [
            'amount' => $fund->received_amount,
            'date_recived' => $fund->reception_date,
            'name_responsibility' => $fund->name_responsible,
            'concept' => 'ASIGNACIÓN DE FONDOS DE CAJA CHICA',
            'balance' => number_format($balance_total, 2),
        ];


        $data = [
            'title' => 'LIBRO DE REGISTRO DE CAJA CHICA',
            'name' => 'WILLIAM ITURRALDE QUISBERT',
            'area' => 'UNIDAD ADMINISTRATIVA',
            'date' => Carbon::now()->format('Y-m-d'),
            'dataPettyCash' => $dataPettyCash,
            'book_diary' => $formatted,
        ];

        $pdf = Pdf::loadView('NotePettyCash.PettyCashRecordBook', $data);
        return $pdf->download('Libro_Diario.pdf');
    }
}
