<?php

namespace App\Http\Controllers;

use App\Term;
use Illuminate\Http\Request;

class TermController extends Controller
{
    public function search(Request $request, $value)
    {
        try {
            \App\Term::where('Description','=',$value)->firstOrFail();
        } catch(\Exception $e) {
            return response()->json(false);
        }
        return response()->json(true);
    }
    /**
     * Instantiate a new controller instance.
     *
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
        return view('settings.terms.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('settings.terms.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $term = new Term();
        $term->Description = $request->Description;
        $term->Value = $request->Value;
        $term->Status = true;
        $term->save();

        return redirect()->to('/term/view/'.$term->Description);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($term)
    {
        $term = Term::where('Description','=',$term)->firstOrFail();
        return view('settings.terms.view',['data'=>$term]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($term)
    {
        $term = Term::where('Description','=',$term)->firstOrFail();
        return view('settings.terms.update',['data'=>$term]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $term)
    {
        $term = Term::where('Description','=',$term)->firstOrFail();
        $term->Description = $request->Description;
        $term->Value = $request->Value;
        $term->save();

        return redirect()->to('/term/view/'.$term->Description);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
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
    public function toggle(Request $request, $term)
    {
        $term = Term::where('Description','=',$term)->first();
        $term->Status = !$term->Status;
        $term->save();
        return redirect()->to('/term/view/'.$term->Description);
    }


    public function data() {
        return response()->json(['aaData'=>Term::all()]);
    }

    public function selectdata() {
        $data = array();
        $term = new Term();
        $terms = $term->all();

        foreach($terms as $term) {
            $entry = array();
            $entry['id'] = $term->ID;
            $entry['text'] = $term->Description;
            array_push($data, $entry);
        }

        return response()->json(['results'=>$data]);
    }
}
