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

        // Filter by category
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Filter by product attribute name and value
        if ($request->filled('attribute_name') && $request->filled('attribute_value')) {
            $query->whereHas('attributes', function ($q) use ($request) {
                $q->where('name', $request->attribute_name)
                  ->where('value', $request->attribute_value);
            });
        }

        $products = $query->with('category')->get();

        $productIds = $products->pluck('id')->toArray();

        // Filter stock transactions by period and product ids
        $stockTransactionsQuery = StockTransaction::confirmed()
            ->whereIn('product_id', $productIds);

        if ($request->filled('start_date')) {
            $stockTransactionsQuery->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $stockTransactionsQuery->whereDate('created_at', '<=', $request->end_date);
        }

        $stockSums = $stockTransactionsQuery
            ->selectRaw('product_id, type, SUM(quantity) as total_quantity')
            ->groupBy('product_id', 'type')
            ->get()
            ->groupBy('product_id');

        // Fetch categories for filter dropdown
        $categories = \App\Models\Category::all();

        // Fetch distinct attribute names and values for filter dropdowns
        $attributeNames = \App\Models\ProductAttribute::select('name')->distinct()->pluck('name');
        $attributeValues = [];
        if ($request->filled('attribute_name')) {
            $attributeValues = \App\Models\ProductAttribute::where('name', $request->attribute_name)->distinct()->pluck('value');
        }

        return view('admin.reports.stock', compact('products', 'stockSums', 'categories', 'attributeNames', 'attributeValues'));
    }

    // Transaction report for stock in/out per single date
    public function transactionReport(Request $request)
    {
        $query = StockTransaction::with(['product', 'confirmedBy']);

        if ($request->filled('date')) {
            $query->whereDate('confirmed_at', $request->date);
        } else {
            $query->whereDate('confirmed_at', date('Y-m-d'));
        }

        $transactions = $query->get();

        return view('admin.reports.transactions', compact('transactions'));
    }

    // User activity report
    public function userActivityReport(Request $request)
    {
        $query = StockTransaction::with(['user', 'product', 'confirmedBy']);

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('confirmed_by')) {
            $query->where('confirmed_by', $request->confirmed_by);
        }

        $activities = $query->get();

        $users = User::all();

        return view('admin.reports.user_activity', compact('activities', 'users'));
    }
}
