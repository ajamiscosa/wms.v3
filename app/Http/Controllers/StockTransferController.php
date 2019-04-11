<?php

namespace App\Http\Controllers;

use App\Location;
use App\Product;
use App\Stock;
use App\StockTransfer;
use Illuminate\Http\Request;

class StockTransferController extends Controller
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
        return view('inventory.stock-transfers.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('inventory.stock-transfers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $st = new StockTransfer();
        $st->Number = $this->currentincrement();
        $st->Product = $request->Product;
        $st->Source = $request->Source;
        $st->Destination = $request->Destination;
        $st->Remarks = $request->Remarks;
        $st->Status = 'P'; // default is pending
        $st->save();
        return redirect()->to('/stock-transfer/view/'.$st->Number);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\StockTransfer  $id
     * @return \Illuminate\Http\Response
     */
    public function show($st)
    {
        $st = StockTransfer::where('Number','=',$st)->first();
        return view('inventory.stock-transfers.view', ['data'=>$st]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\StockTransfer  $id
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
     * @param  \App\StockTransfer  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\StockTransfer  $id
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
        $st = StockTransfer::all();
        $data = array();
        foreach ($st as $transfer)
        {
            $entry = array();
            $entry['Number'] = $transfer->Number;
            $entry['Product'] = $transfer->Product()->Description;
            $entry['Date'] = $transfer->created_at->format('F d, Y');
            $entry['Source'] = $transfer->Source()->Name;
            $entry['Destination'] = $transfer->Destination()->Name;
            $entry['Status'] = $transfer->Status;
            array_push($data, $entry);
        }


        return response()->json(['aaData'=>$data]);
    }

    public function productdata(Request $request) {
        $data = array();
        if($request->q) {
            $products = Product::where(function($query) use ($request){
                $query->where('UniqueID','like','%'.$request->q.'%')
                    ->orWhere('Description','like','%'.$request->q.'%');
            })->get();

            for($i=0;$i<count($products);$i++){
                if($products[$i]->Quantity>0) {
                    $entry['id'] = $products[$i]->ID;
                    $entry['text'] = '['.$products[$i]->UniqueID.'] '.$products[$i]->Description;
                    array_push($data, $entry);
                }
            }
        } else {
            $products = Product::all();
            for($i=0;$i<count($products);$i++){
                if($products[$i]->Quantity>0) {
                    $entry['id'] = $products[$i]->ID;
                    $entry['text'] = '['.$products[$i]->UniqueID.'] '.$products[$i]->Description;
                    array_push($data, $entry);
                }
            }
        }
        return response()->json(['results'=>$data]);
    }

    public function productlocationdata($product) {
        $product = Product::where('ID','=',$product)->first();
        return response()->json(['results'=>$product->Location()]);
    }

    public function locationdata(Request $request, $product = null) {
        $data = array();
        if($request->q) {
            $locations = Location::where([
                ['Name','like','%'.$request->q.'%'],
                ['Status','=',1]
            ])->get();
            for($i=0;$i<count($locations);$i++){
                $entry['id'] = $locations[$i]->ID;
                $entry['text'] = $locations[$i]->Name;
                array_push($data, $entry);
            }
        } else {
            $locations = Location::all();
            for($i=0;$i<count($locations);$i++){
                $entry['id'] = $locations[$i]->ID;
                $entry['text'] = $locations[$i]->Name;
                array_push($data, $entry);
            }
        }
        return response()->json(['results'=>$data]);
    }

    public function currentincrement()
    {
        $i = 0;
        $current = StockTransfer::orderByDesc('Number')->first();
        if($current) {
            $i = substr($current->Number,2);
            $i++;
        } else {
            $i++;
        }
        return sprintf('ST%s',str_pad($i,7,'0',STR_PAD_LEFT));
    }

    public function void($id) {
        $st = StockTransfer::where('Number','=',$id)->first();
        $st->Status = 'V';
        $st->save();
        return redirect()->to('/stock-adjustment/view/'.$id);
    }

    public function approve($id) {
        $st = StockTransfer::where('Number','=',$id)->first();
        $st->Status = 'A';
        $st->save();

        $product = Product::where([
            ['ID','=',$st->Product],
            ['Location','=',$st->Source]
        ])->first();

        $product->Location = $st->Destination;
        $product->save();

        return redirect()->to('/stock-transfer/view/'.$id);
    }
}

