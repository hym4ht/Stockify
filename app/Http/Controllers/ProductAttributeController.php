<?php

namespace App\Http\Controllers;

use App\Models\ProductAttribute;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ProductAttributeController extends Controller
{
    // List all product attributes
    public function index()
    {
        $attributes = ProductAttribute::with('product')->paginate(15);
        return view('admin.product_attributes.index', compact('attributes'));
    }

    // Show form to create new attribute
    public function create()
    {
        $products = Product::all();
        return view('admin.product_attributes.create', compact('products'));
    }

    // Store new attribute
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'value' => 'required|string|max:255',
            'product_id' => 'required|exists:products,id',
        ]);

        ProductAttribute::create($validated);

        return redirect()->route('admin.product_attributes.index')->with('success', 'Product attribute created successfully.');
    }

    // Show form to edit attribute
    public function edit(ProductAttribute $productAttribute)
    {
        $products = Product::all();
        return view('admin.product_attributes.edit', compact('productAttribute', 'products'));
    }

    // Update attribute
    public function update(Request $request, ProductAttribute $productAttribute)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'value' => 'required|string|max:255',
            'product_id' => 'required|exists:products,id',
        ]);

        $productAttribute->update($validated);

        return redirect()->route('admin.product_attributes.index')->with('success', 'Product attribute updated successfully.');
    }

    // Delete attribute
    public function destroy(ProductAttribute $productAttribute)
    {
        $productAttribute->delete();

        return redirect()->route('admin.product_attributes.index')->with('success', 'Product attribute deleted successfully.');
    }
}
