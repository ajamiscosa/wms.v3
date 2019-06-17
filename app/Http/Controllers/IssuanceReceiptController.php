<?php

namespace App\Http\Controllers;

use App\Department;
use App\IssuanceReceipt;
use App\LineItem;
use App\Requisition;
use App\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\InventoryLog;
use App\Product;

class IssuanceReceiptController extends Controller
{
    private $requisition;
    private $lineItem;
    private $user;
    private $department;
    private $product;

    function __construct() {
        $this->middleware('auth');
        $this->requisition = new Requisition();
        $this->lineItem = new LineItem();
        $this->user = new User();
        $this->department = new Department();
        $this->product = new Product();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return view('rs.issuance.out');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('rs.issuance.issuance');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $lastReceipt = IssuanceReceipt::orderByDesc('ID')->first();
        $length = strlen($lastReceipt->OrderNumber);

        $prefix = Carbon::today()->format('ym');
        $currentMonth = substr($lastReceipt->OrderNumber,2,4);
        if($prefix==$currentMonth) {
            $current = substr($lastReceipt->OrderNumber, $length-3);
            $current++;
        }
        else {
            $current = 0;
            $current++;
        }

        for($i=0;$i<count($request->LineItem); $i++) {
            if($request->Quantity[$i]>0) {
                $lineItem = $this->lineItem->where('ID','=',$request->LineItem[$i])->firstOrFail();

                $issuanceReceipt = new IssuanceReceipt();
                $issuanceReceipt->LineItem = $lineItem->ID;
                $issuanceReceipt->Quantity = $request->Quantity[$i];
                $issuanceReceipt->Received = Carbon::now();

                try {
                    $latest = $issuanceReceipt->where('LineItem','=',$lineItem->ID)->orderBy('Received', 'desc')->firstOrFail();
                    $issuanceReceipt->Series = $latest->Series + 1;
                } catch(\Exception $exception) {
                    $issuanceReceipt->Series = 1;
                }

                $remarks = array();
                $remark = array(
                    'receiver'=>$request->Receiver, 
                    'message'=>$request->Remarks
                );
                array_push($remarks, $remark);

                $issuanceReceipt->Remarks = json_encode(['data'=>$remarks]);

                // try {
                //     $latest = $issuanceReceipt->where('LineItem','=',$lineItem->ID)->orderBy('Received', 'desc')->firstOrFail();
                //     $issuanceReceipt->Series = $latest->Series + 1;
                // } catch(\Exception $exception) {
                //     $issuanceReceipt->Series = 1;
                // }

                
                $isNumber = sprintf("IS%s%s",
                    Carbon::today()->format('ym'),
                    str_pad($current,3,'0',STR_PAD_LEFT)
                );
                
                $issuanceReceipt->OrderNumber = $isNumber;
                $issuanceReceipt->save();


                $product = $this->product->where('ID','=',$lineItem->Product)->firstOrFail();

                $inventoryLog = new InventoryLog();
                $inventoryLog->Product = $lineItem->Product;
                $inventoryLog->Type = 'O'; // item out ito.
                $inventoryLog->TransactionType = 'IR'; // Issuance Receipt
                $inventoryLog->Quantity = $request->Quantity[$i] * -1;
                $inventoryLog->Initial = $product->Quantity;
                $inventoryLog->Final = $product->Quantity - $request->Quantity[$i];
                $inventoryLog->save();

                $product->Quantity = $product->Quantity - $request->Quantity[$i];
                $product->save();
            }
        }

        return redirect()->back()->with('message','Success!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\IssuanceReceipt  $issuanceReceipt
     * @return \Illuminate\Http\Response
     */
    public function show(IssuanceReceipt $issuanceReceipt)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\IssuanceReceipt  $issuanceReceipt
     * @return \Illuminate\Http\Response
     */
    public function edit(IssuanceReceipt $issuanceReceipt)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\IssuanceReceipt  $issuanceReceipt
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, IssuanceReceipt $issuanceReceipt)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\IssuanceReceipt  $issuanceReceipt
     * @return \Illuminate\Http\Response
     */
    public function destroy(IssuanceReceipt $issuanceReceipt)
    {
        //
    }

    public function getReceiptTransactionsOfIssuance($id) {
        $data = array();
        
        try{
            $issuance = $this->requisition->where('OrderNumber','=',$id)->firstOrFail();
            if($issuance) {
                for($i=0; $i<count($issuance->LineItems()); $i++) {
                    $lineItem = $issuance->LineItems()[$i];
                    $product = $lineItem->Product();
                    $entry = array();
                    $entry['Item'] = sprintf("[%s] %s %s", $product->UniqueID, $product->Name, $product->Description);
                    $entry['UniqueID'] = $product->UniqueID;
                    foreach($lineItem->getIssuanceReceipts() as $issuanceReceipt) {
                        $entry['Quantity'] = sprintf("%s %s",$issuanceReceipt->Quantity, $product->UOM()->Abbreviation);
                        $remarks = json_decode($issuanceReceipt->Remarks, true);
                        $entry['Receiver'] = $remarks['data'][0]['receiver'];
                        $entry['Message'] = $remarks['data'][0]['message'];
                        $entry['Received'] = Carbon::parse($issuanceReceipt->Received)->toDateTimeString();
                        $entry['TimeStamp'] = Carbon::parse($issuanceReceipt->Received)->timestamp;
                        array_push($data, $entry);
                    }
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

    public function getRequestDataForIssuance($id) {
        $data = array();

        try{
            $issuance = $this->requisition->where('ID','=',$id)->first();
            if($issuance) {
                $data = $issuance;
                $data['LineItems'] = $issuance->LineItems();
                for($i=0; $i<count($issuance->LineItems()); $i++) {
                    $lineItem = $issuance->LineItems()[$i];
                    $data['LineItems'][$i]['GLCode'] = sprintf('[%s] %s', $lineItem->GeneralLedger()->Code, $lineItem->GeneralLedger()->Description);
                    $data['LineItems'][$i]['UOM'] = $lineItem->Product()->UOM()->Abbreviation;
                    $data['LineItems'][$i]['Description'] = $lineItem->Product()->Description;
                    $data['LineItems'][$i]['UniqueID'] = $lineItem->Product()->UniqueID;
                }
                $data['Department'] = $issuance->Department();
                $data['ChargedTo'] = $issuance->ChargedTo();
                $data['Requester'] = $issuance->Requester();
                $data['Requester']['Name'] = $data['Requester']->Name();
                $data['Approver1'] = $issuance->Approver1()->Name();
                $data['DateApproved'] = $issuance->ApprovalLog()->created_at->toDateTimeString();
            }

            return response()->json($data);
        } catch(\Exception $exc){
            dd($exc);
        }
    }

    public function getRequestsReadyForIssuance() {
        $data = array();

        try{
            $issuances = $this->requisition->where([
                ['Type','=','IR'],
                ['Status','=','A']
            ]);
            $issuances = $issuances->get();
    
            foreach($issuances as $issuance) {
                $receivable = 0;
                foreach($issuance->LineItems() as $lineItem) {
                    $receivable += $lineItem->getRemainingReceivableQuantity();
                }

                if($receivable > 0) {
                    $requester = $this->user->where('ID','=',$issuance->Requester)->firstOrFail();
                    $entry = array();
                    $entry['ID'] = $issuance->ID;
                    $entry['OrderNumber'] = $issuance->OrderNumber;
                    $entry['Date'] = $issuance->Date->format('F d, Y');
                    $entry['Requester'] = $requester->Person()->Name();
                    $entry['ChargeTo'] = $this->department->where('ID','=',$issuance->ChargeTo)->first()->Name;
                    $entry['Status'] = $issuance->Status();
                    array_push($data, $entry);
                }
            }
            return response()->json(['aaData'=>$data]);
        } catch(\Exception $exc){

        }
    }
}
