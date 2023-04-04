<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'input_nama' => 'required',
            'input_description' => 'required',
            'input_harga' => 'required',
            'input_category' => 'required',
            'input_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'input_quantity' => 'required',
        ]);

        $imageName = time() . '.' . $request->input_image->extension();
        $request->input_image->move(public_path('images'), $imageName);

        $product = new Product([
            'category_id' => $request->input_category,
            'name' => $request->input_nama,
            'description' => $request->input_description,
            'price' => $request->input_harga,
            'image' => $imageName,
            'quantity' => $request->input_quantity,
        ]);
        $product->save();

        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'input_nama' => 'required',
            'input_description' => 'required',
            'input_harga' => 'required',
            'input_category' => 'required',
            'input_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'input_quantity' => 'required',
        ]);
        if ($request->hasFile('input_image')) {
            $imageName = time() . '.' . $request->input_image->extension();
            $request->input_image->move(public_path('images'), $imageName);
            Storage::delete('images/' . $product->image);
            $product->image = $imageName;
        }
        $product->name = $request->input_nama;
        $product->description = $request->input_description;
        $product->price = $request->input_harga;
        $product->category_id = $request->input_category;
        $product->quantity = $request->input_quantity;
        $product->save();

        return redirect()->route('products.index')->with('success', 'Product updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        Storage::delete('images/' . $product->image);
        $product->delete();

        return redirect()->route('products.index')
            ->with('success', 'Product deleted successfully.');
    }
}
