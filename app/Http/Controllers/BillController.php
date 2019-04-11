<?php

namespace App\Http\Controllers;

use App\Bill;
use App\Form;
use App\LineItem;
use App\PurchaseOrder;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BillController extends Controller
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
        return view('purchasing.purchase-invoices.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($po)
    {
        $po = PurchaseOrder::where('OrderNumber','=',$po)->first();
        return view('purchasing.purchase-invoices.create',['data'=>$po]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $orderNumber = Form::CurrentNumber('Bill');

        DB::transaction(function() use ($request, $orderNumber){
            $pr = new Bill();
            $pr->OrderNumber = $orderNumber;
            $pr->PurchaseOrder = $request->PurchaseOrder;
            $pr->PaymentTerm = $request->PaymentTerm;
            $pr->Date = Carbon::parse($request->ReceiveDate);//->parse('F d, y');
            $pr->Status = 'P';
            $pr->Remarks = $request->Remarks;
            $pr->Total = $request->TotalAmount;
            $pr->save();

            for($i=0;$i<count($request->Selected);$i++) {
                $index = $request->Selected[$i];
                $lineItem = new LineItem();
                $lineItem->OrderNumber = $pr->OrderNumber;
                $lineItem->Variant = $request->Variant[$index];
                $lineItem->Quantity = $request->Quantity[$index];
                $lineItem->UnitOfMeasure = $request->UOM[$index];
                $lineItem->save();
            }
        });

        return redirect()->to('/purchase-invoice/view/'.$orderNumber);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Bill  $bill
     * @return \Illuminate\Http\Response
     */
    public function show($bill)
    {
        $bill = Bill::where('OrderNumber', $bill)->first();
        return view('purchasing.purchase-invoices.view', ['data'=>$bill]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Bill  $bill
     * @return \Illuminate\Http\Response
     */
    public function edit(Bill $bill)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Bill  $bill
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bill $bill)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Bill  $bill
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bill $bill)
    {
        //
    }

    public function data()
    {
        $data = array();
        $bills = Bill::all();
        foreach($bills  as $bill)
        {
            $entry = array();
            $entry['OrderNumber'] = $bill->OrderNumber;
            $entry['OrderDate'] = $bill->Date->format('F d, Y');
            $entry['DueDate'] = $bill->Date->addDays($bill->PurchaseOrder()->PaymentTerm)->format('F d, Y');
            $entry['PurchaseOrder'] = $bill->PurchaseOrder()->OrderNumber;
            $entry['Supplier'] = $bill->PurchaseOrder()->Supplier()->Name;
            $entry['Paid'] = 0;
            $entry['Total'] = '₱ '.number_format($bill->Total,2,'.',',');
            array_push($data, $entry);
        }

        return response()->json(['aaData'=>$data]);
    }
}
