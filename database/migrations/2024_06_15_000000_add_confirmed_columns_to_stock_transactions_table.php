<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddConfirmedColumnsToStockTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('stock_transactions', function (Blueprint $table) {
            $table->foreignId('confirmed_by')->nullable()->constrained('users')->onDelete('set null')->after('status');
            $table->timestamp('confirmed_at')->nullable()->after('confirmed_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stock_transactions', function (Blueprint $table) {
            $table->dropForeign(['confirmed_by']);
            $table->dropColumn(['confirmed_by', 'confirmed_at']);
        });
    }
}
