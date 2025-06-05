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
        $validated['status'] = 'pending'; // Set status to pending on creation

        StockTransaction::create($validated);

        // Do NOT update product stock here; stock will be updated on confirmation

        $today = date('Y-m-d');
        return redirect()->route('admin.dashboard', ['start_date' => $today, 'end_date' => $today])->with('success', 'Stock transaction recorded successfully.');
    }

    // Confirm stock transaction (receipt or issuance) by staf gudang
    public function confirmTransaction($id)
    {
        $user = auth()->user();

        if ($user->role !== 'Staff Gudang') {
            abort(403, 'Unauthorized action.');
        }

        $transaction = StockTransaction::findOrFail($id);

        if ($transaction->status !== 'pending') {
            return redirect()->back()->with('error', 'Transaction already confirmed or invalid status.');
        }

        $transaction->status = 'confirmed';
        $transaction->confirmed_by = $user->id;
        $transaction->confirmed_at = now();
        $transaction->save();

        // Adjust stock only on confirmation
        $product = $transaction->product;

        if ($transaction->type === 'out') {
            if ($product->stock >= $transaction->quantity) {
                $product->decrement('stock', $transaction->quantity);
            } else {
                return redirect()->back()->with('error', 'Insufficient stock to confirm this transaction.');
            }
        } elseif ($transaction->type === 'in') {
            $product->increment('stock', $transaction->quantity);
        }

        return redirect()->back()->with('success', 'Transaction confirmed successfully.');
    }

    // Show form to edit stock transaction
    public function edit($id)
    {
        $transaction = StockTransaction::findOrFail($id);
        $products = Product::all();
        return view('admin.stock.edit', compact('transaction', 'products'));
    }

    // Update stock transaction
    public function update(Request $request, $id)
    {
        $transaction = StockTransaction::findOrFail($id);

        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'type' => 'required|in:in,out',
            'quantity' => 'required|integer|min:1',
            'description' => 'nullable|string',
        ]);

        // Adjust stock based on difference in quantity and type
        $oldQuantity = $transaction->quantity;
        $oldType = $transaction->type;

        $transaction->product_id = $validated['product_id'];
        $transaction->type = $validated['type'];
        $transaction->quantity = $validated['quantity'];
        $transaction->description = $validated['description'] ?? null;
        $transaction->save();

        $product = Product::findOrFail($validated['product_id']);

        // Revert old stock adjustment
        if ($oldType === 'in') {
            $product->decrement('stock', $oldQuantity);
        } else {
            $product->increment('stock', $oldQuantity);
        }

        // Apply new stock adjustment
        if ($validated['type'] === 'in') {
            $product->increment('stock', $validated['quantity']);
        } else {
            if ($product->stock < $validated['quantity']) {
                return redirect()->back()->with('error', 'Insufficient stock for this transaction.');
            }
            $product->decrement('stock', $validated['quantity']);
        }

        return redirect()->route('admin.stock.index')->with('success', 'Stock transaction updated successfully.');
    }

    // Delete stock transaction
    public function destroy($id)
    {
        $transaction = StockTransaction::findOrFail($id);
        $product = $transaction->product;

        // Revert stock adjustment
        if ($transaction->type === 'in') {
            $product->decrement('stock', $transaction->quantity);
        } else {
            $product->increment('stock', $transaction->quantity);
        }

        $transaction->delete();

        return redirect()->route('admin.stock.index')->with('success', 'Stock transaction deleted successfully.');
    }

    // Stock opname view and update methods can be added here later

    // Minimum stock settings can be managed via settings controller or here
}
