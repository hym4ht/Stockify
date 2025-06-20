<?php

namespace App\Http\Controllers;

use App\Models\StockTransaction;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TransaksiController extends Controller
{
    // Display stock transactions
    public function index(Request $request)
    {
$query = StockTransaction::with(['product.category', 'product.attributes', 'user']);

        // Filter by period (start_date and end_date)
        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        // Filter by category
        if ($request->filled('category_id')) {
            $query->whereHas('product.category', function ($q) use ($request) {
                $q->where('id', $request->category_id);
            });
        }

        // Filter by product attribute name and value
        if ($request->filled('attribute_name') && $request->filled('attribute_value')) {
            $query->whereHas('product.attributes', function ($q) use ($request) {
                $q->where('name', $request->attribute_name)
                  ->where('value', $request->attribute_value);
            });
        }

        $transactions = $query->orderBy('created_at', 'desc')->paginate(20)->appends($request->all());

        // Calculate total damaged/lost goods from confirmed opname transactions
        $damagedLostSum = StockTransaction::confirmed()
            ->where('type', 'in')
            ->sum('damaged_lost_goods');

        // mengambil semua data stock
        $totalStock = Product::sum('stock');

        // Fetch categories for filter dropdown
        $categories = \App\Models\Category::all();

        // Fetch distinct attribute names and values for filter dropdowns
        $attributeNames = \App\Models\ProductAttribute::select('name')->distinct()->pluck('name');
        $attributeValues = [];
        if ($request->filled('attribute_name')) {
            $attributeValues = \App\Models\ProductAttribute::where('name', $request->attribute_name)->distinct()->pluck('value');
        }

        return view('admin.transaksi.index', compact('totalStock', 'damagedLostSum', 'transactions', 'categories', 'attributeNames', 'attributeValues'));
    }

    // Show form to add stock transaction (in or out)
    public function create()
    {
        $products = Product::all();
        return view('admin.transaksi.create', compact('products'));
    }

    // Store stock transaction
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'type' => 'required|in:in,out',
            'quantity' => 'required|integer|min:1',
            'description' => 'nullable|string',
        ]);

        $validated['user_id'] = Auth::id();
        $validated['status'] = 'pending'; // Set status to pending on creation

        StockTransaction::create($validated);

        // Do NOT update product stock here; stock will be updated on confirmation

        $today = date('Y-m-d');
        return redirect()->route('admin.transaksi.index')->with('success', 'Stock transaction recorded successfully.');
    }

    // Confirm stock transaction (receipt or issuance) by staf gudang
    public function confirmTransaction($id)
    {
        $user = auth()->user();

        if ($user->role !== 'Staff Gudang') {
            abort(403, 'Unauthorized action.');
        }

        $transaction = StockTransaction::findOrFail($id);

        if ($transaction->status !== 'pending') {
            return redirect()->back()->with('error', 'Transaction already confirmed or invalid status.');
        }

        $transaction->status = 'confirmed';
        $transaction->confirmed_by = $user->id;
        $transaction->confirmed_at = now();
        $transaction->save();

        // Adjust stock only on confirmation
        $product = $transaction->product;

        if ($transaction->type === 'out') {
            if ($product->stock >= $transaction->quantity) {
                $product->decrement('stock', $transaction->quantity);
            } else {
                return redirect()->back()->with('error', 'Insufficient stock to confirm this transaction.');
            }
        } elseif ($transaction->type === 'in') {
            $product->increment('stock', $transaction->quantity);
        }

        return redirect()->back()->with('success', 'Transaction confirmed successfully.');
    }

    // Show form to edit stock transaction
    public function edit($id)
    {
        $transaction = StockTransaction::findOrFail($id);
        $products = Product::all();
        return view('admin.transaksi.edit', compact('transaction', 'products'));
    }

    // Update stock transaction
    public function update(Request $request, $id)
    {
        $transaction = StockTransaction::findOrFail($id);

        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'type' => 'required|in:in,out',
            'quantity' => 'required|integer|min:1',
            'description' => 'nullable|string',
        ]);

        // Adjust stock based on difference in quantity and type
        $oldQuantity = $transaction->quantity;
        $oldType = $transaction->type;

        $transaction->product_id = $validated['product_id'];
        $transaction->type = $validated['type'];
        $transaction->quantity = $validated['quantity'];
        $transaction->description = $validated['description'] ?? null;
        $transaction->save();

        $product = Product::findOrFail($validated['product_id']);

        // Revert old stock adjustment
        if ($oldType === 'in') {
            $product->decrement('stock', $oldQuantity);
        } else {
            $product->increment('stock', $oldQuantity);
        }

        // Apply new stock adjustment
        if ($validated['type'] === 'in') {
            $product->increment('stock', $validated['quantity']);
        } else {
            if ($product->stock < $validated['quantity']) {
                return redirect()->back()->with('error', 'Insufficient stock for this transaction.');
            }
            $product->decrement('stock', $validated['quantity']);
        }

        return redirect()->route('admin.transaksi.index')->with('success', 'Stock transaction updated successfully.');
    }

    // Delete stock transaction
    public function destroy($id)
    {
        $transaction = StockTransaction::findOrFail($id);
        $product = $transaction->product;

        // Revert stock adjustment
        if ($transaction->type === 'in') {
            $product->decrement('stock', $transaction->quantity);
        } else {
            $product->increment('stock', $transaction->quantity);
        }

        $transaction->delete();

        return redirect()->route('admin.transaksi.index')->with('success', 'Stock transaction deleted successfully.');
    }

    // Stock opname view and update methods can be added here later

    // Minimum stock settings can be managed via settings controller or here

    // Display stock opname records
    public function opnameIndex()
    {
        $opnameRecords = StockTransaction::where('type', 'opname')
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();

        $opnameMasukRecords = StockTransaction::where('type', 'in')
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();

        $opnameKeluarRecords = StockTransaction::where('type', 'out')
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('staf.opname.index', compact('opnameRecords', 'opnameMasukRecords', 'opnameKeluarRecords'));
    }

    // Show opname masuk records
    public function opnameMasuk()
    {
        $opnameMasukRecords = StockTransaction::where('type', 'in')
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('staf.opname.masuk', compact('opnameMasukRecords'));
    }

    // Show form to create opname masuk
    public function createOpnameMasuk()
    {
        $products = Product::all();
        return view('staf.opname.create-masuk', compact('products'));
    }

    // Store opname masuk transaction
    public function storeOpnameMasuk(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'description' => 'nullable|string',
        ]);

        $validated['type'] = 'in';
        $validated['user_id'] = $user->id;
        $validated['status'] = 'pending';

        StockTransaction::create($validated);

        return redirect()->route('stock.opname.masuk')->with('success', 'Opname masuk recorded successfully.');
    }

    // Show opname keluar records
    public function opnameKeluar()
    {
        $opnameKeluarRecords = StockTransaction::where('type', 'out')
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('staf.opname.keluar', compact('opnameKeluarRecords'));
    }

    // Show form to create opname keluar
    public function createOpnameKeluar()
    {
        $products = Product::all();
        return view('staf.opname.create-keluar', compact('products'));
    }

    // Store opname keluar transaction
    public function storeOpnameKeluar(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'description' => 'nullable|string',
        ]);

        $validated['type'] = 'out';
        $validated['user_id'] = $user->id;
        $validated['status'] = 'pending';

        StockTransaction::create($validated);

        return redirect()->route('stock.opname.keluar')->with('success', 'Opname keluar recorded successfully.');
    }

    // Confirm stock opname record
    // Confirm stock opname record
    public function confirmOpname($id)
    {
        $user = auth()->user();

        if ($user->role !== 'Staff Gudang' && $user->role !== 'Manajer Gudang') {
            abort(403, 'Unauthorized action.');
        }

        $opname = StockTransaction::findOrFail($id);

        if ($opname->status !== 'pending') {
            return redirect()->back()->with('error', 'Opname already confirmed or invalid status.');
        }

        // Update status opname
        $opname->status = 'confirmed';
        $opname->confirmed_by = $user->id;
        $opname->confirmed_at = now();
        $opname->save();

        // Hanya tambahkan physical_count ke stok produk
        $product = $opname->product;

        if ($opname->physical_count !== null && $opname->physical_count > 0) {
            $product->increment('stock', $opname->physical_count);
        }

        // Tidak ada operasi untuk damaged_lost_goods karena sudah tercatat di transaksi
        return redirect()->back()->with('success', 'Opname confirmed successfully.');
    }

    // Bulk confirm opname records
    public function bulkConfirmOpname(Request $request)
    {
        $user = auth()->user();

        if ($user->role !== 'Staff Gudang' && $user->role !== 'Manajer Gudang') {
            abort(403, 'Unauthorized action.');
        }

        $physicalCounts = $request->input('physical_count', []);
        $damagedLostGoods = $request->input('damaged_lost_goods', []);
        $confirmIds = $request->input('confirm', []);

        if (is_array($confirmIds)) {
            $confirmIds = array_keys($confirmIds);
        }

        $processedCount = 0;
        foreach ($confirmIds as $id) {
            $opname = StockTransaction::findOrFail($id);
            if (!$opname) {
                continue;
            }

            if ($opname->status !== 'pending') {
                continue;
            }

            // Update nilai fisik dan kerusakan
            $opname->physical_count = isset($physicalCounts[$id]) ? (int) $physicalCounts[$id] : null;
            $opname->damaged_lost_goods = isset($damagedLostGoods[$id]) ? (int) $damagedLostGoods[$id] : null;

            // Update status
            $opname->status = 'confirmed';
            $opname->confirmed_by = $user->id;
            $opname->confirmed_at = now();
            $opname->save();

            // Hanya tambahkan physical_count ke stok produk
            $product = $opname->product;
            if ($opname->physical_count !== null && $opname->physical_count > 0) {
                $product->increment('stock', $opname->physical_count);
            }

            $processedCount++;
        }

        return redirect()->back()->with('success', "Selected opname records confirmed successfully. Processed: $processedCount");
    }
}
