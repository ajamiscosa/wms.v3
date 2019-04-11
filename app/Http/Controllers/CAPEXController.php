<?php

namespace App\Http\Controllers;

use App\CAPEX;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Classes\ReportHelper;

class CAPEXController extends Controller
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
        return view('settings.capex.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('settings.capex.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->JobID) {
            $capex = new CAPEX();
            $capex->JobID = $request->JobID;
            $capex->JobDescription = $request->JobDescription;
            $capex->UsePhases = 'FALSE';
            $capex->Inactive = 'FALSE';
            $capex->Supervisor = strtoupper($request->Supervisor);
            $capex->StartDate = Carbon::parse($request->StartDate)->format('Y-m-d');
            $capex->JobStatus = 'In Progress';
            $capex->BillingMethod = 0;
            $capex->PercentComplete = 0;
            $capex->LaborBurdenPercent = 0;
            $capex->RetainagePercent = 0;
            $capex->NoOfUnits = 0;
            $capex->DistributionEstRevenues = 0;
            $capex->DistributionEstExpenses = 0;
            // dd($capex);
            $capex->save();
        }

        $name = explode(' ', $capex->JobDescription);
        $name = implode('-',$name);
        return redirect()->to('/capex/view/'.$capex->ID."-".$name);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show($category)
    {
        $category = CAPEX::where('ID','=',$category)->first();
        return view('settings.capex.view', ['data'=>$category]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit($category)
    {
        $category = CAPEX::where('ID','=', $category)->first();
        return view('settings.capex.update', ['data'=>$category]);
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
        if($request->JobID) {
            $capex = CAPEX::where('ID','=',$category)->first();
            $capex->JobID = $request->JobID;
            $capex->JobDescription = $request->JobDescription;
            $capex->Supervisor = strtoupper($request->Supervisor);
            $capex->StartDate = Carbon::parse($request->StartDate)->format('Y-m-d');
            // dd($capex);
            $capex->save();
        }

        $name = explode(' ', $capex->JobDescription);
        $name = implode('-',$name);
        return redirect()->to('/capex/view/'.$capex->ID."-".$name);
    }

    /**
     * Fetches all available data.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Json
     */
    public function data(Request $request)
    {
        return response()->json(['aaData'=>CAPEX::all()]);
    }

    public function export(Request $request) {
        $capex = new CAPEX();

        // if(isset($request->start)) {
        //     $start = Carbon::parse($request->start);
        //     $end = Carbon::parse($request->end);

        //     if($start->format('Ymd')===$end->format('Ymd')) {
        //         $end = $end->addDay();
        //     }

        //     $capexs = $capex->whereBetween('created_at', [$start, $end]);
        //     $title = sprintf("%s-%s", $start->format('Ymd'), $end->format('Ymd'));
        // }
        // else {
        //     $capexs = $capex->whereDate('created_at', '=', Carbon::today()->toDateString());
        //     $title = Carbon::today()->format('Ymd');
        // }

        $title = Carbon::today()->format('Ymd');
        $columns = array(
            'Job ID', 'Job Description',
            'Use Phases', 'Inactive',
            'Supervisor', 'Customer ID',
            'Address Line 1', 'Address Line 2',
            'City', 'State',
            'Zip', 'Country',
            'Start Date', 'Projected End Date',
            'Actual End Date', 'Job Status',
            'Job Type', 'PO Number',
            'Billing Method', '% Complete',
            'Labor Burden Percent',
            'Retainage Percent', 'Second Contact',
            'Special Instruct', 'Site Phone #',
            'Contract Date',
            'Work Phone #',
            'Job Note',
            'Distribution Phase ID',
            'Distribution Cost Code ID',
            '# of Units',
            'Distribution Est. Revenues',
            'Distribution Est. Expenses'
        );


        $data = array();
        foreach($capex->get() as $capex) {
            $entry = array(
                $capex->JobID,
                $capex->JobDescription,
                'FALSE',
                'FALSE',
                $capex->Supervisor,
                null,
                null,
                null,
                null,
                null,
                null,
                null,
                $capex->StartDate,
                null,
                null,
                'In Progress',
                null,
                null,
                0,
                0,
                0,
                0,
                null,
                null,
                null,
                null,
                null,
                null,
                null,
                null,
                0,
                0,
                0
            );

            array_push($data, $entry);
        }

        $fileName = sprintf('CAPEX%s.csv', $title);
        return ReportHelper::export($fileName,$columns,$data);
    }
}
