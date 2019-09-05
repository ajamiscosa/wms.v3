<?php

namespace App\Http\Controllers;

use App\Department;
use App\GeneralLedger;
use App\Person;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DepartmentController extends Controller
{
    public function search(Request $request, $value)
    {
        try {
            \App\Department::where('Name','=',$value)->firstOrFail();
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
        return view('settings.departments.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('settings.departments.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $temp = json_decode('['.implode(',',$request->Approver).']',true);
        $approvers = json_encode($temp);
        if($request->Name) {
            $department = new Department();
            $department->Code = $request->Code;
            $department->Name = $request->Name;
            $department->Approvers = $approvers;
            $department->Parent = $request->ParentDepartment;
            $department->GL = $request->GL;
            $department->Manager = $request->Manager;
            $department->save();
        }

        $name = explode(' ', $department->Name);
        $name = implode('-',$name);
        return redirect()->to('/department/view/'.$department->ID."-".$name);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function show($department)
    {
        $data = explode('-', $department, 2);
        $department = Department::findByID($data[0]);
        // dd($department);
        return view('settings.departments.view', ['data'=>$department]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function edit($department)
    {
        $data = explode('-', $department, 2);
        $department = Department::where('ID','=', $data[0])->first();
        return view('settings.departments.update', ['data'=>$department]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $department)
    {
        $temp = json_decode('['.implode(',',$request->Approver).']',true);
        $approvers = json_encode($temp);

        $data = explode('-', $department, 2);
        $department = Department::where('ID','=', $data[0])->first();
        $department->Code = $request->Code;
        $department->Name = $request->Name;
        $department->Manager = $request->Manager;
        $department->Approvers = $approvers;
        $department->Parent = $request->ParentDepartment;
        $department->GL = $request->GL;
        $department->save();
        $name = explode(' ', $department->Name);
        $name = implode('-',$name);
        return redirect()->to('/department/view/'.$department->ID."-".$name);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function toggle(Request $request, $department)
    {

        $data = explode('-', $department, 2);
        $department = Department::where('ID','=',$data[0])->first();
        $department->Status = !$department->Status;
        $department->save();
        $name = explode(' ', $department->Name);
        $name = implode('-',$name);
        return redirect()->to('/department/view/'.$department->ID."-".$name);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function destroy(Department $department)
    {
        //
    }

    /**
     * Fetches all available data.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Json
     */
    public function data()
    {
        return response()->json(['aaData'=>Department::all(['ID','Name'])]);
    }

    public function approverdata(Request $request)
    {
        $data = array();
        $query = $request->q ?: $request->term;
        if($query == "undefined") {
            $users = User::all();
            foreach($users as $user) {
                if($user->Status==1) {
                    $entry['id'] = $user->ID;
                    $entry['text'] = $user->Person()->FirstName.' '.$user->Person()->LastName.' ('.$user->Username.')';
                    array_push($data, $entry);
                }
            }
        }
        else{
            $approvers = DB::table('users')
                ->leftJoin('people','users.Person','=','people.ID')
                        ->where('users.Username','like','%'.$query.'%')
                        ->orWhere('people.LastName','like','%'.$query.'%')
                        ->orWhere('people.FirstName','like','%'.$query.'%')
                ->get();

            foreach($approvers as $approver) {
                $approver = Person::where('ID','=',$approver->ID)->first();
                $user = $approver->User();
                if($user->Status == 1) {
                    $entry['id'] = $user->ID;
                    $entry['text'] = $user->Person()->FirstName.' '.$user->Person()->LastName.' ('.$user->Username.')';
                    array_push($data, $entry);
                }
            }
        }
        return response()->json(['results'=>$data]);
    }

    public function parentdata(Request $request) {
        $data = array();
        $query = $request->q ?: $request->term;
        if($query == "undefined") {
            $departments = Department::all();
            for($i=0;$i<count($departments);$i++){
                $entry['id'] = $departments[$i]->ID;
                $entry['text'] = $departments[$i]->Name;
                array_push($data, $entry);
            }
        } else {
            $departments = Department::where('Name','like','%'.$query.'%')->get();
            for($i=0;$i<count($departments);$i++){
                $entry['id'] = $departments[$i]->ID;
                $entry['text'] = $departments[$i]->Name;
                array_push($data, $entry);
            }
        }
        return response()->json(['results'=>$data]);
    }

    public function gldata(Request $request)
    {
        $data = array();
        $query = $request->q ?: $request->term;
        if($query == "undefined") {
            $gl = GeneralLedger::all();
            for($i=0;$i<count($gl);$i++){
                $entry['id'] = $gl[$i]->ID;
                $entry['text'] = '['.$gl[$i]->Code.'] '.$gl[$i]->Description;
                array_push($data, $entry);
            }
        } else {
            $gl = GeneralLedger::where(function($query) use ($request){
                $query->where('Code','like','%'.$query.'%')
                    ->orWhere('Description','like','%'.$query.'%');
            })->get();

            for($i=0;$i<count($gl);$i++){
                $entry['id'] = $gl[$i]->ID;
                $entry['text'] = '['.$gl[$i]->Code.'] '.$gl[$i]->Description;
                array_push($data, $entry);
            }
        }
        return response()->json(['results'=>$data]);
    }


    public function getCostCenterData(Request $request)
    {
        $data = array();
        $query = $request->q ?: $request->term;
        $department = new Department();

        foreach($department->all() as $department) {
            if($department->GL!==null) {
                $entry['id'] = $department->GL;
                $entry['text'] = '['.$department->GL.'] '.$department->Name;
                array_push($data, $entry);
            }
        }
        return response()->json(['results'=>$data]);
    }

}
