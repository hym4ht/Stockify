<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\Supplier;
use App\Models\StockTransaction;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category_id',
        'supplier_id',
        'sku',
        'description',
        'price',
        'stock',
        'harga_jual',
        'minimum_stock',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function stockTransactions()
    {
        return $this->hasMany(StockTransaction::class);
    }

    public function attributes()
    {
        return $this->hasMany(ProductAttribute::class);
    }

    // Get sum of confirmed physical stock transactions (type 'in')
    public function getPhysicalStockAttribute()
    {
        return $this->stockTransactions()
            ->confirmed()
            ->where('type', 'in')
            ->sum('physical_count');
    }

    // Get sum of confirmed lost or damaged goods
    public function getLostDamagedStockAttribute()
    {
        return $this->stockTransactions()
            ->confirmed()
            ->sum('damaged_lost_goods');
    }
}
