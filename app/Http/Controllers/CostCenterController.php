<?php

namespace App\Http\Controllers;

use App\CostCenter;
use Illuminate\Http\Request;

class CostCenterController extends Controller
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
        return view('settings.costcenters.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('settings.costcenters.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $cc = new CostCenter();
        $cc->Code = $request->Code;
        $cc->Description = $request->Description;
        $cc->save();

        return redirect()->to("/cost-center/view/$cc->Code");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CostCenter  $cc
     * @return \Illuminate\Http\Response
     */
    public function show($cc)
    {
        $cc = CostCenter::where('Code','=',$cc)->first();
        return view('settings.costcenters.view', ['data'=>$cc]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CostCenter  $cc
     * @return \Illuminate\Http\Response
     */
    public function edit($cc)
    {
        $cc = CostCenter::where('Code','=', $cc)->first();
        return view('settings.costcenters.update', ['data'=>$cc]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CostCenter  $cc
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $cc)
    {
        $cc = CostCenter::where('Code','=', $cc)->first();
        $cc->Code = $request->Code;
        $cc->Description = $request->Description;
        $cc->save();
        $name = explode(' ', $cc->Code);
        return redirect()->to('/cost-center/view/'.$cc->Code);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CostCenter  $cc
     * @return \Illuminate\Http\Response
     */
    public function toggle(Request $request, $cc)
    {
        $cc = CostCenter::where('Code','=',$cc)->first();
        $cc->Status = !$cc->Status;
        $cc->save();
        return redirect()->to('/cost-center/view/'.$cc->Code);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CostCenter  $cc
     * @return \Illuminate\Http\Response
     */
    public function destroy(CostCenter $cc)
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
        return response()->json(['aaData'=>CostCenter::all()]);
    }

    /**
     * Fetches all available data.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Json
     */
    public function selectdata(Request $request)
    {
        $data = array();
        foreach(CostCenter::all() as $cc) {
            $entry['id'] = $cc->Code;
            $entry['text'] = $cc->Description;

            array_push($data, $entry);
        }
        return response()->json(['results'=>$data]);
    }
}
