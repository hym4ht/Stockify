<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ManagerProductController extends Controller
{
    // Display a listing of products for manager
    public function index()
    {
        $products = Product::all();
        return view('manager.products.index', compact('products'));
    }

    // Display the specified product detail for manager
    public function show(Product $product)
    {
        return view('manager.products.show', compact('product'));
    }

    // Show form to edit stock quantities


    // Update stock quantities
    public function updateStock(Request $request, Product $product)
    {
        $validated = $request->validate([
            'physical_stock' => 'required|integer|min:0',
            'lost_damaged_stock' => 'required|integer|min:0',
        ]);

        // Here, update stock transactions or product stock accordingly
        // For simplicity, update product stock directly and create stock transactions for lost/damaged stock

        // Update product stock (physical stock)
        $product->stock = $validated['physical_stock'];
        $product->save();

        // Create or update stock transaction for lost/damaged stock
        // For simplicity, create a new stock transaction record for lost/damaged stock adjustment
        if ($validated['lost_damaged_stock'] > 0) {
            $product->stockTransactions()->create([
                'type' => 'out',
                'quantity' => $validated['lost_damaged_stock'],
                'damaged_lost_goods' => $validated['lost_damaged_stock'],
                'description' => 'Adjustment for lost/damaged stock',
                'status' => 'confirmed',
                'user_id' => auth()->id(),
                'confirmed_by' => auth()->id(),
                'confirmed_at' => now(),
            ]);
        }

        return redirect()->route('manager.products.index')->with('success', 'Stock updated successfully.');
    }
}
