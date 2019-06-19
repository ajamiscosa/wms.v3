<?php

namespace App\Http\Controllers;

use App\Category;
use App\Classes\BarcodeHelper;
use App\Classes\DTO\DTO;
use App\GeneralLedger;
use App\Location;
use App\Product;
use App\ProductLine;
use App\Stock;
use App\UnitOfMeasure;
use App\Variant;
use Illuminate\Http\Request;
use Psy\Util\Json;

class ProductController extends Controller
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
        return view('inventory.products.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('inventory.products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $category = Category::FindIdByInventoryLedgerCode($request->InventoryGL);
        $productLine = ProductLine::FindIdByInventoryLedgerCode($request->IssuanceGL);

        $inventoryGL = GeneralLedger::FindIdByCode($request->InventoryGL);
        $issuanceGL = GeneralLedger::FindIdByCode($request->IssuanceGL);

        $product = new Product();
        $product->Location = $request->Location;
        $product->Name = strtoupper($request->Name);
        $product->Description = strtoupper($request->Description);
        $product->InventoryGL = $inventoryGL;
        $product->IssuanceGL = $issuanceGL;
        $product->Category = $category;
        $product->ProductLine = $productLine;
        $product->Series = $product->getNextItemSeriesNumber();
        $product->UOM = $request->UOM;
        $product->Quantity = 0;
        $product->SafetyStockQuantity = $request->SafetyStockQuantity;
        $product->MaximumQuantity = $request->MaximumQuantity;
        $product->MinimumQuantity = $request->MinimumQuantity;
        $product->CriticalQuantity = $request->CriticalQuantity;
        $product->UniqueID = $product->generateUniqueID();
        $product->save();

        return redirect()->to('/product/view/'.$product->UniqueID);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show($product)
    {
        try {
            $product = Product::where('UniqueID','=', $product)->firstOrFail();
            return view('inventory.products.view', ['data'=>$product]);
        } catch (\Exception $exception) {
            $data = new DTO();
            $data->Title = "Product $product";
            $data->Class = "Product";
            $data->Description = "We cannot not find the $data->Class in the database.";
            return response()
                ->view('errors.404',['data'=>$data]
                    ,404);
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit($product)
    {
        $product = Product::where('UniqueID','=', $product)->first();
        return view('inventory.products.update', ['data'=>$product]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $product)
    {
        $p = new Product();
        $product = $p->where('UniqueID','=', $product)->first();
        $category = Category::FindIdByInventoryLedgerCode($request->InventoryGL);
        $productLine = ProductLine::FindIdByInventoryLedgerCode($request->IssuanceGL);

        $inventoryGL = GeneralLedger::FindIdByCode($request->InventoryGL);
        $issuanceGL = GeneralLedger::FindIdByCode($request->IssuanceGL);

//        $product->Location = $request->Location;
//        $product->Name = strtoupper($request->Name);
        $product->Description = strtoupper($request->Description);
        $product->InventoryGL = $inventoryGL;
        $product->IssuanceGL = $issuanceGL;
        $product->Category = $category;
        $product->ProductLine = $productLine;
//        $product->UOM = $request->UOM;
        $product->save();

        return redirect()->to('/product/view/'.$product->UniqueID);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }

    /**
     * Fetches all available data.
     *
     * @param  \App\Person  $contact
     * @param  \Illuminate\Http\Request  $request
     * @return Json
     */
    public function data(Request $request)
    {
        $data = array();
        $products = Product::all();
        foreach($products as $product)
        {
            $entry = array();
            $entry['UniqueID'] = $product->UniqueID;
            $entry['Description'] = $product->Description;
            $entry['TotalStock'] = $product->Quantity;
            $entry['UOM'] = $product->UOM()->Abbreviation;
            $entry['Category'] = $product->Category()->Description;
            $entry['ProductLine'] = $product->ProductLine()->Description;
            $entry['ReorderPoint'] = $product->ReorderPoint;
            $entry['MinimumQuantity'] = $product->MinimumQuantity;
            $entry['CriticalQuantity'] = $product->CriticalQuantity;
            $entry['Status'] = $product->Status;
            array_push($data, $entry);
        }

        return response()->json(['aaData'=>$data]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function toggle(Request $request, $product)
    {
        $product = Product::where('UniqueID','=',$product)->first();
        $product->Status = !$product->Status;
        $product->save();
        return redirect()->to('/product/view/'.$product->UniqueID);
    }

    public function currentstocks($product) {
        $product = Product::where('ID','=',$product)->first();

        $data = array();
        if($product){
            $data['UOM'] = $product->UOM()->Abbreviation;
            $data['Quantity'] = $product->Quantity;
            $data['UOMType'] = $product->UOM()->Type;
        }

        return response()->json($data);
    }

    public function transactions($product) {
        if($product) {
            $product = Product::where('UniqueID','=',$product)->first();
            return view('templates.rsitemsub', ['data'=>$product]);
        }
    }
//Name: data[0],
//Description: data[1],
//Status: data[2],
//InventoryGL: data[6],
//PurchasingGL: data[7],
//Location: data[9],
//UOM: data[10],
//MinimumQuantity: data[10],
//Quantity: data[13]

    public function addProductFromAjax(Request $request) {
        $product = new Product();
        $product->OldID = $request->OldID;
        $product->Name = $request->Name;
        $product->Description = $request->Description;
        $product->Status = $request->Status=="FALSE"?true:false;
        $product->UOM = UnitOfMeasure::FindIdByAbbreviation($request->UOM);
        $product->Category = Category::FindIdByInventoryLedgerCode($request->InventoryGL);
        $product->ProductLine = ProductLine::FindIdByInventoryLedgerCode($request->IssuanceGL);
        $product->Location = Location::FindIdByName($request->Location);
        $product->Quantity = $request->Quantity < 0 ? $request->Quantity * -1 : $request->Quantity;
        $product->SafetyStockQuantity = 0;
        $product->MinimumQuantity = $request->MinimumQuantity;
        $product->MaximumQuantity = 0;
        $product->CriticalQuantity = 0;
        $product->LastUnitCost = $request->LastUnitCost;
        $product->InventoryGL = GeneralLedger::FindIdByCode($request->InventoryGL);
        $product->IssuanceGL = GeneralLedger::FindIdByCode($request->IssuanceGL);
        $product->UniqueID = $product->generateUniqueID();
        $product->Series = $product->getNextItemSeriesNumber();
        $product->save();
        return response()->json(['message'=>'success']);
    }

    public function previewBarcode($product) {
        return BarcodeHelper::GenerateBarcodeImageFromString($product,1);
    }

    public function previewQrCode($product) {
        return BarcodeHelper::GenerateQrImageFromString($product,1);
    }
}
