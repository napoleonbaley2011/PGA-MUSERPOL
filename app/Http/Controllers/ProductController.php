<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Fund;
use App\Models\Group;
use App\Models\Management;
use App\Models\Material;
use App\Models\PettyCash;
use App\Models\Product;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{

    public function list_petty_cash_user($userId)
    {
        $notePettyCash = PettyCash::where('user_register', $userId)->with('products')->orderBy('id', 'desc')->get();
        return $notePettyCash;
    }

    public function list_petty_cash()
    {
        $query = Product::all();
        return $query;
    }

    public function create_product(Request $request)
    {
        try {
            $validate = $request->validate([
                'description' => 'required|string|max:255',
                'object' => 'required|string|max:255',
            ]);
            $validate['description'] = strtoupper($validate['description']);
            $validate['object'] = strtoupper($validate['object']);

            $product = Product::create([
                'description' => $validate['description'],
                'cost_object' => $validate['object'],
            ]);
            return response()->json([
                'message' => 'Producto creado correctamente',
                'material' => $product,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Ocurrió un error: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function create_note(Request $request)
    {
        $lastNoteNumber = PettyCash::max('number_note');
        $number_note = $lastNoteNumber ? $lastNoteNumber + 1 : 1;
        $period = Management::latest()->first();
        $fund = Fund::latest()->first();

        $approximate_cost = 0;

        foreach ($request['product'] as $productData) {
            $approximate_cost += $productData['quantity'] * $productData['price'];
        }

        $notePettyCash = PettyCash::create([
            'number_note' => $number_note,
            'concept' => $request['concept'],
            'request_date' => today()->toDateString(),
            'approximate_cost' => $approximate_cost,
            'state' => 'En Revision',
            'user_register' => $request['id'],
            'management_id' => $period->id,
            'fund_id' => $fund->id,

        ]);

        foreach ($request['product'] as $productData) {
            $notePettyCash->products()->attach($productData['id'], [
                'amount_request' => $productData['quantity'],
                'name_product' => $productData['description'],
                'costDetails' => $productData['price']
            ]);
        }


        return response()->json($notePettyCash->load('products'), 201);
    }


    public function print_Petty_Cash(PettyCash $notepettyCash)
    {
        $user = User::where('employee_id', $notepettyCash->user_register)->first();
        if ($user) {
            $cargo = DB::table('public.contracts as c')
                ->join('public.positions as p', 'c.position_id', '=', 'p.id')
                ->join('public.employees as e', 'c.employee_id', '=', 'e.id')
                ->join('public.position_groups as pg', 'p.position_group_id', '=', 'pg.id')
                ->select('c.employee_id', 'e.first_name', 'e.last_name', 'e.mothers_last_name', 'p.name as position_name', 'pg.name as group_name', 'pg.id as group_id')
                ->where('c.active', true)
                ->whereNull('c.deleted_at')
                ->whereIn('pg.id', [7, 8, 9, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21])
                ->where('c.employee_id', $notepettyCash->user_register)
                ->unionAll(
                    DB::table('public.consultant_contracts as cc')
                        ->join('public.consultant_positions as cp', 'cc.consultant_position_id', '=', 'cp.id')
                        ->join('public.employees as e', 'cc.employee_id', '=', 'e.id')
                        ->join('public.position_groups as pg', 'cp.position_group_id', '=', 'pg.id')
                        ->select('cc.employee_id', 'e.first_name', 'e.last_name', 'e.mothers_last_name', 'cp.name as position_name', 'pg.name as group_name', 'pg.id as group_id')
                        ->where('cc.active', true)
                        ->whereNull('cc.deleted_at')
                        ->whereIn('pg.id', [7, 8, 9, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21])
                        ->where('cc.employee_id', $notepettyCash->user_register)
                )
                ->get();
            $positionName = isset($cargo[0]) ? $cargo[0]->position_name : null;
            $employee = Employee::find($notepettyCash->user_register);


            $products = $notepettyCash->products()->get()->map(function ($product) {
                return [
                    'description' => $product->description,
                    'quantity' => $product->pivot->amount_request,
                    'price' => $product->pivot->costDetails,
                ];
            });
            $totalDesembolso = $products->reduce(function ($carry, $product) {
                return $carry + ($product['quantity'] * $product['price']);
            }, 0);

            $data = [
                'title' => 'VALE DE CAJA CHICA',
                'number_note' => $notepettyCash->number_note,
                'date' => Carbon::now()->format('Y'),
                'employee' => $employee
                    ? "{$employee->first_name} {$employee->last_name} {$employee->mothers_last_name}"
                    : null,
                'position' => $positionName,
                'products' => $products,
                'concept' => $notepettyCash->concept,
                'total' => $totalDesembolso,
            ];

            $pdf = Pdf::loadView('NotePettyCash.NotePettyCash', $data);
            return $pdf->download('Vale_caja_chica.pdf');
        } else {
            $employee = Employee::where('id', $notepettyCash->user_register)->first();
            if ($employee) {
                $position = DB::selectOne('select cp."name" 
                           from public.consultant_contracts cc, public.consultant_positions cp 
                           where cc.employee_id = ? 
                           and cp.id = cc.consultant_position_id 
                           order by cc.consultant_position_id desc 
                           limit 1', [$notepettyCash->user_register]);

                // Asigna solo el nombre de la posición o un valor nulo si no se encuentra
                $positionName = $position ? $position->name : null;
                $employee = Employee::find($notepettyCash->user_register);


                $products = $notepettyCash->products()->get()->map(function ($product) {
                    return [
                        'description' => $product->description,
                        'quantity' => $product->pivot->amount_request,
                        'price' => $product->pivot->costDetails,
                    ];
                });
                $totalDesembolso = $products->reduce(function ($carry, $product) {
                    return $carry + ($product['quantity'] * $product['price']);
                }, 0);

                $data = [
                    'title' => 'VALE DE CAJA CHICA',
                    'number_note' => $notepettyCash->number_note,
                    'date' => Carbon::now()->format('Y'),
                    'employee' => $employee
                        ? "{$employee->first_name} {$employee->last_name} {$employee->mothers_last_name}"
                        : null,
                    'position' => $positionName,
                    'products' => $products,
                    'concept' => $notepettyCash->concept,
                    'total' => $totalDesembolso,
                ];

                $pdf = Pdf::loadView('NotePettyCash.NotePettyCash', $data);
                return $pdf->download('Vale_caja_chica.pdf');
            }
        }
    }

    public function verify(Request $request)
    {
        $materials = Material::where('stock', '>', 0)
            ->where('state', 'Habilitado')
            ->where('description', 'not like', '%CAJA CHICA%')
            ->get();
        $products = $request->input('product');
        $similarProducts = [];

        foreach ($products as $product) {
            $productDescription = $product['description'];
            foreach ($materials as $material) {
                $productDescLower = strtolower($productDescription);
                $materialDescLower = strtolower($material->description);


                if (str_contains($materialDescLower, $productDescLower)) {
                    $similarProducts[] = [
                        'product_description' => $productDescription,
                        'material_description' => $material->description,
                        'similarity' => 100,
                    ];
                    continue;
                }
                $levenshteinDistance = levenshtein($productDescLower, $materialDescLower);
                $maxLength = max(strlen($productDescLower), strlen($materialDescLower));
                $similarity = 1 - ($levenshteinDistance / $maxLength);
                if ($similarity >= 0.7) {
                    $similarProducts[] = [
                        'product_description' => $productDescription,
                        'material_description' => $material->description,
                        'similarity' => round($similarity * 100, 2),
                    ];
                }
            }
        }

        return response()->json(['similar_products' => $similarProducts]);
    }

    public function list_group()
    {
        $groups = Group::all()->map(function ($group) {
            return [
                'id' => $group->id,
                'details' => "{$group->code} - {$group->name_group}"
            ];
        });

        return $groups;
    }


    public function save_petty_cash(Request $request)
    {
        try {
            $pettyCash = PettyCash::find($request['requestId']);

            if (!$pettyCash) {
                return response()->json(['error' => 'PettyCash not found.'], 404);
            }
            $sum_product = 0;

            foreach ($request['products'] as $productData) {
                $product = Product::where('description', $productData['description'])->first();

                if (!$product) {
                    return response()->json(['error' => 'Product not found.'], 404);
                }

                $product->group_id = $productData['id_group'];
                $product->save();
                $sum_product += $productData['total'];

                $pettyCash->products()->syncWithoutDetaching([
                    $product->id => [
                        'supplier' => $productData['supplier'],
                        'number_invoice' => $productData['numer_invoice'],
                        'costFinal' => $productData['total'],
                    ],
                ]);
            }

            $pettyCash->replacement_cost = $sum_product;
            $pettyCash->delivery_date = today()->toDateString();
            $pettyCash->state = 'Finalizado';
            $pettyCash->save();

            return response()->json(['message' => 'Petty cash updated successfully.'], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An error occurred while saving petty cash.',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function print_Petty_Cash_discharge(PettyCash $notepettyCash)
    {
        $requests_date = $notepettyCash->request_date;
        $products = $notepettyCash->products()->get()->map(function ($product) {
            $group = Group::where('id', $product->group_id)->first();
            $codeGroup = $group ? $group->code : null;
            return [
                'description' => $product->description,
                'quantity' => $product->pivot->amount_request,
                'supplier' => $product->pivot->supplier,
                'number_invoice' => $product->pivot->number_invoice,
                'cost_object' => $product->cost_object,
                'code_group' => $codeGroup,
                'price' => $product->pivot->costDetails,
                'total' =>  $product->pivot->costFinal
            ];
        });

        $data = [
            'title' => 'DESCARGO DE CAJA CHICA',
            'number_note' => $notepettyCash->number_note,
            'date' => Carbon::now()->format('Y'),
            'request_date' => $requests_date,
            'concept' => $notepettyCash->concept,
            'products' => $products
        ];
        $pdf = Pdf::loadView('NotePettyCash.NotePettyCashForm', $data);
        return $pdf->download('Vale_caja_chica_form_2.pdf');
    }
}
