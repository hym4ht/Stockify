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

    protected function validate(array $data, int $productId = null)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'sku' => 'nullable|string|unique:products,sku' . ($productId ? ',' . $productId : ''),
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ];

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }
}
