<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\StockOpname;

class StockOpnameController extends Controller
{
    public function index()
    {
        $stockOpnames = StockOpname::with('product')->latest()->get();
        return view('admin.stock-opname.index', compact('stockOpnames'));
    }

    public function create()
    {
        $products = Product::all();
        return view('admin.stock-opname.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'qty_actual' => 'required|integer|min:0',
            'notes' => 'nullable|string'
        ]);

        $product = Product::findOrFail($request->product_id);
        $qty_system = $product->stock;

        StockOpname::create([
            'product_id' => $product->id,
            'qty_actual' => $request->qty_actual,
            'qty_system' => $qty_system,
            'notes' => $request->notes
        ]);

        return redirect()->route('admin.stock-opname.index')->with('success', 'Stock opname berhasil disimpan.');
    }
}
