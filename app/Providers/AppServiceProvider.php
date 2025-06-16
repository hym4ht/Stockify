<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        \Illuminate\Support\Facades\View::composer('components.sidebar.staf-sidebar', function ($view) {
            $totalStockIn = \App\Models\StockTransaction::confirmed()
                ->where('type', 'in')
                ->sum('quantity');

            $totalStockOut = \App\Models\StockTransaction::confirmed()
                ->where('type', 'out')
                ->sum('quantity');

            $totalDamagedLostGoods = \App\Models\StockTransaction::confirmed()
                ->sum('damaged_lost_goods');

            $totalStock = $totalStockIn - $totalStockOut;

            $view->with([
                'totalStock' => $totalStock,
                'totalDamagedLostGoods' => $totalDamagedLostGoods,
            ]);
        });
    }
}
