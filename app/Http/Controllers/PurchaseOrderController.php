<?php

namespace App\Http\Controllers;

use App\Classes\DTO\DTO;
use App\Classes\IssuanceHelper;
use App\Form;
use App\GeneralLedger;
use App\LineItem;
use App\OrderItem;
use App\Product;
use App\ProductLine;
use App\PurchaseOrder;
use App\Quote;
use App\Requisition;
use App\Role;
use App\StatusLog;
use App\Supplier;
use App\UnitOfMeasure;
use App\User;
use App\Variant;
use Carbon\Carbon;
use function foo\func;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use SebastianBergmann\Diff\Line;

class PurchaseOrderController extends Controller
{
    static private $series;
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    function __construct()
    {
        $this->middleware('auth')->except('androidGetPO');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('purchasing.purchase-orders.index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showItemsReadyForPO()
    {
        return view('purchasing.purchase-orders.orderitems');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $data = PurchaseOrder::where('OrderNumber','=',$id)->first();
        return view('purchasing.purchase-orders.create',['data'=>$data]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = array();
        // TODO: Create PO for each vendor.

//
//        self::$series = 0;
//
//        $today = Carbon::today();
//        $latestPO = new PurchaseOrder();
//        $latestPO = $latestPO->orderBy('Series', 'desc')->first();
//
//        if($latestPO && strpos($latestPO->OrderNumber,$today->format('my'))!==false) {
//            self::$series = $latestPO->Series + 1;
//        } else {
//            self::$series = 1;
//        }
//
//
//        foreach($request->OrderItem as $item) {
//
//            $orderItem = new OrderItem();
//            $orderItem = $orderItem->where('ID','=',$item)->firstOrFail();
//
//
//            $quote = $orderItem->SelectedQuote();
//            $supplier = $quote->Supplier();
//            $requisition = $orderItem->Requisition();
//            $lineItem = $orderItem->LineItem();
//
//
//            $data[$supplier->ID][$requisition->OrderNumber] = array();
//
//            array_push($data[$supplier->ID][$requisition->OrderNumber], $orderItem);
//
//            if(isset($data[$supplier->ID][$requisition->OrderNumber]['Counter'])) {
//                $data[$supplier->ID][$requisition->OrderNumber]['Counter']++;
//            } else {
//                $data[$supplier->ID][$requisition->OrderNumber]['Counter'] = 1;
//            }
//
//
//            $lineItem->Ordered = true; // ordered
//            //$lineItem->save();
//
//
//
//            DB::transaction(function () use ($request, $item) {
//                $today = Carbon::today();
//                $po = new PurchaseOrder();
//                $po->OrderNumber = sprintf("%s%s",
////                    $category,
////                    $supplier->SupplierType==1?"PH":"US",
//                    $today->format('my'),
//                    str_pad(self::$series,3,'0',STR_PAD_LEFT)
//                );
//                $po->ChargeNo = $item;
//                $po->ChargeType = 'S';
//                $po->Series = self::$series;
//                $po->Supplier = $supplier->ID;
//                $po->OrderDate = $today;
//                $po->DeliveryDate = $today->addDays($supplier->SupplierType==1?14:90);
//                $po->PaymentTerm = 0;
//                $po->Total = 0;
//                $po->APAccount = 0;
//                $po->Status = 'D'; // draft
//
//
//                $po->Total += ($quote->Amount * $lineItem->Quantity);
//            }
//
//        }



        // Step 1: Identify suppliers to create PO to.
        foreach($request->SelectedItems as $selectedItem) {
            $requisition = new Requisition();
            $quote = new Quote();

            $entry = explode('-',$selectedItem);
            $requisitionField = $entry[1];
            $quoteField = $entry[2];

            $quote = $quote->where('ID','=',$quoteField)->first();
            $requisition = $requisition->where('ID','=',$requisitionField)->first();

            $supplier = $quote->Supplier();

            $data[$supplier->ID][$requisition->OrderNumber] = array();
        }


        // Step 2: Assign each OrderItem for each created PO.
//        foreach($request->SelectedItems as $selectedItem) {
        for($i=0;$i<count($request->SelectedItems);$i++) {
            $quote = new Quote();
            $lineItem = new LineItem();
            $requisition = new Requisition();

            $selectedItem = $request->SelectedItems[$i];
            $entry = explode('-', $selectedItem);
            $lineItemField = $entry[0];
            $requisitionField = $entry[1];
            $quoteField = $entry[2];

            $quote = $quote->where('ID','=',$quoteField)->first();
            $lineItem = $lineItem->where('ID','=',$lineItemField)->first();
            $requisition = $requisition->where('ID','=',$requisitionField)->first();

            $supplier = $quote->Supplier();

            $sub = array();

            $sub['Requisition'] = $requisition->ID;
            $sub['LineItem'] = $lineItem->ID;
            $sub['Quote'] = $quote->ID;
            $sub['OrderItem'] = (int)$request['OrderItem'][$i];

            array_push($data[$supplier->ID][$requisition->OrderNumber], $sub);

            $data[$supplier->ID][$requisition->OrderNumber]['Supplier'] = $supplier->ID;
            $data[$supplier->ID][$requisition->OrderNumber]['OrderNumber'] = $requisition->OrderNumber;


            if(isset($data[$supplier->ID][$requisition->OrderNumber]['Counter'])) {
                $data[$supplier->ID][$requisition->OrderNumber]['Counter']++;
            } else {
                $data[$supplier->ID][$requisition->OrderNumber]['Counter'] = 1;
            }
        }

        self::$series = 0;

        $today = Carbon::today();
        $latestPO = new PurchaseOrder();
        $latestPO = $latestPO->orderBy('created_at')->get()->last();

        if($latestPO && strpos($latestPO->OrderNumber,$today->format('my'))!==false) {
            self::$series = $latestPO->Series + 1;
        } else {
            self::$series = 1;
        }





        
        if(count(PurchaseOrder::orderByDesc('created_at')->get())>1){
            $lastReceipt = PurchaseOrder::orderByDesc('created_at')->orderByDesc('OrderNumber')->first();
        }
        else {
            $lastReceipt = PurchaseOrder::orderByDesc('created_at')->first();
        }
    
        if($lastReceipt) {
            $length = strlen($lastReceipt->OrderNumber);

            $prefix = Carbon::today()->format('my');
            $currentMonth = substr($lastReceipt->OrderNumber,$length-7,4);
            
            if($prefix==$currentMonth) {
                $current = substr($lastReceipt->OrderNumber, $length-3);
            }
            else {
                $current = 0;
            }
        }
        else {
            $current = 0;
        }
        // Step 3: Create PO
        foreach($data as $entry) {
            // entry = vendor.
            $current++;

            DB::transaction(function () use ($request, $entry, $current) {
                foreach($entry as $item) {
                    $supplier = new Supplier();
                    $supplier = $supplier->where('ID','=',$item['Supplier'])->first();
//                    $category = $supplier->Category=='L'?"LO":"FO";


                    $today = Carbon::today();
                    $po = new PurchaseOrder();
                    $po->OrderNumber = sprintf("%s%s",
//                    $category,
//                    $supplier->SupplierType==1?"PH":"US",
                        $today->format('my'),
                        str_pad($current,3,'0',STR_PAD_LEFT)
                    );
                    $po->ChargeNo = $item['OrderNumber'];
                    $po->ChargeType = 'S';
                    $po->Series = self::$series;
                    $po->Supplier = $supplier->ID;
                    $po->OrderDate = $today;
                    $po->DeliveryDate = $today->addDays($supplier->SupplierType==1?14:90);
                    $po->PaymentTerm = 0;
                    $po->Total = 0;
                    $po->APAccount = 0;
                    $po->Status = 'D'; // draft

                    $remarks = array();
                    $remark = array('userid'=>auth()->user()->ID, 'message'=>"Draft Created.", 'time'=>Carbon::now()->toDateTimeString());
                    array_push($remarks, $remark);
                    $po->Remarks = json_encode(['data'=>$remarks]);

                    $po->save();
                    usleep( 1000 );

                    self::$series++;

                    for ($i = 0; $i < $item['Counter']; $i++) {
                        $orderItem = new OrderItem();
                        $orderItem = $orderItem->where('ID','=',$item[$i]['OrderItem'])->firstOrFail();
                        $orderItem->PurchaseOrder = $po->ID;
                        //$orderItem->Requisition = $item[$i]['Requisition'];
                        //$orderItem->LineItem = $item[$i]['LineItem'];
                        //$orderItem->Quote = $item[$i]['Quote'];
                        $orderItem->save();

                        echo "<pre>".$orderItem."</pre><br/>";

                        $lineItem = new LineItem();
                        $lineItem = $lineItem->where('ID','=',$item[$i]['LineItem'])->first();
                        $lineItem->Ordered = true; // ordered
                        $lineItem->save();

                        $quote = new Quote();
                        $quote = $quote->where('ID','=',$item[$i]['Quote'])->first();
                        $po->Total += ($quote->Amount * $lineItem->Quantity);
                    }

                    $po->save();


                    $log = new StatusLog();
                    $log->OrderNumber = $po->OrderNumber;
                    $log->TransactionType = 'PO';
                    $log->LogType = 'D';
                    $log->save();

                    // ** Step 4: Send Mail **
                    /*
                     * 1. Send mail to Creator
                     * 2. Send mail to PurchasingManager
                     * 3. Send mail to OM
                     * 4. Send mail to PM
                     * 5. Send mail to GM
                     *
                     */

                }



            });
        }
        return redirect()->to('/purchase-order');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PurchaseOrder  $purchaseOrder
     * @return \Illuminate\Http\Response
     */
    public function show($purchaseOrder)
    {
        $po = PurchaseOrder::where('OrderNumber','=',$purchaseOrder)->first();
        return view('purchasing.purchase-orders.view', ['data'=>$po]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PurchaseOrder  $purchaseOrder
     * @return \Illuminate\Http\Response
     */
    public function edit(PurchaseOrder $purchaseOrder)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PurchaseOrder  $purchaseOrder
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $purchaseOrder) {
        try{
            $po = new PurchaseOrder();
            $po = $po->where('OrderNumber','=',$purchaseOrder)->first();

            if(isset($request->APAccount)) {
                $po->APAccount = $request->APAccount;
            }
            if(isset($request->Priority)) {
                $po->Priority = $request->Priority;
            }
            if(isset($request->PaymentTerm)) {
                $po->PaymentTerm = $request->PaymentTerm;
            }
            if(isset($request->ChargeType)) {
                $po->ChargeType = $request->ChargeType;
            }
            if(isset($request->ProductLine)) {
                $po->ProductLine = $request->ProductLine;
            }
            if(isset($request->Remarks)) {
                $remarks = json_decode($po->Remarks, true);
                $remark = array('userid'=>auth()->user()->ID, 'message'=>$request->Remarks, 'time'=>Carbon::now()->toDateTimeString());
                array_push($remarks['data'], $remark);
                $po->Remarks = json_encode($remarks);
            }
            $po->save();
            return response()->json(['success'=>1,'message'=>"Successfully updated Purchase Order Draft # $po->OrderNumber."]);
        }catch(\Exception $exception) {
            return response()->json(['success'=>0,'message'=>"Failed to update Purchase Order."]);
        }
    }


    /**
     * Submit the PurchaseOrder.
     *
     * @param Request $request
     * @param  \App\PurchaseOrder  $purchaseOrder
     *
     * @return \Illuminate\Http\Response
     */
    public function submit(Request $request, $purchaseOrder) {
        try{
            $today = Carbon::today();

            // Step 1. Load Purchase Order
            $po = new PurchaseOrder();
            $po = $po->where('OrderNumber','=',$purchaseOrder)->first();

            // Step 2. Do routine update.
            $po->APAccount = $request->APAccount;
//            $po->Priority = $request->Priority;
            $po->PaymentTerm = $request->PaymentTerm;
            $po->ChargeType = $request->ChargeType;
            $po->ProductLine = 9;

            if($po->ChargeType=='S') { // stock,restock, basta existing na to.
                $productLine = new ProductLine();
                $productLine = $productLine->where('Identifier','=','XX')->firstOrFail();
                $po->ProductLine = $productLine->ID;
            }
            else {

            }



            // Step 3. Update PO # to conform with completed data.

            $supplier = $po->Supplier();

            if($supplier->Classification=='F') {
                $category = "FO";
            } else {
                $category = "LO";
            }

            $currency = $po->Supplier()->Currency()->Code;
            $currency = substr($currency,0,2);


            $tempOrderNumber = $po->OrderNumber;

            // move logs
            $statusLog = new StatusLog();
            $logs = $statusLog->where('OrderNumber','=',$tempOrderNumber);



            $po->OrderNumber = sprintf("%s%s%s%s",
                $category,
                $currency,
                $po->ProductLine()->Identifier,
                $tempOrderNumber
            );



            // Step 4. Set Status to P. Pending Purchasing Manager's approval.
            $po->Status = 'P'; // pending purchasing manager's approval.
            $po->save();


            // Step 2. Send email to creator and to Purchasing Manager.
            session()->flash(1,['success'=>1,'message'=>"Successfully updated Purchase Order Draft # $po->OrderNumber."]);
            return redirect()->to("/purchase-order/view/$po->OrderNumber");
        }catch(\Exception $exception) {
            dd($exception);
            session()->flash(0,['success'=>0,'message'=>"Failed to update Purchase Order."]);
            return back()->withInput();
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PurchaseOrder  $purchaseOrder
     * @return \Illuminate\Http\Response
     */
    public function destroy(PurchaseOrder $purchaseOrder)
    {
        //
    }

    /**
     * Fetches all available data.
     *
     * @return Json
     */
    public function getPurchaseOrderData($status)
    {
        $data = array();
        $order = new  PurchaseOrder();
        if($status==='Z') {
            $orders = $order->all();
        }
        else {
            if($status=='P') {
                $orders = $order
                    ->where('Status','=','P')
                    ->orWhere('Status','=',1)
                    ->orWhere('Status','=',2)
                    ->orWhere('Status','=',3)
                    ->get();
            }
            else {
                $orders = $order->where('Status','=',$status)->get();
            }
        }
        foreach($orders as $order)
        {
            // dd($order->OrderItems()[0]->);
            $entry = array();
            $entry['OrderNumber'] = $order->OrderNumber;
            $entry['Supplier'] = $order->Supplier()->Name;
            $entry['OrderDate'] = $order->OrderDate->format('F d, Y');
//            $entry['DeliveryDate'] = $order->DeliveryDate->format('F d, Y');
            $entry['Total'] = ($order->Supplier()->SupplierType==1?'PHP':'USD').' '.number_format($order->Total,2,'.',',');
            $entry['Status'] = IssuanceHelper::ParsePurchaseOrderStatus($order->Status);
            array_push($data, $entry);
        }
        return response()->json(['aaData'=>$data]);
    }

    public function showItemsForQuotation() {
        return view('purchasing.purchase-orders.forquote');
    }

    public function getOrderItemData()
    {
        $data = array();

        $rs = new Requisition();

        $pr = $rs->where([
            ['Status', '!=', 'A'],
            ['Status', '!=', 'V'],
            ['Type', '=', 'PR']
        ])->get();

        foreach ($pr as $request) {
            $entry = array();

            $entry['ID'] = $request->ID;
            $entry['PRNumber'] = $request->OrderNumber;
            $entry['RequiredBy'] = $request->Date->format('F d, Y');
            foreach ($request->LineItems() as $lineItem) {
                if(!$lineItem->Ordered) {

                    $product = $lineItem->Product();
                    $validQuotes = count($product->ValidQuotes());

                    if($validQuotes < 5 && !$lineItem->Quoted) {
                        $entry['QuoteCount'] = $validQuotes;
                        $entry['Quantity'] = $lineItem->Quantity;
                        $entry['LineItemID'] = $lineItem->ID;
                        $entry['UniqueID'] = $product->UniqueID;
                        $entry['Product'] = sprintf('[%s] %s', $product->Name, $product->Description);

                        array_push($data, $entry);
                    }
                }
            }
        }

        return response()->json(['data'=>$data]);
    }

    public function getItemsForQuotationApproval() {
        $data = array();

        $rs = new Requisition();

        $pr = $rs->where([
//            ['Status', '=', '2'],
            ['Type', '=', 'PR']
        ])->get();


        foreach ($pr as $request) {
            $entry = array();

            $entry['ID'] = $request->ID;
            $entry['PRNumber'] = $request->OrderNumber;
            $entry['RequiredBy'] = $request->Date->format('F d, Y');
            foreach ($request->LineItems() as $lineItem) {
                if(!$lineItem->Ordered && !$lineItem->Quoted) {
                    $entry['Quantity'] = $lineItem->Quantity;
                    $entry['LineItemID'] = $lineItem->ID;
                    $entry['UniqueID'] = $lineItem->Product()->UniqueID;
                    $entry['Product'] = sprintf('[%s] %s', $lineItem->Product()->Name, $lineItem->Product()->Description);

                    if($preferredQuote = $lineItem->Product()->PreferredQuote()) {
                        $entry['Quote'] = sprintf('%s %s', $preferredQuote->Currency()->Code, number_format($preferredQuote->Amount,2,'.',','));
                        $entry['QuoteID'] = $preferredQuote->ID;
                        $entry['Currency'] = $preferredQuote->Currency()->Code;
                        $entry['TotalPrice'] = sprintf('%s %s', $preferredQuote->Currency()->Code, number_format($preferredQuote->Amount * $lineItem->Quantity,2,'.',','));
                        array_push($data, $entry);
                    }
                }
            }
        }

        return response()->json(['data'=>$data]);
    }


    public function getOrderItemsReadyForPO() {
        $data = array();
        $requisition = new Requisition();
        $lineItem = new LineItem();

        $orderItem = new OrderItem();
        $orderItems = $orderItem->where('PurchaseOrder','=',0)->get();
        foreach($orderItems as $orderItem) {
            if($orderItem->PurchaseOrder == 0) {
                $lineItem = $orderItem->LineItem();
                $product = $lineItem->Product();

                $pr = $requisition->where('OrderNumber','=',$lineItem->OrderNumber)->firstOrFail();
                if($pr->Status == 'A') {
                    $quote = $orderItem->SelectedQuote();

                    $entry = array();
                    $entry['ID'] = $pr->ID;
                    $entry['OrderItemID'] = $orderItem->ID;
                    $entry['PRNumber'] = $lineItem->OrderNumber;
                    $entry['RequiredBy'] = $pr->Date->format('F d, Y');
                    $entry['Quantity'] = $lineItem->Quantity;
                    $entry['LineItemID'] = $lineItem->ID;
                    $entry['UniqueID'] = $product->UniqueID;
                    $entry['Product'] = sprintf('[%s] %s', $product->Name, $product->Description);
                    $entry['Supplier'] = $quote->Supplier()->Name;
                    $entry['Quote'] = sprintf('%s %s', $quote->Currency()->Code, number_format($quote->Amount,2,'.',','));
                    $entry['QuoteID'] = $quote->ID;
                    $entry['Currency'] = $quote->Currency()->Code;
                    $entry['TotalPrice'] = sprintf('%s %s', $quote->Currency()->Code, number_format($quote->Amount * $lineItem->Quantity,2,'.',','));
                    array_push($data, $entry);
                }
            }
        }
        return response()->json(['data'=>$data]);
    }

    public function productquoteview($lineItem) {
        $lineItem = LineItem::where('ID','=',$lineItem)->first();
        return view('templates.orderitem-quote',['lineItem'=>$lineItem]);
    }

    public function toggle($po)
    {
        $po = PurchaseOrder::where('OrderNumber','=',$po)->first();
        $po->Status = $po->Status=='P'?'A':'P';
        $po->save();

        return redirect()->back();
    }

    public function approve(Request $request, $po) {
        $po = PurchaseOrder::where('OrderNumber','=',$po)->first();
        $user = auth()->user();
        if($user->isPurchasingManager()) {
            $po->Status = '1';
            $po->PurchasingManager = Carbon::today();

            $log = new StatusLog();
            $log->OrderNumber = $po->OrderNumber;
            $log->TransactionType = 'PO';
            $log->LogType = '1';
            $log->save();
        } 
        if($user->isOperationsDirector()) {
            $po->Status = '2';
            $po->OperationsManager = Carbon::today();

            $log = new StatusLog();
            $log->OrderNumber = $po->OrderNumber;
            $log->TransactionType = 'PO';
            $log->LogType = '2';
            $log->save();
        } 
        if($user->isPlantManager()) {
            $po->Status = '3';
            $po->PlantManager = Carbon::today();

            $log = new StatusLog();
            $log->OrderNumber = $po->OrderNumber;
            $log->TransactionType = 'PO';
            $log->LogType = '3';
            $log->save();
        } 
        if($user->isGeneralManager()) {
            $po->Status = 'A';
            $po->PurchasingManager = Carbon::today();
            $po->OperationsManager = Carbon::today();
            $po->PlantManager = Carbon::today();
            $po->GeneralManager = Carbon::today();

            $log = new StatusLog();
            $log->OrderNumber = $po->OrderNumber;
            $log->TransactionType = 'PO';
            $log->LogType = 'A';
            $log->save();
        }

        $remarks = json_decode($po->Remarks, true);
        $remark = array('userid'=>auth()->user()->ID, 'message'=>$request->Remarks, 'time'=>Carbon::now()->toDateTimeString());
        array_push($remarks['data'], $remark);
        $po->Remarks = json_encode($remarks);

        $po->save();

        // send mail.
        return redirect()->back();
    }


    public function reject(Request $request, $purchaseOrder) {
        $po = PurchaseOrder::where('OrderNumber','=',$purchaseOrder)->first();
        $po->Status = 'X';

        $remarks = json_decode($po->Remarks, true);
        $remark = array('userid'=>auth()->user()->ID, 'message'=>$request->Remarks, 'time'=>Carbon::now()->toDateTimeString());
        array_push($remarks['data'], $remark);
        $po->Remarks = json_encode($remarks);
        
        $po->save();

        $log = new StatusLog();
        $log->OrderNumber = $po->OrderNumber;
        $log->TransactionType = 'PO';
        $log->LogType = 'X';
        $log->save();


        //TODO: Send email

        return redirect()->back();
    }

    public function void($po)
    {
        $po = PurchaseOrder::where('OrderNumber','=',$po)->first();
        $po->Status = 'V';
        $po->save();

        return redirect()->back();
    }


    public function getSelectDataForRR(Request $request) {
        $po = new PurchaseOrder();

        $data = array();
        if($request->q) {
            $poForRR = $po
                ->where('Status','=','A')
                ->orWhere('OrderNumber','LIKE','%'.$request->q.'%')
                ->get(); // Approved lang pwede.
            for($i=0;$i<count($poForRR);$i++){
                $entry['id'] = $poForRR[$i]->ID;
                $entry['text'] = $poForRR[$i]->OrderNumber;
                array_push($data, $entry);
            }
        } else {
            $poForRR = $po->where('Status','=','A')->get(); // Approved lang pwede.
            for($i=0;$i<count($poForRR);$i++){
                $entry['id'] = $poForRR[$i]->ID;
                $entry['text'] = $poForRR[$i]->OrderNumber;
                array_push($data, $entry);
            }
        }
        return response()->json(['results'=>$data]);
    }

    public function getOrderItemsForRR($id) {
        $po = new OrderItem();
        $items = $po->where('PurchaseOrder','=',$id)->get();

        $data = array();
        if(count($items)>0) {
            foreach($items as $item) {
                $lineItem = $item->LineItem();
                $product = $lineItem->Product();

                $entry = array();
                $entry['ID'] = $item->ID;
                $entry['Description'] = $product->Description;
                $entry['Quantity'] = $lineItem->Quantity;
                $entry['UOM'] = $product->UOM()->Abbreviation;
                $entry['Receivable'] = $lineItem->getRemainingDeliverableQuantity();
                array_push($data, $entry);
            }
        } else {
        }

        return response()->json(['data'=>$data]);
    }

    public function generatePurchaseOrderForm($orderNumber) {
        $purchaseOrder = new PurchaseOrder();

        try{
            $po = $purchaseOrder->where('OrderNumber', '=',$orderNumber)->first();
            if($po) {
                $file = Storage::url('/app/template/po.xlsx');


//                $user = User::where('ID','=',$po->Requester)->first();
                $supplier = $po->Supplier();

                $address = array(
                    $supplier->AddressLine1,
                    $supplier->AddressLine2,
                    $supplier->City,
                    $supplier->State,
                    $supplier->Zip && $supplier->Country?$supplier->Zip." ".$supplier->Country:""
                );



                $dto = new DTO();
                $dto->Address = array_filter($address);

                $dto->VendorName = $supplier->Name;
                $dto->PurchaseOrderNumber = $po->OrderNumber;
                $dto->DateIssued = Carbon::today()->format('n/j/y');
                $dto->VendorID = $supplier->Code;
                $dto->DeliveryDate = $po->DeliveryDate->format('n/j/y');
                $dto->Terms = $po->PaymentTerm()->Description;
                $dto->Currency = $po->Supplier()->Currency()->Code;
                $dto->OrderItems = $po->OrderItems();

                $purchaseRequest = null;
                $counter = 21;
                $total = 0;
                foreach($po->OrderItems() as $orderItem) {
                    $lineItem = $orderItem->LineItem();
                    $purchaseRequest = $orderItem->Requisition();
//                    $data["A$counter"] = $lineItem->Quantity;
//                    $data["B$counter"] = $lineItem->Product()->UOM()->Abbreviation;
//                    $data["C$counter"] = $lineItem->Product()->Description;
//                    $data["J$counter"] = $orderItem->SelectedQuote()->Amount;
//                    $data["M$counter"] = $orderItem->SelectedQuote()->Amount * $lineItem->Quantity;
                    $total += $orderItem->SelectedQuote()->Amount * $lineItem->Quantity;

                    $counter++;
                }
//
//                $data["C$counter"] = "X X X NOTHING FOLLOWS X X X";
                $dto->Total = $total;


                $dto->ChargeType = $po->ChargeType=='S'?"STOCKS":substr($purchaseRequest->ChargedTo()->Name, 0, 3);
                $dto->ChargeNo = sprintf("%s/%s",$purchaseRequest->OrderNumber,$dto->ChargeType);
//                $data['D18'] = $chargeNo;

                $dto->PurchasingManager = Role::findUserWithRole('PurchasingManager')->Person()->AbbreviatedName();
                $dto->OperationsManager = Role::findUserWithRole('OperationsDirector')->Person()->AbbreviatedName();
                $dto->PlantManager = Role::findUserWithRole('PlantManager')->Person()->AbbreviatedName();
                $dto->GeneralManager = Role::findUserWithRole('GeneralManager')->Person()->AbbreviatedName();

                return view('report.templates.purchaseorder',['data'=>$dto]);


            } else {
                $data = new DTO();
                $data->Title = "Purchase Order $orderNumber";
                $data->Class = "Purchase Order";
                $data->Description = "We cannot not find the $data->Class in the database.";
                return response()
                    ->view('errors.404',['data'=>$data]
                        ,404);
            }
        } catch(\Exception $exc) {
            dd($exc);
        }
    }

    // android 
    public function androidGetPO($supplier) {
        $po = PurchaseOrder::where('Supplier','=',$supplier)->first();
        
        $data = array();
        if($po){
            $data['OrderNumber'] = $po->OrderNumber;
        }
        
        return response()->json($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PurchaseOrder  $purchaseOrder
     * @return \Illuminate\Http\Response
     */
    public function getPurchaseOrderDataByOrderNumber($purchaseOrder)
    {
        $po = PurchaseOrder::where('OrderNumber','=',$purchaseOrder)->first();
        return view('purchasing.receive-orders.receive.content',['data'=>$po]);
    }

}
