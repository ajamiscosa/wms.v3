<?php

namespace App\Http\Controllers;

use App\Classes\DTO\DTO;
use App\Form;
use App\InventoryLog;
use App\LineItem;
use App\OrderItem;
use App\PurchaseOrder;
use App\ReceiveOrder;
use App\Role;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Svg\Tag\Line;

class ReceiveOrderController extends Controller
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
        return view('purchasing.receive-orders.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $po = new PurchaseOrder();
        $data = $po->where('OrderNumber','=',$id)->firstOrFail();
        return view('purchasing.receive-orders.create',['data'=>$data]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        $orderItem = new OrderItem();
        $po = new PurchaseOrder();
        $po = $po->where('OrderNumber','=',$id)->firstOrFail();


        $rrNumber = "";


        $lastReceipt = ReceiveOrder::orderByDesc('ID')->first();
        $length = strlen($lastReceipt->OrderNumber);
            
        $prefix = Carbon::today()->format('ym');
        $currentMonth = substr($lastReceipt->OrderNumber,6,4);
        if($prefix==$currentMonth) {
            $current = substr($lastReceipt->OrderNumber, $length-3);
            $current++;
        }
        else {
            $current = 0;
            $current++;
        }

        for($i=0;$i<count($request->OrderItem); $i++) {
            if($request->Quantity[$i]>0) {
                $ro = new ReceiveOrder();
                $ro->PurchaseOrder = $po->ID;
                $orderItem = $orderItem->where('ID','=',$request->OrderItem[$i])->firstOrFail();
                $lineItem = $orderItem->LineItem();

                $ro->OrderItem  = $orderItem->ID;
                $ro->Received = Carbon::now();
                $ro->ReferenceNumber = $request->ReferenceNumber;

                try {
                    $latest = $ro->where('PurchaseOrder','=',$orderItem->PurchaseOrder)->orderBy('Received', 'desc')->firstOrFail();
                    $ro->Series = $latest->Series + 1;
                } catch(\Exception $exception) {
                    $ro->Series = 1;
                }

                $ro->Quantity = $request->Quantity[$i];

    
                $rrNumber = sprintf("RR%s%s%s",
                    substr($po->OrderNumber,2,4),
                    Carbon::today()->format('ym'),
                    str_pad($current,3,'0',STR_PAD_LEFT)
                );
                
                $ro->OrderNumber = $rrNumber;

                $remarks = array();
                $remark = array(
                    'receiver'=>$request->Receiver,
                    'message'=>$request->Remarks
                );
                array_push($remarks, $remark);

                $ro->Remarks = json_encode(['data'=>$remarks]);
                $ro->save();

                $product = $lineItem->Product();

                $inventoryLog = new InventoryLog();
                $inventoryLog->Product = $lineItem->Product;
                $inventoryLog->Type = 'I'; // item out ito.
                $inventoryLog->TransactionType = 'RR'; // Receiving Receipt
                $inventoryLog->Quantity = $request->Quantity[$i];
                $inventoryLog->Initial = $product->Quantity;
                $inventoryLog->Final = $product->Quantity + $request->Quantity[$i];
                $inventoryLog->save();

                $product->Quantity = $product->Quantity + $request->Quantity[$i];
                $product->save();
            }
        }

        return redirect()->back()->with('message','Success!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ReceiveOrder  $receiveOrder
     * @return \Illuminate\Http\Response
     */
    public function show($receiveOrder)
    {
        $ro = ReceiveOrder::where('OrderNumber','=',$receiveOrder)->first();

        return view('purchasing.receive-orders.view', ['data'=>$ro]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ReceiveOrder  $receiveOrder
     * @return \Illuminate\Http\Response
     */
    public function edit(ReceiveOrder $receiveOrder)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ReceiveOrder  $receiveOrder
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ReceiveOrder $receiveOrder)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ReceiveOrder  $receiveOrder
     * @return \Illuminate\Http\Response
     */
    public function destroy(ReceiveOrder $receiveOrder)
    {
        //
    }

    public function data()
    {
        $data = array();
        $po = new PurchaseOrder();

        $orders = $po->where('Status','=','A')->get();
        foreach($orders  as $order)
        {
            $entry = array();
            $entry['OrderNumber'] = $order->OrderNumber;
            $entry['ChargeNo'] = $order->ChargeNo;
            $entry['OrderDate'] = $order->OrderDate->format('F d, Y');
            $entry['DeliveryDate'] = $order->DeliveryDate->format('F d, Y');
            $entry['PaymentTerm'] = $order->PaymentTerm()->Description;
            array_push($data, $entry);
        }

        return response()->json(['aaData'=>$data]);
    }

    public function getReceiptTransactionsOfPurchaseOrder($id) {
        $data = array();


        try{
            $po = new PurchaseOrder();

            $po = $po->where('OrderNumber','=',$id)->firstOrFail();
            if($po) {
                for($i=0; $i<count($po->ReceiveOrders()); $i++) {
                    $ro = $po->ReceiveOrders()[$i];
                    $orderItem = $ro->OrderItem();
                    $lineItem = $orderItem->LineItem();
                    $product = $lineItem->Product();
                    $entry = array();
                    $entry['Item'] = sprintf("[%s] %s %s", $product->UniqueID, $product->Name, $product->Description);
                    $entry['Quantity'] = sprintf("%s %s",$ro->Quantity, $product->UOM()->Abbreviation);
                    $remarks = json_decode($ro->Remarks, true);
                    $entry['Receiver'] = $remarks['data'][0]['receiver'];
                    $entry['Received'] = Carbon::parse($ro->Received)->toDateTimeString();
                    $entry['Message'] = $remarks['data'][0]['message'];
                    $entry['TimeStamp'] = Carbon::parse($ro->Received)->timestamp;
                    array_push($data, $entry);
                }
            }

            usort($data, function($a, $b) {
                return $a['TimeStamp'] - $b['TimeStamp'];
            });

            return response()->json(['data'=>$data]);
        } catch(\Exception $exc){
            dd($exc);
        }
    }

    public function showReceivingForm() {
        return view('purchasing.receive-orders.receiving');
    }

    public function generateReceivingForm($receiveOrder) {
        $rr = new ReceiveOrder();

        try{
            $rr = $rr->where('OrderNumber', '=',$receiveOrder)->first();
            if($rr) {
                $file = Storage::url('/app/template/rr.xlsx');

                $po = $rr->PurchaseOrder();
                $orderItem = $rr->OrderItem();
                $quote = $orderItem->SelectedQuote();
                $supplier = $quote->Supplier();
                $term = $po->PaymentTerm();



//                $timeChecked = $timeChecked_raw->created_at->format('h:i:s A -');
                $dto = new DTO();
                $dto->SupplierName = $supplier->Name;
                $dto->ReferenceNo = $rr->ReferenceNumber;
                $dto->OrderNumber = $po->OrderNumber;
                $dto->PurchaseOrderDate = $po->OrderDate->format('F d, Y');
                $dto->Term = $term->Description;
                $dto->RRNumber = $rr->OrderNumber;
                $dto->DateReceived = Carbon::parse($rr->Received)->format('F d, Y');
                $dto->DatePrepared = Carbon::parse($rr->Received)->format('F d, Y   h:i A');
                $dto->DueDate = $po->OrderDate->addDays($supplier->Due)->format('F d, Y');
                $dto->VendorID = $supplier->Code;
                $dto->OrderItems = $rr->getOrderItems();


//
//                $counter = 13;
//                foreach($rr->LineItems() as $lineItem) {
//                    $orderItem = $lineItem->OrderItem();
//                    $product = $lineItem->Product();
//                    $quote = $orderItem->SelectedQuote();
//
//                    $data["A$counter"] = $lineItem->Quantity;
//                    $data["B$counter"] = $product->UOM()->Abbreviation;
//                    $data["D$counter"] = $product->UniqueID;
//                    $data["F$counter"] = $product->getGeneralLedger()->Code; // TODO: I dunno what code is attached here.
//                    $data["H$counter"] = $product->Description;
//
//                    $data["N$counter"] = $quote->Supplier()->Code;
//                    $data["P$counter"] = number_format($quote->Amount,2,'.',',');
//                    $data["Q$counter"] = $orderItem->created_at->format('n/d/Y');
//                    $data["Y$counter"] = number_format($lineItem->Quantity * $quote->Amount,2,'.',',');
//                    $counter++;
//                }
//
                $fileName = $rr->OrderNumber;
//
//                $pdf = \PDF::loadView('report.templates.receiving',['data'=>$dto]);
//                return $pdf->download('document.pdf');

                return view('report.templates.receiving',['data'=>$dto]);

//                Excel::load($file, function($reader) use ($data) {
//                    $reader->sheet(0, function($sheet) use ($data) {
//                        foreach($data as $key=>$value) {
//                            $sheet->cell($key, function($cell) use ($value) {
//                                $cell->setValue($value);
//                            });
//                        }
//                    });
//
//                })
//                    ->setFilename($fileName)
//                    ->export('xlsx');
            } else {
                $data = new DTO();
                $data->Title = "Purchase Request $receiveOrder";
                $data->Class = "Purchase Request";
                $data->Description = "We cannot not find the $data->Class in the database.";
                return response()
                    ->view('errors.404',['data'=>$data]
                        ,404);
            }
        } catch(\Exception $exc) {
            dd($exc);
        }

    }
}
