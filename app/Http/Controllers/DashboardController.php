<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockTransaction;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Since role-based access is handled by middleware, no need to check role here
        // You can customize dashboard data per role if needed by separate controllers or views

        // For example, just redirect to admin dashboard or staf dashboard based on role
        $user = $request->user();

        if ($user->role === 'Admin') {
            // Admin dashboard data
            $productCount = Product::count();

            $startDate = $request->input('start_date', \Carbon\Carbon::now()->subDays(29)->toDateString());
            $endDate = $request->input('end_date', \Carbon\Carbon::now()->addDay()->toDateString());

            $transactionsInCount = StockTransaction::confirmed()->where('type', 'in')
                ->whereBetween('confirmed_at', [$startDate, $endDate])
                ->count();

            $transactionsOutCount = StockTransaction::confirmed()->where('type', 'out')
                ->whereBetween('confirmed_at', [$startDate, $endDate])
                ->count();

            $recentActivities = StockTransaction::confirmed()->with('user', 'product')
                ->orderBy('confirmed_at', 'desc')
                ->limit(10)
                ->get();
                

            $stockData = StockTransaction::confirmed()->selectRaw('DATE(confirmed_at) as date, type, SUM(quantity) as total_quantity')
                ->whereBetween('confirmed_at', [$startDate, $endDate])
                ->groupBy('date', 'type')
                ->orderBy('date')
                ->get();

            $dates = [];
            $stockInData = [];
            $stockOutData = [];

            $period = new \DatePeriod(
                new \DateTime($startDate),
                new \DateInterval('P1D'),
                (new \DateTime($endDate))->modify('+1 day')
            );

            foreach ($period as $date) {
                $dates[] = $date->format('Y-m-d');
                $stockInData[$date->format('Y-m-d')] = 0;
                $stockOutData[$date->format('Y-m-d')] = 0;
            }

            foreach ($stockData as $data) {
                if ($data->type === 'in') {
                    $stockInData[$data->date] = (int) $data->total_quantity;
                } elseif ($data->type === 'out') {
                    $stockOutData[$data->date] = (int) $data->total_quantity;
                }
            }

            // Fetch stock summary for sidebar report
            $stockSummary = Product::select('name', 'stock')->orderBy('name')->get();

            return view('admin.dashboard', compact(
                'productCount',
                'transactionsInCount',
                'transactionsOutCount',
                'recentActivities',
                'startDate',
                'endDate',
                'dates',
                'stockInData',
                'stockOutData',
                'stockSummary'
            ));
        } elseif ($user->role === 'Staff Gudang') {
            // Staf Gudang dashboard data with pending tasks
            $pendingIncoming = StockTransaction::where('type', 'in')
                ->where('status', 'pending')
                ->orderBy('created_at', 'desc')
                ->get();

            $pendingOutgoing = StockTransaction::where('type', 'out')
                ->where('status', 'pending')
                ->orderBy('created_at', 'desc')
                ->get();

            $pendingOpname = StockTransaction::where('type', 'opname')
                ->where('status', 'pending')
                ->orderBy('created_at', 'desc')
                ->get();


            return view('staf.dashboard', compact('pendingIncoming', 'pendingOutgoing', 'pendingOpname'));
        } else {
            // Default dashboard or redirect
            return redirect()->route('dashboard');
        }
    }
}
