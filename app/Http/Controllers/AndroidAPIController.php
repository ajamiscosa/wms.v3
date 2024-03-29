<?php

namespace App\Http\Controllers;

use App\Person;
use App\PhonebookEntry;
use App\User;
use App\Product;
use App\LineItem;
use App\Requisition;
use App\OrderItem;
use App\Supplier;
use App\PurchaseOrder;
use App\StockAdjustment;
use App\ReceiveOrder;
use App\InventoryLog;
use App\Department;
use App\GeneralLedger;
use App\IssuanceReceipt;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Psy\Util\Json;

class AndroidAPIController extends Controller
{
    private $stockAdjustment;
    private $lineItem;
    private $product;
    function __construct()
    {
        $this->stockAdjustment = new StockAdjustment();
        $this->lineItem = new LineItem();
        $this->product = new Product();
    }
    // android login
    public function androidlogin(Request $request) {
        $credentials = $request->only('Username', 'Password');
        
        $user = $credentials['Username'];
        $pass = $credentials['Password'];

        $account = User::where('Username','=',$user)->first();
        $status = "";
        $message = "";
        if($account) {
            if($account->Password == $pass) {
                Auth::login($account);
                $status = "success";
                $message = "ok";
            }
            else {
                $status = "failed";
                $message = "Incorrect Password";
            }
        }
        else {
            $status = "failed";
            $message = "Account doesn't exist.";
        }
        return response()->json(['status'=>$status, 'message'=>$message, 'data'=>$account]);
    }

    public function androidGetPersonData($id) {
        $person = Person::where('ID','=',$id)->first();

        $data = array();
        if($person){
            $data['FirstName'] = $person->FirstName;
            $data['LastName'] = $person->LastName;
            $data['Position'] = $person->Position;
        }

        return response()->json($data);
    }
    // end android login

    // inventory
    public function androidGetProduct($product) {
        $product = Product::where('UniqueID','=',$product)->first();

        $data = array();
        if($product){
            $data['UOM'] = $product->UOM()->Abbreviation;
            $data['Quantity'] = $product->Quantity;
            $data['Description'] = $product->Description;
        }

        return response()->json($data);
    }
    // end inventory

    public function androidGetPO($supplier) {
        $po = PurchaseOrder::where('Supplier','=',$supplier)->first();
        
        $data = array();
        if($po){
            $data['OrderNumber'] = $po->OrderNumber;
        }
        
        return response()->json($data);
    }

    // Receiving 
    public function androidGetPendingPO($supplier) {
        $vID = $this->getSupplierIDByCode($supplier);
        $purchase = PurchaseOrder::where('Supplier','=',$vID)->get();
        $data = array();
        foreach($purchase as $po){
            if($po->Status == "A" && $po->getRemainingDeliverableQuantity()>0){
                $p = new PurchaseOrder();
                $p->OrderNumber = $po->OrderNumber;
                array_push($data,$p);
            }
        }
        return response()->json($data);
    }

    public function androidGetPODataByOrderNumber($purchaseOrder)
    {
        $totalRemaining = 0;
        $po = PurchaseOrder::where('OrderNumber','=',$purchaseOrder)->first();
        foreach($po->OrderItems() as $item){
            $lineItem = $item->LineItem();
            $product = $lineItem->Product();
            $totalRemaining+=$lineItem->getRemainingDeliverableQuantity();
        }
        dd($product->UniqueID);
        //return view('purchasing.receive-orders.receive.content',['data'=>$po]);
    }

    public function androidGetProductIDByOrderNumber($purchaseOrder)
    {
        $data = array();
        $po = PurchaseOrder::where('OrderNumber','=',$purchaseOrder)->first();
        foreach($po->OrderItems() as $item){
            $prod = new Product();
            $lineItem = $item->LineItem();
            $product = $lineItem->Product();

            $prod->UniqueID = $product->UniqueID;
            array_push($data,$prod);
        }
        return response()->json($data);
    }

