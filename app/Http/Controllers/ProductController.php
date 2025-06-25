<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Services\ProductService;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    // Display a listing of products
    public function index(Request $request)
    {
        $query = $request->input('query');
        if ($query) {
            $products = $this->productService->searchProducts($query);
        } else {
            $products = $this->productService->listProducts();
        }
        return view('admin.products.index', compact('products', 'query'));
    }

    // Show import form
    public function showImportForm()
    {
        return view('admin.products.import');
    }

    // Handle import POST
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,txt',
        ]);

        $file = $request->file('file');

        $this->productService->importProducts($file);

        return redirect()->route('admin.products.index')->with('success', 'Products imported successfully.');
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
            $data = $request->all();
            $attributes = $data['attributes'] ?? [];
            unset($data['attributes']);

            $product = $this->productService->createProduct($data);

            // Create product attributes
            foreach ($attributes as $attribute) {
                if (!empty($attribute['name']) && !empty($attribute['value'])) {
                    $product->attributes()->create([
                        'name' => $attribute['name'],
                        'value' => $attribute['value'],
                    ]);
                }
            }

            return redirect()->route('admin.products.index')->with('success', 'Product created successfully.');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
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
            Log::info('Update Product Request Data:', $request->all());

            // Explicitly set harga_jual to product model before update
            if ($request->has('harga_jual')) {
                $product->harga_jual = $request->input('harga_jual');
            }

            // Update other fields via service
            $this->productService->updateProduct($product, $request->except('harga_jual'));

            // Save the product with updated harga_jual
            $product->save();
            return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');
        } catch (ValidationException $e) {
            Log::error('Validation error on product update', ['errors' => $e->errors()]);
            return redirect()->back()->withErrors($e->errors())->withInput();
        }
    }

    // Remove the specified product from storage
    public function destroy(Product $product)
    {
        $this->productService->deleteProduct($product);
        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully.');
    }

    // Show the specified product
    public function show(Product $product)
    {
        return view('admin.products.show', compact('product'));
    }

    // Show import form
    public function export()
    {
        // Ambil semua produk beserta relasi kategori, supplier, dan atribut
        $products = Product::with(['category', 'supplier', 'attributes'])->get();

        // Header CSV/tab-delimited
        $headers = [
            'Content-Type' => 'application/vnd.ms-excel',
            'Content-Disposition' => 'attachment; filename="products_export_' . date('Ymd_His') . '.xls"',
        ];

        // Judul kolom
        $csv = "Name\tPrice\tHarga Jual\tCategory\tSupplier\tAttributes\tSKU\tStock\tMinimum Stock\n";

        foreach ($products as $product) {
            $attributes = $product->attributes->map(function ($attr) {
                return $attr->name . ':' . $attr->value;
            })->implode(', ');

            $csv .=
                $product->name . "\t" .
                $product->price . "\t" .
                $product->harga_jual . "\t" .
                ($product->category->name ?? 'N/A') . "\t" .
                ($product->supplier->name ?? 'N/A') . "\t" .
                $attributes . "\t" .
                $product->sku . "\t" .
                $product->stock . "\t" .
                $product->minimum_stock . "\n";
        }

        return response($csv, 200, $headers);
    }


}
