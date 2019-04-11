<?php

namespace App\Http\Controllers;

use App\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
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
        return view('settings.warehouses.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('settings.warehouses.create');
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
            $location = new Location();
            $location->Name = $request->Name;
            $location->save();
        }

        $name = explode(' ', $location->Name);
        $name = implode('-',$name);
        return redirect()->to('/location/view/'.$location->ID."-".$name);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function show($location)
    {
        $data = explode('-', $location, 2);
        $location = Location::where('ID','=', $data[0])->first();
        return view('settings.warehouses.view', ['data'=>$location]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function edit($location)
    {
        $data = explode('-', $location, 2);
        $location = Location::where('ID','=', $data[0])->first();
        return view('settings.warehouses.update', ['data'=>$location]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $location)
    {
        if($request->Name) {
            $location = new Location();
            $location->Name = $request->Name;
            $location->save();
        }


        $name = explode(' ', $location->Name);
        $name = implode('-',$name);
        return redirect()->to('/location/view/'.$location->ID."-".$name);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function toggle(Request $request, $location)
    {
        $data = explode('-', $location, 2);
        $location = Location::where('ID','=',$data[0])->first();
        $location->Status = !$location->Status;
        $location->save();
        $name = explode(' ', $location->Name);
        $name = implode('-',$name);
        return redirect()->to('/location/view/'.$location->ID."-".$name);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function destroy(Location $location)
    {
        //
    }


    /**
     * Fetches all available data.
     *
     * @param  \App\Person  $contact
     * @param  \Illuminate\Http\Request  $request
     * @return Json
     */
    public function data(Request $request)
    {
        return response()->json(['aaData'=>Location::all()]);
    }


    public function locationdata(Request $request, $product = null) {
        $data = array();
        if($request->q) {
            $locations = Location::where([
                ['Name','like','%'.$request->q.'%'],
                ['Status','=',1]
            ])->get();
            for($i=0;$i<count($locations);$i++){
                $entry['id'] = $locations[$i]->ID;
                $entry['text'] = $locations[$i]->Name;
                array_push($data, $entry);
            }
        } else {
            $locations = Location::all();
            for($i=0;$i<count($locations);$i++){
                $entry['id'] = $locations[$i]->ID;
                $entry['text'] = $locations[$i]->Name;
                array_push($data, $entry);
            }
        }
        return response()->json(['results'=>$data]);
    }

}
