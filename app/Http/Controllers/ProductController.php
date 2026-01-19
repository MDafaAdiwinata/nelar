<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Product;
use GuzzleHttp\Handler\Proxy;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::latest()->get();
        return Inertia::render('Admin/Products/Index', compact('products'));
    }

    public function create()
    {
        return Inertia::render('Admin/Products/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'price' => 'numeric|required',
            'description' => 'required|string',
            'image' => 'required|mimes:png,jpg,jpeg|max:2048',
        ]);

        $data = $request->only([
            'name',
            'price',
            'description',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $data['image'] = $imagePath;
        }
        Product::create($data);
        return redirect()->route('products.index')->with('success', 'Product Created Successfully');
    }

    public function edit(Product $product) {
        return Inertia::render('Admin/Products/Edit', compact('product'));
    }
}
