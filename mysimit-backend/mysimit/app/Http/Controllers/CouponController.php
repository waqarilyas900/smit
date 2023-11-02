<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return Inertia::render('Coupon/Index', [
            'coupons' => Coupon::filter($request->all())
            ->sorted()
            ->paginate()
            ->withQueryString(),
        'query'  => $request->all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Coupon/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) 
    {
        DB::transaction(function () use ($request) {
            $coupon = Coupon::create([
                'coupon' => $request->coupon,
                'discount' => $request->discount,
                'type' => $request->type,
                'limit' => $request->limit,
                'used' => $request->used,
                'expiry' => $request->expiry,
            ]); 
        });

        session()->flash('flash.banner', 'Created successfully.');
        session()->flash('flash.bannerStyle', 'success');

        if ($request->saveAndContinue) {
            return back();
        }
        return redirect()->route('coupons.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $coupon = Coupon::find($id);

        // Start from here ...
        return Inertia::render('Coupon/Edit', [
            'coupon' => $coupon
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Start from here ...
        $coupon = Coupon::find($id);
        $coupon->update([
            'coupon' => $request->coupon,
            'discount' => $request->discount,
            'type' => $request->type,
            'limit' => $request->limit,
            'used' => $request->used,
            'expiry' => $request->expiry,
        ]);


        session()->flash('flash.banner', 'Updated successfully.');
        session()->flash('flash.bannerStyle', 'success');

        if ($request->updateAndContinue) {
            return back();
        }
        return redirect()->route('coupons.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Coupon::find($id)->delete();
        return back();
    }
}