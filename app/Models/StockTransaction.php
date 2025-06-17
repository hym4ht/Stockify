<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'type',
        'quantity',
        'physical_count',
        'adjustment_note',
        'damaged_lost_goods',
        'description',
        'status',
        'user_id',
        'confirmed_by',
        'confirmed_at',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function confirmedBy() 
    {
    return $this->belongsTo(User::class, 'confirmed_by'); // Menghubungkan ke user yang mengkonfirmasi
    }   
    /**
     * Scope a query to only include confirmed transactions.
     */
    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }
}
