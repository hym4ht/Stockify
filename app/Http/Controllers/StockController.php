<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class StockController extends Controller
{
    public function info()
    {
        $products = Product::all();
        return view('admin.stock.info', compact('products'));
    }

    public function settings()
    {
        $products = Product::all();
        return view('admin.stock.settings', compact('products'));
    }

    public function updateSettings(Request $request)
    {
        $data = $request->validate([
            'minimum_stock' => 'required|array',
            'minimum_stock.*' => 'required|integer|min:0',
        ]);

        foreach ($data['minimum_stock'] as $productId => $minStock) {
            $product = Product::find($productId);
            if ($product) {
                $product->minimum_stock = $minStock;
                $product->save();
            }
        }

        return redirect()->route('admin.stock.settings')->with('success', 'Minimum stock settings updated successfully.');
    }
}
