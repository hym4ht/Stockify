<?php

namespace App\Repositories;

use App\Models\Product;

class ProductRepository
{
    public function getAllPaginated(int $perPage = 15)
    {
        return Product::with(['category', 'supplier'])->paginate($perPage);
    }

    public function getAll()
    {
        return Product::all();
    }

    public function findBySku(?string $sku)
    {
        if (!$sku) {
            return null;
        }
        return Product::where('sku', $sku)->first();
    }

    public function search(string $query, int $perPage = 15)
    {
        return Product::with(['category', 'supplier'])
            ->where('name', 'like', '%' . $query . '%')
            ->orWhere('sku', 'like', '%' . $query . '%')
            ->orWhere('description', 'like', '%' . $query . '%')
            ->paginate($perPage);
    }

    public function findById(int $id): ?Product
    {
        return Product::find($id);
    }

    public function create(array $data): Product
    {
        return Product::create($data);
    }

    public function update(Product $product, array $data): bool
    {
        return $product->update($data);
    }

    public function delete(Product $product): bool
    {
        return $product->delete();
    }
}