    public function androidGetItemDataByOrderNumber($purchaseOrder)
    {
        $purchaseOrder = explode("&", $purchaseOrder);
        $totalRemaining = 0;
        $data = array();
        $po = PurchaseOrder::where('OrderNumber','=',$purchaseOrder[0])->first();
        foreach($po->OrderItems() as $item){
            $prod = new Product();
            $lineItem = $item->LineItem();
            $product = $lineItem->Product();
            $totalRemaining+=$lineItem->getRemainingDeliverableQuantity();
            if($product->UniqueID == $purchaseOrder[1]){
                $prod->UniqueID = $product->UniqueID;
                $prod->Description = $product->Description;
                $prod->Quantity = $totalRemaining;
                $prod->OrderItem = $item->ID;
                array_push($data,$prod);
            }
        }
        return response()->json($data);
    }

    public function androidReceivingStore($id)//poNumber&orderItem&invoiceDR&_qty
    {
        try{
            $ex = explode("&",$id);
            $orderItem = new OrderItem();
            $po = new PurchaseOrder();
            $po = $po->where('OrderNumber','=',$ex[0])->firstOrFail(); //poNumber

            $rrNumber = "";

            $lastReceipt = ReceiveOrder::orderByDesc('ID')->first();
            if($lastReceipt) {
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
            }
            else {
                $current = 0;
                $current++;
            }

            if($ex[3]>0) {
                $ro = new ReceiveOrder();
                $ro->PurchaseOrder = $po->ID;
                $orderItem = $orderItem->where('ID','=',$ex[1])->firstOrFail();//orderItem
                $lineItem = $orderItem->LineItem();

                $ro->OrderItem  = $orderItem->ID;
                $ro->Received = Carbon::now();
                $ro->ReferenceNumber = $ex[2];//invoiceDR

                try {
                    $latest = $ro->where('PurchaseOrder','=',$orderItem->PurchaseOrder)->orderBy('Received', 'desc')->firstOrFail();
                    $ro->Series = $latest->Series + 1;
                } catch(\Exception $exception) {
                    $ro->Series = 1;
                }

                $ro->Quantity = $ex[3];//_qty


                $rrNumber = sprintf("RR%s%s%s",
                    substr($po->OrderNumber,2,4),
                    Carbon::today()->format('ym'),
                    str_pad($current,3,'0',STR_PAD_LEFT)
                );
                
                $ro->OrderNumber = $rrNumber;

                $remarks = array();
                $remark = array(
                    'receiver'=>"Mobile",//none
                    'message'=>"From Mobile"//none
                );
                array_push($remarks, $remark);

                $ro->Remarks = json_encode(['data'=>$remarks]);
                $ro->save();

                $product = $lineItem->Product();

                $inventoryLog = new InventoryLog();
                $inventoryLog->Product = $lineItem->Product;
                $inventoryLog->Type = 'I'; // item out ito.
                $inventoryLog->TransactionType = 'RR'; // Receiving Receipt
                $inventoryLog->Quantity = $ex[3];//_qty
                $inventoryLog->Initial = $product->Quantity;
                $inventoryLog->Final = $product->Quantity + $ex[3];//_qty
                $inventoryLog->save();

                $product->Quantity = $product->Quantity + $ex[3];//_qty
                $product->save();
            }

            return response()->json(['result'=>"success"]);
            
        }catch(\Exception $e) {
            return response()->json(['result'=>$e]);
        }
    }
    // end receiving

    // issuance
    public function androidGetDepartment(){
        $data = array();
        $departments = Department::all();
        for($i=0;$i<count($departments);$i++){
            $department = new Department();
            $department->ID = $departments[$i]->ID;
            $department->Name = $departments[$i]->Name;

            array_push($data, $department);
        }
        return response()->json($data);
    }

