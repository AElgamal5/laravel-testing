<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        return Product::all();

    }

    public function store(StoreProductRequest $request)
    {
        return Product::create($request->validated());
    }
    public function update(UpdateProductRequest $request, Product $product)
    {
        return $product->update($request->validated());
    }

    public function destroy(Product $product)
    {
        return $product->delete();
    }
}
