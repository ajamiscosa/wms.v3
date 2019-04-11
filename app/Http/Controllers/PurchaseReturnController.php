<?php

namespace App\Http\Controllers;

use App\Form;
use App\LineItem;
use App\PurchaseOrder;
use App\PurchaseReturn;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseReturnController extends Controller
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
        return view('purchasing.purchase-returns.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($po)
    {
        $po = PurchaseOrder::where('OrderNumber','=',$po)->first();
        return view('purchasing.purchase-returns.create', ['data'=>$po]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $orderNumber = Form::CurrentNumber('PurchaseReturn');

        DB::transaction(function() use ($request, $orderNumber){
            $pr = new PurchaseReturn();
            $pr->OrderNumber = $orderNumber;
            $pr->PurchaseOrder = $request->PurchaseOrder;
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

        return redirect()->to('/purchase-return/view/'.$orderNumber);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PurchaseReturn  $purchaseReturn
     * @return \Illuminate\Http\Response
     */
    public function show($purchaseReturn)
    {
        $pr = PurchaseReturn::where('OrderNumber','=',$purchaseReturn)->first();
        return view('purchasing.purchase-returns.view', ['data'=>$pr]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PurchaseReturn  $purchaseReturn
     * @return \Illuminate\Http\Response
     */
    public function edit(PurchaseReturn $purchaseReturn)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PurchaseReturn  $purchaseReturn
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PurchaseReturn $purchaseReturn)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PurchaseReturn  $purchaseReturn
     * @return \Illuminate\Http\Response
     */
    public function destroy(PurchaseReturn $purchaseReturn)
    {
        //
    }


    public function data()
    {
        $data = array();
        $orders = PurchaseReturn::all();
        foreach($orders  as $order)
        {
            $entry = array();
            $entry['OrderNumber'] = $order->OrderNumber;
            $entry['ReceiveDate'] = $order->Date->format('F d, Y');
            $entry['PurchaseOrder'] = $order->PurchaseOrder()->OrderNumber;
            $entry['Supplier'] = $order->PurchaseOrder()->Supplier()->Name;
            $entry['Location'] = $order->PurchaseOrder()->Warehouse()->Name;
            $entry['Status'] = $order->Status;
            array_push($data, $entry);
        }

        return response()->json(['aaData'=>$data]);
    }
}
