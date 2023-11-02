<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use Illuminate\Database\Eloquent\Builder;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        // return 123;
        // return Product::with(['tags', 'unit', 'category', 'ratings', 'addons'])->withCount('ratings')->filter($request->all())->sorted()->paginate(10);
        return Product::where('status', 'published')->with(['tags', 'unit', 'category', 'ratings', 'addons'])
        ->withCount('ratings')
        ->when($request->has('discounted'), function ($query) use ($request) {
            if ($request->discounted) {
                // Return products with discounts
                $query->whereNotNull('discount');
            }
            // If discounted is false or not provided, return all products
        })
        ->filter($request->except('discounted'))
        ->sorted()
        ->paginate(10);
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, Product $product)
    {
        $relatedProducts = Product::whereHas('tags', function ($tag) use ($product) {
            $tag->whereIn('id', $product->tags()->pluck('id')->toArray());
        })
            ->where('category_id', $product->categoryId)
            ->limit(5)
            ->get();

        return (new ProductResource($product->load('tags', 'unit', 'category', 'ratings.author', 'addons')->append('isFavorited')))
            ->additional(['relatedProducts' => $relatedProducts]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function showForAuth(Request $request, Product $product)
    {
        $relatedProducts = Product::whereHas('tags', function ($tag) use ($product) {
            $tag->whereIn('id', $product->tags()->pluck('id')->toArray());
        })
            ->where('category_id', $product->categoryId)
            ->limit(5)
            ->get();

        return (new ProductResource($product->load('tags', 'unit', 'category', 'ratings.author','addons')->append('isFavorited')))
            ->additional(['relatedProducts' => $relatedProducts]);
    }
}