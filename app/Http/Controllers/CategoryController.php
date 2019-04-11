<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
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
        return view('settings.categories.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('settings.categories.create');
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
            $category = new Category();
            $category->Name = $request->Name;
            $category->Description = $request->Description;
            $category->save();
        }

        $name = explode(' ', $category->Name);
        $name = implode('-',$name);
        return redirect()->to('/category/view/'.$category->ID."-".$name);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show($category)
    {
        $category = Category::where('Identifier','=',$category)->first();
        return view('settings.categories.view', ['data'=>$category]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit($category)
    {
        $category = Category::where('Identifier','=', $category)->first();
        return view('settings.categories.update', ['data'=>$category]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $category)
    {
        $category = Category::where('Identifier','=', $category)->first();
        $category->Identifier = $request->Identifier;
        $category->Description = $request->Description;
        $category->save();

        return redirect()->to('/category/view/'.$category->Identifier);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function toggle(Request $request, $category)
    {
        $category = Category::where('Identifier','=',$category)->first();
        $category->Status = !$category->Status;
        $category->save();
        return redirect()->to('/category/view/'.$category->Identifier);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
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
        return response()->json(['aaData'=>Category::all()]);
    }

    public function getSelectData() {
        $data = array();
        foreach(Category::all() as $category) {
            $entry = array();
            $entry['id'] = $category->ID;
            $entry['text'] = sprintf("[%s] %s", $category->Identifier, $category->Description);
            array_push($data, $entry);
        }

        return response()->json(['results'=>$data]);
    }
}
