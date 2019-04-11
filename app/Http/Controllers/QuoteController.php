<?php

namespace App\Http\Controllers;

use App\Product;
use App\Quote;
use App\Supplier;
use Carbon\Carbon;
use Faker\Provider\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\FileNotFoundException;

class QuoteController extends Controller
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
     * @param \App\Product $product
     * @return \Illuminate\Http\Response
     */
    public function index($product)
    {
        $product = Product::where('UniqueID','=',$product)->first();
        return view('quote.index', ['data'=>$product]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param \App\Product $product
     * @return \Illuminate\Http\Response
     */
    public function create($product)
    {
        $product = Product::where('UniqueID','=',$product)->first();
        return view('quote.create', ['data'=>$product]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $product = Product::where('UniqueID','=',$request->Product)->first();
        $supplier = Supplier::where('ID','=',$request->Supplier)->first();
        $file = $request->file('FileName');

        $quote = new Quote();
        $quote->Product = $product->ID;
        $quote->Supplier = $supplier->ID;
        $quote->Currency = $request->Currency;
        $quote->Amount = $request->Amount;
        $quote->ValidFrom = Carbon::parse($request->ValidFrom);
        $quote->Validity = $request->Validity;
        $quote->Valid = false;
        if($file!=null) {
            $quote->FileName = sprintf('%s-%s-%s.%s', $supplier->Code, $product->UniqueID, str_pad($this->CurrentIncrement($product, $supplier),3,'0', STR_PAD_LEFT), $file->getClientOriginalExtension());
            $request->FileName->move('quotes', $quote->FileName);
        } else {
            $quote->FileName = "N/A";
        }

//
//        if(file_exists(public_path('/quotes/'.$quote->FileName))){
//            unlink(public_path('/quotes/'.$quote->FileName));
//        }

        $quote->save();


        $quotes = Quote::where([
            ['Product','=',$quote->Product],
            ['Supplier','=',$quote->Supplier]
        ])->get();

        foreach($quotes as $q) {
            $q->Valid = 0;
            $q->save();
        }

        $quote->Valid = !$quote->ValidFrom->isFuture() && ($quote->ValidFrom->addDays($request->Validity))>Carbon::today()?true:false;
//        dd($quote->Valid);
        $quote->save();

        return redirect('/product/view/'.$product->UniqueID.'');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Quote  $quote
     * @return \Illuminate\Http\Response
     */
    public function show(Quote $quote)
    {
        return view('quote.view');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Quote  $quote
     * @return \Illuminate\Http\Response
     */
    public function edit(Quote $quote)
    {
        return view('quote.update');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Quote  $quote
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Quote $quote)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Quote  $quote
     * @return \Illuminate\Http\Response
     */
    public function destroy(Quote $quote)
    {
        //
    }

    public function data($product)
    {
        $product = Product::where('UniqueID','=',$product)->first();
        $quotes = Quote::where('Product','=',$product->ID)->get();
        $data = array();
        foreach($quotes as $quote){
            $entry = array();
            $entry['Supplier'] = $quote->Supplier;
            $entry['ValidFrom'] = $quote->ValidFrom;
            $entry['Amount'] = $quote->Amount;
            $entry['FileName'] = $quote->FileName;
            array_push($data, $entry);
        }

        return response()->json(['aaData'=>$data]);
    }

    public function CurrentIncrement(Product $product, Supplier $supplier) {
        $quote = Quote::where([
            ['Product','=',$product->ID],
            ['Supplier','=',$supplier->ID]
        ])->orderByDesc('FileName')->first();

        if($quote){
            $fileName = $quote->FileName;
            $fileName = substr($fileName,0,strpos($fileName, '.'));

            $id = explode('-',$fileName)[3];
            $id++;

            return $id;
        } else {
            $id = 0;
            $id++;

            return $id;
        }
    }

    public function viewDocument($fileName) {
        $path = public_path().'\\quotes\\'.$fileName;
        if(is_file($path)){
            return response()->file($path);
        }

        throw new FileNotFoundException(sprintf('File not found: %s', $fileName), 404);
    }

    public function viewPendingQuotes() {
        return view('quote.pending');
    }
}
