<?php

namespace App\Http\Controllers;

use App\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    
    public function search(Request $request, $value)
    {
        try {
            \App\Role::where('Name','=',$value)->firstOrFail();
        } catch(\Exception $e) {
            return response()->json(false);
        }
        return response()->json(true);
    }
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
        return view('settings.roles.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('settings.roles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $role = new Role();
        $role->Name = $request->Name;
        $permArray = json_decode('['.implode(',',$request->Permissions).']',true);
        $role->Permissions = json_encode($permArray);
        $role->save();

        $name = explode(' ', $request->Name);
        $name = implode('-',$name);
        return redirect()->to('/role/view/'.$role->ID."-".$name);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show($role)
    {
        $data = explode('-', $role, 2);
        $role = Role::where('ID','=',$data[0])->first();
        return view('settings.roles.view', ['data'=>$role]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit($role)
    {
        $data = explode('-', $role, 2);
        $role = Role::where('ID','=',$data[0])->first();
        return view('settings.roles.update', ['data'=>$role]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $role)
    {
        $data = explode('-', $role, 2);
        $role = Role::where('ID','=',$data[0])->first();
        $role->Name = $request->Name;
        $permArray = json_decode('['.implode(',',$request->Permissions).']',true);
        sort($permArray);
        $role->Permissions = json_encode($permArray);
        $role->save();

        $name = explode(' ', $request->Name);
        $name = implode('-',$name);
        return redirect()->to('/role/view/'.$role->ID."-".$name);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        //
    }

    public function data()
    {
        $data = array();
        $roles = Role::all();
        for($i=0;$i<count($roles);$i++){
            $entry = array();
            $entry['ID'] = $roles[$i]->ID;
            $entry['Name'] = $roles[$i]->Name;
            $entry['Status'] = $roles[$i]->Status;
            array_push($data, $entry);
        }
        return response()->json(['aaData'=>$data]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function toggle(Request $request, $role)
    {
        $data = explode('-', $role, 2);
        $role = Role::where('ID','=',$data[0])->first();
        $role->Status = !$role->Status;
        $role->save();
        $name = explode(' ', $role->Name);
        $name = implode('-',$name);
        return redirect()->to('/role/view/'.$role->ID."-".$name);
    }
}
