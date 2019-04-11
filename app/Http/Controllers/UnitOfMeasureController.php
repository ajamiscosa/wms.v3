<?php

namespace App\Http\Controllers;

use App\UnitOfMeasure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use SebastianBergmann\CodeCoverage\Report\Xml\Unit;

class UnitOfMeasureController extends Controller
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
        return view('settings.uom.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('settings.uom.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $uom = new UnitOfMeasure();
        $uom->Name = $request->Name;
        $uom->Abbreviation = $request->Abbreviation;
        $uom->save();

        $name = explode(' ', $request->Name);
        $name = implode('-',$name);
        return redirect()->to('/uom/view/'.$uom->ID."-".$name);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\UnitOfMeasure  $uom
     * @return \Illuminate\Http\Response
     */
    public function show($uom)
    {
        $data = explode('-', $uom, 2);
        $uom = UnitOfMeasure::where('ID','=', $data[0])->first();
        return view('settings.uom.view', ['data'=>$uom]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\UnitOfMeasure  $uom
     * @return \Illuminate\Http\Response
     */
    public function edit($uom)
    {
        $data = explode('-', $uom, 2);
        $uom = UnitOfMeasure::where('ID','=', $data[0])->first();
        return view('settings.uom.update', ['data'=>$uom]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\UnitOfMeasure  $uom
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $uom)
    {
        $data = explode('-', $uom, 2);
        $uom = UnitOfMeasure::where('ID','=', $data[0])->first();
        $uom->Name = $request->Name;
        $uom->Abbreviation = $request->Abbreviation;
        $uom->save();


        $name = explode(' ', $uom->Name);
        $name = implode('-',$name);
        return redirect()->to('/uom/view/'.$uom->ID."-".$name);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\UnitOfMeasure  $uom
     * @return \Illuminate\Http\Response
     */
    public function toggle(Request $request, $uom) {
        $data = explode('-', $uom, 2);
        $uom = UnitOfMeasure::where('ID','=',$data[0])->first();
        $uom->Status = !$uom->Status;
        $uom->save();
        $name = explode(' ', $uom->Name);
        $name = implode('-',$name);
        return redirect()->to('/uom/view/'.$uom->ID."-".$name);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\UnitOfMeasure  $uom
     * @return \Illuminate\Http\Response
     */
    public function destroy(UnitOfMeasure $uom)
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
        $data = array();
        $uom = new UnitOfMeasure();
        $uoms = $uom::all();
        for($i=0;$i<count($uoms);$i++){
            $entry = array();
            $entry['ID'] =  $uoms[$i]->ID;
            $entry['Name'] = $uoms[$i]->Name;
            $entry['Abbreviation'] = $uoms[$i]->Abbreviation;

            array_push($data, $entry);
        }
        return response()->json(['aaData'=>$data]);
    }

    public function getSelectData() {
        $data = array();
        foreach(UnitOfMeasure::all() as $uom) {
            $entry['id'] = $uom->ID;
            $entry['text'] = sprintf("[%s] %s", $uom->Abbreviation, $uom->Name);

            array_push($data, $entry);
        }
        return response()->json(['results'=>$data]);
    }
}
