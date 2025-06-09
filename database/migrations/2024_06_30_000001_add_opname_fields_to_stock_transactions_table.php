<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOpnameFieldsToStockTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('stock_transactions', function (Blueprint $table) {
            $table->integer('physical_count')->nullable()->after('quantity');
            $table->integer('discrepancy')->nullable()->after('physical_count');
            $table->text('adjustment_note')->nullable()->after('discrepancy');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stock_transactions', function (Blueprint $table) {
            $table->dropColumn(['physical_count', 'discrepancy', 'adjustment_note']);
        });
    }
}
