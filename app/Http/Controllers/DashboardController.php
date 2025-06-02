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
        // Get total product count
        $productCount = Product::count();

        // Define period for transactions (default last 30 days)
        $startDate = $request->input('start_date', Carbon::now()->subDays(30)->toDateString());
        $endDate = $request->input('end_date', Carbon::now()->toDateString());

        // Get count of stock transactions in and out in the period
        $transactionsInCount = StockTransaction::where('type', 'in')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();

        $transactionsOutCount = StockTransaction::where('type', 'out')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();

        // Get recent user activities (last 10 stock transactions)
        $recentActivities = StockTransaction::with('user', 'product')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Prepare stock graph data: daily stock in and out counts for last 30 days
        $stockData = StockTransaction::selectRaw('DATE(created_at) as date, type, SUM(quantity) as total_quantity')
            ->whereBetween('created_at', [$startDate, $endDate])
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

        return view('admin.dashboard', compact(
            'productCount',
            'transactionsInCount',
            'transactionsOutCount',
            'recentActivities',
            'startDate',
            'endDate',
            'dates',
            'stockInData',
            'stockOutData'
        ));
    }
}
