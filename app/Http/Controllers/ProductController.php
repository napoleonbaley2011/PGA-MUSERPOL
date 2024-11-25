<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{

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
}
