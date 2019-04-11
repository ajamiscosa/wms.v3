<?php

namespace App\Http\Controllers;

use App\ShippingMethod;
use Illuminate\Http\Request;

class ShippingMethodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('settings.shipvia.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('settings.shipvia.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $shipVia = new ShippingMethod();
        $shipVia->Description = $request->Description;
        $shipVia->Status = true;
        $shipVia->save();

        return redirect()->to('/ship-via');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ShippingMethod  $shippingMethod
     * @return \Illuminate\Http\Response
     */
    public function show($shipvia)
    {
        $shipvia = ShippingMethod::where('Description','=',$shipvia)->first();
        return view('settings.shipvia.view', ['data'=>$shipvia]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ShippingMethod  $shippingMethod
     * @return \Illuminate\Http\Response
     */
    public function edit($shipvia)
    {
        $shipvia = ShippingMethod::where('Description','=',$shipvia)->first();
        return view('settings.shipvia.update', ['data'=>$shipvia]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ShippingMethod  $shippingMethod
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $shipvia)
    {
        $shipvia = ShippingMethod::where('Description','=',$shipvia)->first();
        $shipvia->Description = $request->Description;
        $shipvia->Status = true;
        $shipvia->save();

        return redirect()->to('/ship-via/view/'.$shipvia->Description);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ShippingMethod  $shippingMethod
     * @return \Illuminate\Http\Response
     */
    public function destroy(ShippingMethod $shippingMethod)
    {
        //
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function toggle(Request $request, $shipVia)
    {
        $shipVia = ShippingMethod::where('Description','=',$shipVia)->first();
        $shipVia->Status = !$shipVia->Status;
        $shipVia->save();
        return redirect()->to('/ship-via/view/'.$shipVia->Description);
    }

    public function data() {
        return response()->json(['aaData'=>ShippingMethod::all()]);
    }
}
