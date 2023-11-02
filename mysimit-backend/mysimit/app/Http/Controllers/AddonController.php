<?php

namespace App\Http\Controllers;

use App\Models\Addon;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AddonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Product $product)
    {
        if (request()->user()->cannot('viewAny', Addon::class)) {
            abort(403);
        }

        // Start from here ...
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (request()->user()->cannot('create', Addon::class)) {
            abort(403);
        }

        // Start from here ...
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Product $product,Request $request)
    {
        // if (request()->user()->cannot('create', Addon::class)) {
        //     abort(403);
        // }
        DB::transaction(function () use ($request, $product) {
            $addon = Addon::create([
                'name' => $request->name,
                'is_multiple' => $request->is_multiple,
                'product_id' => $product->id,
            ]);
        });

        session()->flash('flash.banner', 'Created successfully.');
        session()->flash('flash.bannerStyle', 'success');
        return back();

        // Start from here ...
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Addon  $addon
     * @return \Illuminate\Http\Response
     */
    public function show(Addon $addon)
    {
        if (request()->user()->cannot('view', $addon)) {
            abort(403);
        }

        // Start from here ...
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Addon  $addon
     * @return \Illuminate\Http\Response
     */
    public function edit(Addon $addon,Request $request)
    {
        // if (request()->user()->cannot('update', $addon)) {
        //     abort(403);
        // }
        DB::transaction(function () use ($request, $addon) {
            $addon->update($request->only('name', 'is_multiple'));
        });

        session()->flash('flash.banner', 'Updated successfully.');
        session()->flash('flash.bannerStyle', 'success');
        return back();
        // Start from here ...
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Addon  $addon
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Addon $addon)
    {
        

        // Start from here ...
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Addon  $addon
     * @return \Illuminate\Http\Response
     */
    public function destroy(Addon $addon)
    {
        $addon->option()->delete();
        $addon->delete();
        session()->flash('flash.banner', 'Deleted successfully.');
        session()->flash('flash.bannerStyle', 'success');
        return back();
        // Start from here ...
    }
}
