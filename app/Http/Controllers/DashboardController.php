<?php

namespace App\Http\Controllers;

use App\Enums\Role;
use App\Models\Product;
use App\Models\StockTransaction;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        if ($user->role === 'Admin') {
            // Admin dashboard data
            $productCount = Product::count();

            $startDate = $request->input('start_date', Carbon::now()->subDays(29)->toDateString());
            $endDate = $request->input('end_date', Carbon::now()->addDay()->toDateString());

            $productNameFilter = $request->input('product_name', null);

            $transactionsInCount = StockTransaction::confirmed()->where('type', 'in')
                ->whereBetween('confirmed_at', [$startDate, $endDate])
                ->count();

            $transactionsOutCount = StockTransaction::confirmed()->where('type', 'out')
                ->whereBetween('confirmed_at', [$startDate, $endDate])
                ->count();

            $recentActivities = StockTransaction::confirmed()->with('user', 'product', 'confirmedBy')
                ->orderBy('confirmed_at', 'desc')
                ->paginate(5);

            $stockDataQuery = StockTransaction::confirmed()
                ->selectRaw('DATE(confirmed_at) as date, type, SUM(quantity) as total_quantity')
                ->whereBetween('confirmed_at', [$startDate, $endDate]);

            if ($productNameFilter) {
                $stockDataQuery->whereHas('product', function ($query) use ($productNameFilter) {
                    $query->where('name', 'like', '%' . $productNameFilter . '%');
                });
            }

            $stockData = $stockDataQuery->groupBy('date', 'type')
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

            // Fetch product names for filter dropdown
            $productNames = Product::orderBy('name')->pluck('name');

            // New query for pie chart data: physical_count and damaged_lost_goods grouped by product name
            $pieChartDataQuery = StockTransaction::confirmed()
                ->selectRaw('product_id, SUM(physical_count) as total_physical_count, SUM(damaged_lost_goods) as total_damaged_lost_goods')
                ->groupBy('product_id');

            if ($productNameFilter) {
                $pieChartDataQuery->whereHas('product', function ($query) use ($productNameFilter) {
                    $query->where('name', 'like', '%' . $productNameFilter . '%');
                });
            }

            $pieChartDataRaw = $pieChartDataQuery->with('product')->get();

            $pieChartData = $pieChartDataRaw->map(function ($item) {
                return [
                    'product_name' => $item->product->name ?? 'Unknown',
                    'physical_count' => (int) $item->total_physical_count,
                    'damaged_lost_goods' => (int) $item->total_damaged_lost_goods,
                ];
            });

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
                'stockSummary',
                'pieChartData',
                'productNameFilter',
                'productNames'
            ));
        } elseif (str_contains($user->role, 'Manajer')) {
            // Data khusus untuk dashboard manager
            $lowStockProducts = Product::whereColumn('stock', '<', 'minimum_stock')->get();
            $productCount = $lowStockProducts->count();

            $todayStart = Carbon::today();
            $todayEnd = Carbon::today()->endOfDay();

            $transactionsInCount = StockTransaction::where('type', 'in')
                ->whereBetween('created_at', [$todayStart, $todayEnd])
                ->count();

            $transactionsOutCount = StockTransaction::where('type', 'out')
                ->whereBetween('created_at', [$todayStart, $todayEnd])
                ->count();

            // Fetch pending opname masuk and keluar counts for notifications
            $pendingOpnameMasukCount = StockTransaction::where('type', 'in')
                ->where('status', 'pending')
                ->count();

            $pendingOpnameKeluarCount = StockTransaction::where('type', 'out')
                ->where('status', 'pending')
                ->count();

            // Data untuk grafik berdasarkan produk hari ini
            $start = Carbon::today();
            $end = Carbon::today()->endOfDay();

            $stockInDataRaw = StockTransaction::where('type', 'in')
                ->whereBetween('created_at', [$start, $end])
                ->selectRaw('product_id, SUM(physical_count) as total_physical_count')
                ->groupBy('product_id')
                ->with('product')
                ->get();

            $stockOutDataRaw = StockTransaction::where('type', 'out')
                ->whereBetween('created_at', [$start, $end])
                ->selectRaw('product_id, COUNT(*) as total_count')
                ->groupBy('product_id')
                ->with('product')
                ->get();

            $productNames = [];
            $stockInData = [];
            $stockOutData = [];

            // Collect product names from both datasets
            $productIds = $stockInDataRaw->pluck('product_id')->merge($stockOutDataRaw->pluck('product_id'))->unique();

            foreach ($productIds as $productId) {
                $product = $stockInDataRaw->firstWhere('product_id', $productId)->product ?? $stockOutDataRaw->firstWhere('product_id', $productId)->product;
                $productNames[] = $product->name ?? 'Unknown';

                $inCount = $stockInDataRaw->firstWhere('product_id', $productId)->total_physical_count ?? 0;
                $outCount = $stockOutDataRaw->firstWhere('product_id', $productId)->total_count ?? 0;

                $stockInData[] = $inCount;
                $stockOutData[] = -$outCount; // negative for stock out
            }

            return view('manager.dashboard', [
                'productCount' => $productCount,
                'lowStockProducts' => $lowStockProducts,
                'transactionsInCount' => $transactionsInCount,
                'transactionsOutCount' => $transactionsOutCount,
                'pendingOpnameMasukCount' => $pendingOpnameMasukCount,
                'pendingOpnameKeluarCount' => $pendingOpnameKeluarCount,
                'startDate' => $todayStart->format('d M Y'),
                'endDate' => $todayEnd->format('d M Y'),
                'dates' => $productNames,
                'stockInData' => $stockInData,
                'stockOutData' => $stockOutData,
            ]);
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
