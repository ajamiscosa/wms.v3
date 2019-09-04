<?php

namespace App\Http\Controllers;

use App\Currency;
use Illuminate\Http\Request;

class CurrencyController extends Controller
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
        return view('settings.currencies.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('settings.currencies.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $currency = new Currency();
        $currency->Code = $request->Code;
        $currency->Name = $request->Name;
        $currency->USD = $request->USD;
        $currency->PHP = $request->PHP;
        $currency->save();

        return redirect()->to('/currency/view/'.$currency->Code);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Currency  $currency
     * @return \Illuminate\Http\Response
     */
    public function show($currency)
    {
        $currency = Currency::where('Code','=', $currency)->first();
        return view('settings.currencies.view', ['data'=>$currency]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Currency  $currency
     * @return \Illuminate\Http\Response
     */
    public function edit($currency)
    {
        $currency = Currency::where('Code','=', $currency)->first();
        return view('settings.currencies.update', ['data'=>$currency]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Currency  $currency
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $currency = new Currency();
        $currencyList = $currency->get();
        

        $usd = $currency->where('Code','=','USD')->firstOrFail();
        $usd->PHP = $request->Rate;
        $usd->save();


        foreach($currencyList as $currency) {
            if($currency->Code == "PHP") {
                $currency->USD = 1 / $usd->PHP;
                $currency->save();
            }
            else {
                try{
                    $currency->PHP = $currency->USD * $request->Rate;
                    $currency->save();
                }catch(\Exception $exc) {
                    dd($currency);
                }
            }
        }

        return redirect()->to('/currency/');
    }

    public function updaterate(Request $request) {
        $currency = new Currency();

        try {
            $currency = $currency->where('Code','=',$request->Code)->firstOrFail();
            $currency->USD = $request->Rate;
            $currency->PHP = $currency->USD * $request->Rate;
            $currency->save();
        }
        catch(\Exception $exc){ 
            return response()->json(['message'=>'Failed. '.$exc]);
        }

        return response()->json(['message'=>'Success.']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Currency  $currency
     * @return \Illuminate\Http\Response
     */
    public function toggle(Request $request, $currency)
    {
        $data = explode('-', $currency, 2);
        $currency = Currency::where('ID','=',$data[0])->first();
        $currency->Status = !$currency->Status;
        $currency->save();
        $name = explode(' ', $currency->Name);
        $name = implode('-',$name);
        return redirect()->to('/currency/view/'.$currency->ID."-".$name);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Currency  $currency
     * @return \Illuminate\Http\Response
     */
    public function destroy(currency $currency)
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
        return response()->json(['aaData'=>Currency::all()]);
    }
}
