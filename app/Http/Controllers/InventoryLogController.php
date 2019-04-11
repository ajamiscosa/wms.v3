<?php

namespace App\Http\Controllers;

use App\InventoryLog;
use Illuminate\Http\Request;

class InventoryLogController extends Controller
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
        return view('inventory.inventory-logs');
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
     * @param  \App\InventoryLog  $inventoryLog
     * @return \Illuminate\Http\Response
     */
    public function show(InventoryLog $inventoryLog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\InventoryLog  $inventoryLog
     * @return \Illuminate\Http\Response
     */
    public function edit(InventoryLog $inventoryLog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\InventoryLog  $inventoryLog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InventoryLog $inventoryLog)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\InventoryLog  $inventoryLog
     * @return \Illuminate\Http\Response
     */
    public function destroy(InventoryLog $inventoryLog)
    {
        //
    }
}
