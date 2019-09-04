<?php

namespace App\Http\Controllers;

use App\Contact;
use App\PhonebookEntry;
use App\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SupplierController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    function __construct()
    {
        $this->middleware('auth')->except('androidGetSupplier');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('suppliers.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('suppliers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $supplier = new Supplier();
        $supplier->Code = $request->Code;
        $supplier->Name = $request->Name;
        $supplier->TIN = $request->TIN;
        $supplier->SupplierType = $request->SupplierType;
        $supplier->Currency = $request->Currency;
        $supplier->DeliveryLeadTime = $request->DeliveryLeadTime;
        // $supplier->ShippingMethod = $request->ShipVia;
        $supplier->Term = $request->Term;
        $supplier->Contact = $request->Contact;
        $supplier->AddressLine1 = $request->AddressLine1;
        $supplier->AddressLine2 = $request->AddressLine2;
        $supplier->City = $request->City;
        $supplier->State = $request->State;
        $supplier->Zip = $request->Zip;
        $supplier->Country = $request->Country;
        $supplier->Telephone1 = $request->Telephone1;
        $supplier->Telephone2 = $request->Telephone2;
        $supplier->FaxNumber = $request->FaxNumber;
        $supplier->Email = $request->Email;
        $supplier->WebSite = $request->WebSite;
        $supplier->Status = true;
        $supplier->Classification = $request->Classification;
        $supplier->save();

        return redirect()->to('/vendor/view/'.$supplier->Code);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function show($supplier) {
        $supplier = Supplier::where('Code','=',$supplier)->first();
        // dd($supplier->PaymentTerm()->Description);
        return view('suppliers.view', ['data'=>$supplier]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function edit($supplier)
    {
        $supplier = Supplier::where('Code','=',$supplier)->first();
        return view('suppliers.update', ['data'=>$supplier]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $supplier)
    {
        $supplier = Supplier::where('Code','=',$supplier)->first();

        $supplier->Code = $request->Code;
        $supplier->Name = $request->Name;
        $supplier->SupplierType = $request->SupplierType;
        $supplier->Currency = $request->Currency;
        $supplier->DeliveryLeadTime = $request->DeliveryLeadTime;
        // $supplier->ShippingMethod = $request->ShipVia;
        $supplier->Term = $request->Term;
        $supplier->Contact = $request->Contact;
        $supplier->AddressLine1 = $request->AddressLine1;
        $supplier->AddressLine2 = $request->AddressLine2;
        $supplier->City = $request->City;
        $supplier->State = $request->State;
        $supplier->Zip = $request->Zip;
        $supplier->Country = $request->Country;
        $supplier->Telephone1 = $request->Telephone1;
        $supplier->Telephone2 = $request->Telephone2;
        $supplier->FaxNumber = $request->FaxNumber;
        $supplier->Email = $request->Email;
        $supplier->WebSite = $request->WebSite;
        $supplier->Status = $request->Status;
        $supplier->Classification = $request->Classification;
        $supplier->save();

        return redirect()->to('/vendor/view/'.$supplier->Code);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function destroy(Supplier $supplier)
    {
        //
    }


    public function selectdata(Request $request) {
        $data = array();
        if($request->term) {
            if($request->term=='undefined'){
                $suppliers = Supplier::all();
                foreach ($suppliers as $supplier) {
                    $entry = array();
                    $entry['id'] = $supplier->ID;
                    $entry['text'] = '[' . $supplier->Code . '] ' . $supplier->Name;
                    $entry['code'] = $supplier->Code;
                    $entry['currency'] = $supplier->Currency;
                    array_push($data, $entry);
                }
            } else {
                $suppliers = DB::table('suppliers')
                    ->where('Code', 'like', '%' . $request->term . '%')
                    ->orWhere('Name', 'like', '%' . $request->term . '%')
                    ->get();

                foreach ($suppliers as $supplier) {
                    $entry = array();
                    $entry['id'] = $supplier->ID;
                    $entry['text'] = '[' . $supplier->Code . '] ' . $supplier->Name;
                    $entry['code'] = $supplier->Code;
                    $entry['currency'] = $supplier->Currency;
                    array_push($data, $entry);
                }
            }
        }


        return response()->json(['results'=>$data]);
    }

    public function data() {
        $data = array();
        $suppliers = Supplier::all();

        foreach($suppliers as $supplier) {
            $entry = array();
            $entry['Code'] = $supplier->Code;
            $entry['Name'] = $supplier->Name;

            array_push($data, $supplier);
        }

        return response()->json(['aaData'=>$data]);
    }

    public function productlist($supplier)
    {
        $data = explode('-',$supplier);
        $supplier = Supplier::where('ID','=',$data[0])->first();
        return view('suppliers.product',['data'=>$supplier->Products()]);
    }

    public function search(Request $request, $id) {
        try {
            Supplier::where('Code','=',$id)->firstOrFail();
        } catch(\Exception $e) {
            return response()->json(false);
        }
        return response()->json(true);
    }

// android
    public function androidGetSupplier($supplier) {
        $supplier = Supplier::where('ID','=',$supplier)->first();

        $data = array();
        if($supplier){
            $data['Name'] = $supplier->Name;
            //$data['Description'] = $supplier->Description;
        }

        return response()->json($data);
    }
}
