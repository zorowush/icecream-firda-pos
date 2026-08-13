<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;


class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::with(['package', 'flavor']);

        // Kasir hanya melihat produk aktif
        if (auth()->user()->role == 'kasir') {
            $products->where('status', true);
        }

        // Cari produk
        if ($request->filled('search')) {

            $keyword = $request->search;

            $products->where(function ($query) use ($keyword) {

                $query->where('code', 'like', "%{$keyword}%")
                    ->orWhereHas('package', function ($q) use ($keyword) {
                        $q->where('name', 'like', "%{$keyword}%");
                    })
                    ->orWhereHas('flavor', function ($q) use ($keyword) {
                        $q->where('name', 'like', "%{$keyword}%");
                    });

            });

        }

        // Filter jenis penjualan
        if ($request->filled('sale_type')) {

            $products->where('sale_type', $request->sale_type);

        }

        // Filter status (admin saja)
        if (
            auth()->user()->role == 'admin' &&
            $request->status !== null &&
            $request->status !== ''
        ) {

            $products->where('status', $request->status);

        }

        $products = $products
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('pos.products.index', compact('products'));
    }    

    public function create()
    {
        $packages = \App\Models\Package::where('status', true)->get();
        $flavors = \App\Models\Flavor::where('status', true)->get();

        return view('pos.products.create', compact(
            'packages',
            'flavors'
        ));
    }
    public function edit(Product $product)
    {
        $packages = \App\Models\Package::where('status', true)->get();
        $flavors = \App\Models\Flavor::where('status', true)->get();

        return view('pos.products.edit', compact(
            'product',
            'packages',
            'flavors'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            
            'package_id' => 'required|exists:packages,id',
            'flavor_id' => 'required|exists:flavors,id',
            'price' => 'required|numeric|min:1',
            'sale_type' => 'required',
            'stock' => 'required|integer|min:0',
            'minimum_stock' => 'required|integer|min:0',
            'status' => 'required',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
        ]);

        $exists = Product::where('package_id', $request->package_id)
            ->where('flavor_id', $request->flavor_id)
            ->exists();

        if ($exists) {
            return back()
                ->withInput()
                ->withErrors([
                    'duplicate' => 'Produk dengan kombinasi kemasan dan rasa tersebut sudah tersedia.'
            ]);
        }

        $image = null;

if ($request->hasFile('image')) {

    $manager = new ImageManager(new Driver());

    $img = $manager->read($request->file('image'));

    // Batasi ukuran maksimal tanpa merusak tampilan
    $img->scaleDown(width: 1200, height: 1200);

    $filename = 'products/' . uniqid('product_') . '.webp';

    Storage::disk('public')->put(
        $filename,
        $img->toWebp(quality: 82)
    );

    $image = $filename;
}

        $lastProduct = Product::latest('id')->first();

        $nextNumber = $lastProduct
            ? $lastProduct->id + 1
            : 1;

        $code = 'IC' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

        Product::create([
            'code' => $code,
            'package_id' => $request->package_id,
            'flavor_id' => $request->flavor_id,
            'price' => $request->price,
            'sale_type' => $request->sale_type,
            'stock' => $request->stock,
            'minimum_stock' => $request->minimum_stock,
            'status' => $request->status,
            'image' => $image,
        ]);

        return redirect()
            ->route('products')
            ->with('success', 'Produk berhasil ditambahkan.');
    }
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'price' => 'required|numeric|min:1',
            'sale_type' => 'required',
            'minimum_stock' => 'required|integer|min:0',
            'status' => 'required',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
        ]);

        if ($request->hasFile('image')) {

    if ($product->image) {
        Storage::disk('public')->delete($product->image);
    }

    $manager = new ImageManager(new Driver());

    $img = $manager->read($request->file('image'));

    $img->scaleDown(width: 1200, height: 1200);

    $filename = 'products/' . uniqid('product_') . '.webp';

    Storage::disk('public')->put(
        $filename,
        $img->toWebp(quality: 82)
    );

    $product->image = $filename;
}

        $product->update([
            'price' => $request->price,
            'sale_type' => $request->sale_type,
            'minimum_stock' => $request->minimum_stock,
            'status' => $request->status,
            'image' => $product->image,
        ]);

        return redirect()
            ->route('products')
            ->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Product $product)
    {
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()
            ->route('products')
            ->with('success', 'Produk berhasil dihapus.');
    }
}