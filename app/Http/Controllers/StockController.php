<?php

namespace App\Http\Controllers;

use App\Models\StockTransaction;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StockController extends Controller
{
    // Display stock transactions
    public function index()
    {
        $transactions = StockTransaction::with(['product', 'user'])->orderBy('created_at', 'desc')->paginate(20);
        return view('admin.stock.index', compact('transactions'));
    }

    // Show form to add stock transaction (in or out)
    public function create()
    {
        $products = Product::all();
        return view('admin.stock.create', compact('products'));
    }

    // Store stock transaction
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'type' => 'required|in:in,out',
            'quantity' => 'required|integer|min:1',
            'description' => 'nullable|string',
        ]);

        $validated['user_id'] = Auth::id();

        StockTransaction::create($validated);

        // Update product stock
        $product = Product::findOrFail($validated['product_id']);
        if ($validated['type'] === 'in') {
            $product->increment('stock', $validated['quantity']);
        } else {
            $product->decrement('stock', $validated['quantity']);
        }

        return redirect()->route('admin.stock.index')->with('success', 'Stock transaction recorded successfully.');
    }

    // Stock opname view and update methods can be added here later

    // Minimum stock settings can be managed via settings controller or here
}
