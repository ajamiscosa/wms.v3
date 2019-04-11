<?php

namespace App\Http\Controllers;

use App\ProductLine;
use Illuminate\Http\Request;

class ProductLineController extends Controller
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
        return view('settings.productlines.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('settings.productlines.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->Name) {
            $productLine = new ProductLine();
            $productLine->Name = $request->Name;
            $productLine->Description = $request->Description;
            $productLine->save();
        }

        $name = explode(' ', $productLine->Name);
        $name = implode('-',$name);
        return redirect()->to('/product-line/view/'.$productLine->ID."-".$name);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ProductLine  $productLine
     * @return \Illuminate\Http\Response
     */
    public function show($productLine)
    {
        $productLine = ProductLine::where('Identifier','=', $productLine)->first();
        return view('settings.productlines.view', ['data'=>$productLine]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ProductLine  $productLine
     * @return \Illuminate\Http\Response
     */
    public function edit($productLine)
    {
        $productLine = ProductLine::where('Identifier','=', $productLine)->first();
        return view('settings.productlines.update', ['data'=>$productLine]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ProductLine  $productLine
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $productLine)
    {
        $productLine = ProductLine::where('Identifier','=', $productLine)->first();
        $productLine->Identifier = $request->Identifier;
        $productLine->Description = $request->Description;
        $productLine->save();
        return redirect()->to('/product-line/view/'.$productLine->Identifier);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ProductLine  $productLine
     * @return \Illuminate\Http\Response
     */
    public function toggle(Request $request, $productLine)
    {
        $productLine = ProductLine::where('Identifier','=',$productLine)->first();
        $productLine->Status = !$productLine->Status;
        $productLine->save();
        $name = explode(' ', $productLine->Name);
        $name = implode('-',$name);
        return redirect()->to('/product-line/view/'.$productLine->ID."-".$name);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ProductLine  $productLine
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductLine $productLine)
    {
        //
    }

    /**
     * Fetches all available data.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Json
     */
    public function data(Request $request)
    {
        return response()->json(['aaData'=>ProductLine::all()]);
    }

    /**
     * Fetches all available data.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Json
     */
    public function getSelectData(Request $request)
    {
        $data = array();
        foreach(ProductLine::all() as $productLine) {
            $entry['id'] = sprintf('%s',$productLine->Code);
            $entry['text'] = $productLine->Description;

            array_push($data, $entry);
        }
        return response()->json(['results'=>$data]);
    }

    /**
     * Fetches all available data.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Json
     */
    public function glselectdata(Request $request)
    {
        $data = array();
        foreach(ProductLine::all() as $productLine) {
            $entry['id'] = $productLine->Code;
            $entry['text'] = $productLine->Description;

            array_push($data, $entry);
        }
        return response()->json(['results'=>$data]);
    }
}
