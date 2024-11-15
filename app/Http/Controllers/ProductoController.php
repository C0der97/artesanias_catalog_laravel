<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductoController extends Controller
{
    public function index(){
        $productos = Product::all();
        return response()->json($productos);
    }
}
