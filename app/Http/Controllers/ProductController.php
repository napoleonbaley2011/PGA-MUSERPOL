<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function list_petty_cash() {
        $query = Product::all();
        return $query;
    }

    public function create_product(Request $request)
    {
        logger($request);
        $validate = $request->validate([
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'unit' => 'required|string|max:255',
            'price_unit' => 'required|numeric',
            'total' => 'required|numeric'
        ]);
        logger($validate);
        return $request;
    }
}
