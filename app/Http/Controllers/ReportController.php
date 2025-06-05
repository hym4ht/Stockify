<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockTransaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    // Stock report per period and category
    public function stockReport(Request $request)
    {
        $query = Product::query();

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $products = $query->with('category')->get();

        // Calculate remaining stock for each product
        $productIds = $products->pluck('id')->toArray();

        $stockSums = StockTransaction::confirmed()
            ->whereIn('product_id', $productIds)
            ->selectRaw('product_id, type, SUM(quantity) as total_quantity')
            ->groupBy('product_id', 'type')
            ->get()
            ->groupBy('product_id');

        foreach ($products as $product) {
            $stockIn = $stockSums->has($product->id) ? $stockSums[$product->id]->where('type', 'in')->sum('total_quantity') : 0;
            $stockOut = $stockSums->has($product->id) ? $stockSums[$product->id]->where('type', 'out')->sum('total_quantity') : 0;
            $product->setAttribute('remaining_stock', $stockIn - $stockOut);
        }

        return view('admin.reports.stock', compact('products'));
    }

    // Transaction report for stock in/out per period
    public function transactionReport(Request $request)
    {
        $query = StockTransaction::with(['product', 'user']);

        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        $transactions = $query->get();

        return view('admin.reports.transactions', compact('transactions'));
    }

    // User activity report
    public function userActivityReport(Request $request)
    {
        $query = StockTransaction::with('user');

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        $activities = $query->get();

        $users = User::all();

        return view('admin.reports.user_activity', compact('activities', 'users'));
    }
}
