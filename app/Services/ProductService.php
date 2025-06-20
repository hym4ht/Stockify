<?php

namespace App\Services;

use App\Repositories\ProductRepository;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Models\Product;

class ProductService
{
    protected ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function listProducts(int $perPage = 15)
    {
        return $this->productRepository->getAllPaginated($perPage);
    }

    public function searchProducts(string $query, int $perPage = 15)
    {
        return $this->productRepository->search($query, $perPage);
    }

    public function createProduct(array $data): Product
    {
        $this->validate($data);

        return $this->productRepository->create($data);
    }

    public function updateProduct(Product $product, array $data): bool
    {
        $this->validate($data, $product->id);

        return $this->productRepository->update($product, $data);
    }

    public function deleteProduct(Product $product): bool
    {
        return $this->productRepository->delete($product);
    }

    public function importProducts($file)
    {
        $path = $file->getRealPath();
        $data = array_map('str_getcsv', file($path));
        $header = array_map('strtolower', array_shift($data));

        foreach ($data as $row) {
            $rowData = array_combine($header, $row);

            // Validate and create or update product
            try {
                $this->validate($rowData);
                $existingProduct = $this->productRepository->findBySku($rowData['sku'] ?? null);
                if ($existingProduct) {
                    $this->updateProduct($existingProduct, $rowData);
                } else {
                    $this->createProduct($rowData);
                }
            } catch (ValidationException $e) {
                // Skip invalid rows or handle errors as needed
                continue;
            }
        }
    }

    public function exportProducts()
    {
        $products = $this->productRepository->getAll();

        $header = ['name', 'category', 'supplier', 'sku', 'description', 'price', 'stock', 'attributes'];
        $csv = implode(',', $header) . "\n";

        foreach ($products as $product) {
            $attributes = $product->attributes->map(function ($attr) {
                return $attr->name . ': ' . $attr->value;
            })->implode(', ');

            $row = [
                '"' . str_replace('"', '""', $product->name) . '"',
                '"' . str_replace('"', '""', $product->category->name ?? '') . '"',
                '"' . str_replace('"', '""', $product->supplier->name ?? '') . '"',
                '"' . str_replace('"', '""', $product->sku) . '"',
                '"' . str_replace('"', '""', $product->description) . '"',
                '"' . str_replace('"', '""', $product->price) . '"',
                '"' . str_replace('"', '""', $product->stock) . '"',
                '"' . str_replace('"', '""', $attributes) . '"',
            ];

            $csv .= implode(',', $row) . "\n";
        }

        return $csv;
    }

    protected function validate(array $data, int $productId = null)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'sku' => 'nullable|string|unique:products,sku' . ($productId ? ',' . $productId : ''),
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
        ];

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }
}
