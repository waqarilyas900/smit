<?php

namespace App\Http\Controllers;
use App\Models\Addon;
use App\Models\Option;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->user()->cannot('viewAny', Option::class)) {
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
        if (request()->user()->cannot('create', Option::class)) {
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
    public function store(Addon $addon, Request $request)
    {
        // if (request()->user()->cannot('create', Option::class)) {
        //     abort(403);
        // }

        DB::transaction(function () use ($request, $addon) {
            $option = Option::create([
                'name' => $request->name,
                'price' => $request->price,
                'addon_id' => $addon->id
            ]);
        });

        session()->flash('flash.banner', 'Updated successfully.');
        session()->flash('flash.bannerStyle', 'success');
        return back();


        // Start from here ...
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Option  $option
     * @return \Illuminate\Http\Response
     */
    public function show(Option $option)
    {
        if (request()->user()->cannot('view', $option)) {
            abort(403);
        }

        // Start from here ...
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Option  $option
     * @return \Illuminate\Http\Response
     */
    
    public function edit(Option $option,Request $request)
    {
        //  if (request()->user()->cannot('update', $option)) {
        //     abort(403);
        // }

        DB::transaction(function () use ($request, $option) {
            $option->update($request->only('name', 'price'));
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
     * @param  \App\Models\Option  $option
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Option $option)
    {
         if (request()->user()->cannot('update', $option)) {
            abort(403);
        }

        // Start from here ...
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Option  $option
     * @return \Illuminate\Http\Response
     */
    public function destroy(Option $option)
    {
        //  if (request()->user()->cannot('delete', $option)) {
        //     abort(403);
        // }
        $option->delete();
        session()->flash('flash.banner', 'Deleted successfully.');
        session()->flash('flash.bannerStyle', 'success');
        return back();
        // Start from here ...
    }
}
