<?php

namespace App\Http\Controllers;

use App\Department;
use App\GeneralLedger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GeneralLedgerController extends Controller
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
        return view('settings.gl.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('settings.gl.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $ledger = new GeneralLedger();
        $ledger->Code = $request->Code.'-'.$request->CostCenter.'-'.$request->ProductLine;
        $ledger->Description = $request->Description;
        $ledger->Type = $request->AccountType;
        $ledger->Status = 1;
        $ledger->save();

        return redirect()->to('/gl/view/'.$request->Code.'-'.$request->CostCenter.'-'.$request->ProductLine);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\GeneralLedger  $ledger
     * @return \Illuminate\Http\Response
     */
    public function show($ledger)
    {
        $ledger = GeneralLedger::where('Code','=', $ledger)->first();
        return view('settings.gl.view', ['data'=>$ledger]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\GeneralLedger  $ledger
     * @return \Illuminate\Http\Response
     */
    public function edit($ledger)
    {
        $ledger = GeneralLedger::where('Code','=', $ledger)->first();
        return view('settings.gl.update', ['data'=>$ledger]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\GeneralLedger  $ledger
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $ledger)
    {
        $ledger = GeneralLedger::where('Code','=', $ledger)->first();
        $ledger->Code = $request->Code.'-'.$request->CostCenter.'-'.$request->ProductLine;
        $ledger->Description = $request->Description;
        $ledger->save();
        return redirect()->to('/gl/view/'.$ledger->Code);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\GeneralLedger  $ledger
     * @return \Illuminate\Http\Response
     */
    public function toggle(Request $request, $ledger)
    {
        $ledger = GeneralLedger::where('Code','=', $ledger)->first();
        $ledger->Status = !$ledger->Status;
        $ledger->save();
        return redirect()->to('/gl/view/'.$ledger->Code);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\GeneralLedger  $ledger
     * @return \Illuminate\Http\Response
     */
    public function destroy(GeneralLedger $ledger)
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
        return response()->json(['aaData'=>GeneralLedger::all()]);
    }


    public function selectdata(Request $request) {
        $data = array();
        if($request->term) {
            if($request->term=='undefined'){
                $glcodes = GeneralLedger::all();
                foreach ($glcodes as $glcode) {
                    $entry = array();
                    $entry['id'] = $glcode->ID;
                    $entry['text'] = '[' . $glcode->Code . '] ' . $glcode->Description;
                    $entry['code'] = $glcode->Code;
                    $entry['currency'] = $glcode->Currency;
                    array_push($data, $entry);
                }
            } else {
                $glcodes = DB::table('gl')
                    ->where('Code', 'like', '%' . $request->term . '%')
                    ->orWhere('Description', 'like', '%' . $request->term . '%')
                    ->get();

                foreach ($glcodes as $glcode) {
                    $entry = array();
                    $entry['id'] = $glcode->ID;
                    $entry['text'] = '[' . $glcode->Code . '] ' . $glcode->Description;
//                    $entry['code'] = $glcode->Code;
//                    $entry['currency'] = $glcode->Currency;
                    array_push($data, $entry);
                }
            }
        }


        return response()->json(['results'=>$data]);
    }

}
