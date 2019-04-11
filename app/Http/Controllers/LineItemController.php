<?php

namespace App\Http\Controllers;

use App\LineItem;
use Illuminate\Http\Request;

class LineItemController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\LineItem  $lineItem
     * @return \Illuminate\Http\Response
     */
    public function show(LineItem $lineItem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\LineItem  $lineItem
     * @return \Illuminate\Http\Response
     */
    public function edit(LineItem $lineItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\LineItem  $lineItem
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LineItem $lineItem)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\LineItem  $lineItem
     * @return \Illuminate\Http\Response
     */
    public function destroy(LineItem $lineItem)
    {
        //
    }
}