    public function androidGetIRByDepartment($id){
        $data = array();
        $requition = new Requisition();
        foreach($requition->IssuanceRequests() as $ir){
            if($ir->Status == 'A' && $ir->getRemainingIssuableQuantity()>0 && $ir->ChargeTo == $id){
                $req = new Requisition();
                $req->OrderNumber = $ir->OrderNumber;
                array_push($data,$req);
            }
        }
        return response()->json($data);
    }

    public function androidGetIRItems($id){
        $data = array();
        $requition = new Requisition();
        foreach($requition->IssuanceRequests() as $ir){
            if($ir->Status == 'A' && $ir->getRemainingIssuableQuantity()>0 && $ir->OrderNumber == $id){
                $req = new Requisition();
                //dd($ir->LineItems());   
                foreach($ir->LineItems() as $item){
                    $product = new Product();
                    $product->LineItemID = $item->ID;
                    $product->UniqueID = $item->Product()->UniqueID;
                    $product->Description = $item->Product()->Description;
                    $product->GLAccount = '['.$item->GeneralLedger()->Code.']'.$item->GeneralLedger()->Description;  
                    $product->Qty = $item->getRemainingReceivableQuantity();
                    array_push($data,$product);
                }

                
            }
        }
        return response()->json($data);
    }

    public function androidIssuanceStore($id)//_id&_qty&_user
    {
        try{
            $ex = explode("&",$id);
            $lastReceipt = IssuanceReceipt::orderByDesc('ID')->first();
            if($lastReceipt) {
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
            }
            else {
                $current = 0;
                $current++;
            }

            if($ex[1] > 0) {//_qty
                $lineItem = $this->lineItem->where('ID','=',$ex[0])->firstOrFail();//id

                $issuanceReceipt = new IssuanceReceipt();
                $issuanceReceipt->LineItem = $lineItem->ID;
                $issuanceReceipt->Quantity = $ex[1];//_qty
                $issuanceReceipt->Received = Carbon::now();

                try {
                    $latest = $issuanceReceipt->where('LineItem','=',$lineItem->ID)->orderBy('Received', 'desc')->firstOrFail();
                    $issuanceReceipt->Series = $latest->Series + 1;
                } catch(\Exception $exception) {
                    $issuanceReceipt->Series = 1;
                }

                $remarks = array();
                $remark = array(
                    'receiver'=>"Mobile",//none
                    'message'=>"From Mobile"//none
                );
                array_push($remarks, $remark);

                $issuanceReceipt->Remarks = json_encode(['data'=>$remarks]);

                $isNumber = sprintf("IS%s%s",
                    Carbon::today()->format('ym'),
                    str_pad($current,3,'0',STR_PAD_LEFT)
                );

                $issuanceReceipt->OrderNumber = $isNumber;
                if($issuanceReceipt->save()){
                    $issuanceReceipt->created_by = $ex[2];
                    $issuanceReceipt->created_at = Carbon::now();
                    $issuanceReceipt->updated_by = $ex[2];
                    $issuanceReceipt->updated_at = Carbon::now();
                    $issuanceReceipt->save();
                }else{
                    return response()->json(['result'=>"fail issuanceReceipt"]);
                }

                $product = $this->product->where('ID','=',$lineItem->Product)->firstOrFail();

                $inventoryLog = new InventoryLog();
                $inventoryLog->Product = $lineItem->Product;
                $inventoryLog->Type = 'O'; // item out ito.
                $inventoryLog->TransactionType = 'IR'; // Issuance Receipt
                $inventoryLog->Quantity = $ex[1] * -1;//_qty
                $inventoryLog->Initial = $product->Quantity;
                $inventoryLog->Final = $product->Quantity - $ex[1];//_qty

                if($inventoryLog->save()){
                    $inventoryLog->created_by = $ex[2];
                    $inventoryLog->created_at = Carbon::now();
                    $inventoryLog->updated_by = $ex[2];
                    $inventoryLog->updated_at = Carbon::now();
                    $inventoryLog->save();
                }else{
                    return response()->json(['result'=>"fail inventoryLog"]);
                }

                $product->Quantity = $product->Quantity - $ex[1];//_qty

                if($product->save()){
                    $product->created_by = $ex[2];
                    $product->created_at = Carbon::now();
                    $product->updated_by = $ex[2];
                    $product->updated_at = Carbon::now();
                    $product->save();
                }else{
                    return response()->json(['result'=>"fail product"]);
                }
            }

            return response()->json(['result'=>"success"]);
        }catch(\Exception $e) {
            dd($e);
            // return response()->json(['result'=> "Exception". $e]);
        }
        
    }

