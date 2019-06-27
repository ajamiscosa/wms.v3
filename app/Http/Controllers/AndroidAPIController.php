<?php

namespace App\Http\Controllers;

use App\Person;
use App\PhonebookEntry;
use App\User;
use App\Product;
use App\Supplier;
use App\PurchaseOrder;
use App\StockAdjustment;
use Carbon\Carbon;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Psy\Util\Json;

class AndroidAPIController extends Controller
{
    private $stockAdjustment;
    function __construct()
    {
        $this->stockAdjustment = new StockAdjustment();
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

        return response()->json(['status'=>$status, 'message'=>$message]);
    }
    //end android login
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

    public function androidGetSupplier($supplier) {
        $supplier = Supplier::where('ID','=',$supplier)->first();

        $data = array();
        if($supplier){
            $data['Name'] = $supplier->Name;
            //$data['Description'] = $supplier->Description;
        }

        return response()->json($data);
    }

    public function androidGetPO($supplier) {
        $po = PurchaseOrder::where('Supplier','=',$supplier)->first();
        
        $data = array();
        if($po){
            $data['OrderNumber'] = $po->OrderNumber;
        }
        
        return response()->json($data);
    }

    // stockadjustment
    public function stockAdjustmentStore($adjustment) {
        try{
            $ex = explode("&",$adjustment);
            $sa = new StockAdjustment();
            $sa->Number = $this->getCurrentIncrement();
            $sa->Product = $this->getProductIDByCode($ex[0]);
            $sa->Final = $ex[1];
    
            $remarks = array();
            $remark = array('userid'=>auth()->user()->ID, 'message'=>'Inventory Mobile', 'time'=>Carbon::now()->toDateTimeString());
            array_push($remarks, $remark);
    
            $sa->Remarks = json_encode(['data'=>$remarks]);
            $sa->Status = 'P'; // default is pending
            // $sa->save();
            if($sa->save()){
                return response()->json(['result'=>"success"]);
            }else{
                return response()->json(['result'=>"fail"]);
            }
        }catch(\Exception $e) {
            return response()->json(false);
        }
        // return response()->json(['result'=>"success"]);
    }
    //end of stockadjustment

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
    // end of functions
}