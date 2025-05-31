<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Services\ProductService;
use Illuminate\Validation\ValidationException;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    // Display a listing of products
    public function index()
    {
        $products = $this->productService->listProducts();
        return view('admin.products.index', compact('products'));
    }

    // Show the form for creating a new product
    public function create()
    {
        return view('admin.products.create');
    }

    // Store a newly created product in storage
    public function store(Request $request)
    {
        try {
            $this->productService->createProduct($request->all());
            return redirect()->route('admin.products.index')->with('success', 'Product created successfully.');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->validator)->withInput();
        }
    }

    // Show the form for editing the specified product
    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    // Update the specified product in storage
    public function update(Request $request, Product $product)
    {
        try {
            $this->productService->updateProduct($product, $request->all());
            return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->validator)->withInput();
        }
    }

    // Remove the specified product from storage
    public function destroy(Product $product)
    {
        $this->productService->deleteProduct($product);
        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully.');
    }

    // Import and export methods will be added later
}