    public function androidGetIRDetails($id){
        $data = array();
        $requition = new Requisition();
        foreach($requition->IssuanceRequests() as $ir){
            if($ir->Status == 'A' && $ir->getRemainingIssuableQuantity()>0 && $ir->OrderNumber == $id){
                $req = new Requisition();
                $genLedger = new GeneralLedger();
                $gl = $genLedger->where('ID','=',$ir->GLAccount)->first();
                $req->GLAccount = '['.$gl->Code.']'.$gl->Description; 

                foreach($ir->LineItems() as $item){
                    //look for issuance.issuance.details
                }

                array_push($data,$req);
            }
        }
        return response()->json($data);
    }
    // end issuance

    // stockadjustment
    public function androidStockAdjustmentStore($adjustment) {
        try{
            $ex = explode("&",$adjustment);
            $sa = new StockAdjustment();
            $sa->Number = $this->getCurrentIncrement();
            $sa->Product = $this->getProductIDByCode($ex[0]);
            $sa->Final = $ex[1];
            
            $remarks = array();
            $remark = array('userid'=>$ex[2], 'message'=>'Inventory Mobile', 'time'=>Carbon::now()->toDateTimeString());
            array_push($remarks, $remark);
            $id = $ex[2];
            $sa->Remarks = json_encode(['data'=>$remarks]);
            $sa->Status = 'P'; // default is pending
            // return response()->json(['result'=>$sa]);
            // dd($sa);
            // $sa->save();
            if($sa->save()){
                // $sa->created_by = $id;
                // $sa->save();
                if($sa->save()){
                    $sa->created_by = $id;
                    $sa->created_at = Carbon::now();
                    $sa->updated_by = $id;
                    $sa->updated_at = Carbon::now();
                    $sa->save();
                    return response()->json(['result'=>"success"]);
                }else{
                    return response()->json(['result'=>"fail"]);
                }
            }
        }catch(Exception $e){
            return response()->json(['result'=>"Exception: " +$e]);
        }
        // return response()->json(['result'=>"success"]);
    }
    // end of stockadjustment

    // functions
    public function getCurrentIncrement()
    {
        $i = 0;
        $current = $this->stockAdjustment->orderByDesc('Number')->first();
        if($current) {
            $i = substr($current->Number,2);
            $i++;
        } else {
            $i++;
        }
        return sprintf('SA%s',str_pad($i,7,'0',STR_PAD_LEFT));
    }

    public function getProductIDByCode($code)
    {
        $product = Product::where('UniqueID','=',$code)->first();
        if($product) {
            return $product->ID;
        }
        return "";
    }

    public function getSupplierIDByCode($code)
    {
        $supplier = Supplier::where('Code','=',$code)->first();
        if($supplier) {
            return $supplier->ID;
        }
        return "";
    }

    public function androidGetSupplier($supplier) {
        $supplier = Supplier::where('Code','=',$supplier)->first();
        $data = array();
        if($supplier){
            $data['Name'] = $supplier->Name;
        }

        return response()->json($data);
    }

    public function checkDRInvoice($id){
        try {
            ReceiveOrder::where('ReferenceNumber','=',$id)->firstOrFail();
        } catch(\Exception $e) {
            return response()->json(['result'=>"false"]);
        }
        return response()->json(['result'=>"true"]);
    }
    // end of functions
}