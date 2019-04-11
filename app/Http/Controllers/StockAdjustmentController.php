<?php

namespace App\Http\Controllers;

use App\Form;
use App\InventoryLog;
use App\LineItem;
use App\Location;
use App\Product;
use App\ProductLine;
use App\Stock;
use App\StockAdjustment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockAdjustmentController extends Controller
{
    private $stockAdjustment;
    private $product;
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    function __construct()
    {
        $this->middleware('auth');
        $this->stockAdjustment = new StockAdjustment();
        $this->product = new Product();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('inventory.stock-adjustments.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('inventory.stock-adjustments.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $sa = new StockAdjustment();
        $sa->Number = $this->getCurrentIncrement();
        $sa->Product = $request->Product;
        $sa->Initial = round($request->Initial,2);
        $sa->Final = $request->Final;
        $sa->Reason = $request->Reason;

        $remarks = array();
        $remark = array('userid'=>auth()->user()->ID, 'message'=>$request->Reason, 'time'=>Carbon::now()->toDateTimeString());
        array_push($remarks, $remark);

        $sa->Remarks = json_encode(['data'=>$remarks]);
        $sa->Status = 'P'; // default is pending
        $sa->save();

        return redirect()->to('/stock-adjustment/view/'.$sa->Number);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\StockAdjustment  $id
     * @return \Illuminate\Http\Response
     */
    public function show($sa)
    {
        $sa = $this->stockAdjustment->where('Number','=',$sa)->first();
        return view('inventory.stock-adjustments.view', ['data'=>$sa]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\StockAdjustment  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\StockAdjustment  $number
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $number)
    {
        $user = auth()->user();

        $sa = $this->stockAdjustment->where('Number','=',$number);
        $sa->Product = $request->Product;
        $sa->Initial = round($request->Initial,2);
        $sa->Final = $request->Final;
        $sa->Reason = $request->Reason;

        $remarks = json_decode($sa->Remarks, true);
        $remark = array('userid'=>$user->ID, 'message'=>$request->Remarks, 'time'=>Carbon::now()->toDateTimeString());

        array_push($remarks['data'], $remark);

        $sa->Remarks = json_encode($remarks);
        $sa->Status = 'P'; // default is pending
        $sa->save();

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\StockAdjustment  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    /**
     * Fetches all available data.
     *
     * @return Json
     */
    public function data()
    {
        $adjustments = StockAdjustment::all();
        $data = array();
        foreach ($adjustments as $adjustment)
        {
            $entry = array();
            $entry['Number'] = $adjustment->Number;
            $entry['Product'] = sprintf('[%s] %s',$adjustment->Product()->UniqueID, $adjustment->Product()->Description);
            $entry['Date'] = $adjustment->created_at->format('F d, Y');
            $entry['Initial'] = $adjustment->Initial." ".$adjustment->Product()->UOM()->Abbreviation;
            $entry['Final'] = $adjustment->Final." ".$adjustment->Product()->UOM()->Abbreviation;
            $entry['Status'] = $adjustment->Status;
            array_push($data, $entry);
        }


        return response()->json(['aaData'=>$data]);
    }

    public function getProductList(Request $request) {
        $data = array();
        $product = new Product();

        if($request->q) {
            $products = $product->where(function($query) use ($request){
                $query->where('UniqueID','like','%'.$request->q.'%')
                    ->orWhere('Description','like','%'.$request->q.'%');
            })->get();

            for($i=0;$i<count($products);$i++){
                $entry['id'] = $products[$i]->ID;
                $entry['text'] = '['.$products[$i]->UniqueID.'] '.$products[$i]->Description;
                array_push($data, $entry);
            }
        } else {
            $products = Product::all();
            for($i=0;$i<count($products);$i++){
                $entry['id'] = $products[$i]->ID;
                $entry['text'] = '['.$products[$i]->UniqueID.'] '.$products[$i]->Description;
                array_push($data, $entry);
            }
        }
        return response()->json(['results'=>$data]);
    }

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

    public function void($id) {
        $sa = $this->stockAdjustment->where('Number','=',$id)->first();
        $sa->Status = 'V';
        $sa->save();
        return redirect()->to('/stock-adjustment/view/'.$id);
    }

    public function approve($id) {
        $sa = $this->stockAdjustment->where('Number','=',$id)->first();
        $sa->Status = 'A';
        $sa->save();

        $product = $this->product->where('ID','=',$sa->Product)->first();
        $product->Quantity = $sa->Final;
        $product->save();

        $inventoryLog = new InventoryLog();
        $inventoryLog->TransactionType = 'SA'; // Stock Adjustment
        $inventoryLog->Type = 'R'; //
        $inventoryLog->Product = $sa->Product;
        $inventoryLog->Initial = $sa->Initial;
        $inventoryLog->Final = $sa->Final;
        $inventoryLog->Quantity = $inventoryLog->Final - $inventoryLog->Initial;
        $inventoryLog->save();
        //
        return redirect()->to('/stock-adjustment/view/'.$id);
    }
}
