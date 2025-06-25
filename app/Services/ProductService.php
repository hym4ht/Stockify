<?php

namespace App\Services;

use App\Repositories\ProductRepository;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Models\Product;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

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
        $this->validateData($data);

        return $this->productRepository->create($data);
    }

    public function updateProduct(Product $product, array $data): bool
    {
        $this->validateData($data, $product->id);

        return $this->productRepository->update($product, $data);
    }

    public function deleteProduct(Product $product): bool
    {
        return $this->productRepository->delete($product);
    }

    public function importProducts($file)
    {
        $extension = $file->getClientOriginalExtension();

        // Map user-friendly headers to database columns
        $headerMap = [
            'name' => 'name',
            'price' => 'price',
            'harga jual' => 'harga_jual',
            'category' => 'category_id',
            'supplier' => 'supplier_id',
            'attributes' => 'attributes',
            'sku' => 'sku',
            'stock' => 'stock',
            'minimum stock' => 'minimum_stock',
            'description' => 'description',
        ];

        Log::info('Starting importProducts with file extension: ' . $extension);
        try {
            if (in_array($extension, ['xls', 'xlsx'])) {
                // Use PhpSpreadsheet to read Excel files
                $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file->getRealPath());
                $worksheet = $spreadsheet->getActiveSheet();
                $rows = $worksheet->toArray();

                $header = array_map('strtolower', array_shift($rows));

                Log::info('Excel headers: ', $header);

                foreach ($rows as $row) {
                    $rowDataRaw = array_combine($header, $row);

                    // Map headers to database columns
                    $rowData = [];
                    foreach ($rowDataRaw as $key => $value) {
                        if (isset($headerMap[$key])) {
                            $rowData[$headerMap[$key]] = $value;
                        }
                    }
                        // 🔽 Tambahkan bagian ini setelah $rowData terbentuk
    if (!empty($rowDataRaw['category'])) {
        $category = \App\Models\Category::where('name', trim($rowDataRaw['category']))->first();
        if ($category) {
            $rowData['category_id'] = $category->id;
        } else {
            Log::error('Category not found: ' . $rowDataRaw['category']);
            continue;
        }
    }

    if (!empty($rowDataRaw['supplier'])) {
        $supplier = \App\Models\Supplier::where('name', trim($rowDataRaw['supplier']))->first();
        if ($supplier) {
            $rowData['supplier_id'] = $supplier->id;
        } else {
            Log::error('Supplier not found: ' . $rowDataRaw['supplier']);
            continue;
        }
    }

                    Log::info('Processing row data: ', $rowData);


                    try {
                        $this->validateData($rowData);
                        $existingProduct = $this->productRepository->findBySku($rowData['sku'] ?? null);
                        if ($existingProduct) {
                            // Update product fields
                            $existingProduct->fill($rowData);
                            $existingProduct->save();

                            // Update attributes: delete old and create new
                            $existingProduct->attributes()->delete();
                            if (!empty($rowData['attributes'])) {
                                $attributes = explode(',', $rowData['attributes']);
                                foreach ($attributes as $attribute) {
                                    $parts = explode(':', $attribute);
                                    if (count($parts) == 2) {
                                        $existingProduct->attributes()->create([
                                            'name' => trim($parts[0]),
                                            'value' => trim($parts[1]),
                                        ]);
                                    }
                                }
                            }
                        } else {
                            $product = $this->createProduct($rowData);
                            // Handle attributes if present
                            if (!empty($rowData['attributes'])) {
                                $attributes = explode(',', $rowData['attributes']);
                                foreach ($attributes as $attribute) {
                                    $parts = explode(':', $attribute);
                                    if (count($parts) == 2) {
                                        $product->attributes()->create([
                                            'name' => trim($parts[0]),
                                            'value' => trim($parts[1]),
                                        ]);
                                    }
                                }
                            }
                        }
                    } catch (ValidationException $e) {
                        Log::error('Validation failed for row: ', $rowData);
                        continue;
                    }
                }
            } elseif ($extension === 'csv') {
                $path = $file->getRealPath();
                $data = array_map('str_getcsv', file($path));
                $header = array_map('strtolower', array_shift($data));

                Log::info('CSV headers: ', $header);

                foreach ($data as $row) {
                    $rowDataRaw = array_combine($header, $row);

                    // Map headers to database columns
                    $rowData = [];
                    foreach ($rowDataRaw as $key => $value) {
                        if (isset($headerMap[$key])) {
                            $rowData[$headerMap[$key]] = $value;
                        }
                    }

                    Log::info('Processing row data: ', $rowData);

                    try {
                        $this->validateData($rowData);
                        $existingProduct = $this->productRepository->findBySku($rowData['sku'] ?? null);
                        if ($existingProduct) {
                            // Update product fields
                            $existingProduct->fill($rowData);
                            $existingProduct->save();

                            // Update attributes: delete old and create new
                            $existingProduct->attributes()->delete();
                            if (!empty($rowData['attributes'])) {
                                $attributes = explode(',', $rowData['attributes']);
                                foreach ($attributes as $attribute) {
                                    $parts = explode(':', $attribute);
                                    if (count($parts) == 2) {
                                        $existingProduct->attributes()->create([
                                            'name' => trim($parts[0]),
                                            'value' => trim($parts[1]),
                                        ]);
                                    }
                                }
                            }
                        } else {
                            $product = $this->createProduct($rowData);
                            // Handle attributes if present
                            if (!empty($rowData['attributes'])) {
                                $attributes = explode(',', $rowData['attributes']);
                                foreach ($attributes as $attribute) {
                                    $parts = explode(':', $attribute);
                                    if (count($parts) == 2) {
                                        $product->attributes()->create([
                                            'name' => trim($parts[0]),
                                            'value' => trim($parts[1]),
                                        ]);
                                    }
                                }
                            }
                        }
                    } catch (ValidationException $e) {
                        Log::error('Validation failed for row: ', $rowData);
                        continue;
                    }
                }
            } else {
                throw new \Exception('Unsupported file type. Please upload a CSV or Excel file.');
            }
        } catch (\Exception $e) {
            Log::error('Import failed: ' . $e->getMessage());
            throw $e;
        }
    }

    protected function validateData(array $data, int $productId = null)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'sku' => 'nullable|string|unique:products,sku' . ($productId ? ',' . $productId : ''),
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'harga_jual' => 'nullable|numeric|min:0',
        ];

        // Convert category and supplier names to IDs if needed
        if (isset($data['category_id']) && !is_numeric($data['category_id'])) {
            $category = \App\Models\Category::where('name', $data['category_id'])->first();
            if ($category) {
                $data['category_id'] = $category->id;
            } else {
                throw new \Exception("Category '{$data['category_id']}' not found.");
            }
        }

        if (isset($data['supplier_id']) && !is_numeric($data['supplier_id'])) {
            $supplier = \App\Models\Supplier::where('name', $data['supplier_id'])->first();
            if ($supplier) {
                $data['supplier_id'] = $supplier->id;
            } else {
                throw new \Exception("Supplier '{$data['supplier_id']}' not found.");
            }
        }

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }
}
