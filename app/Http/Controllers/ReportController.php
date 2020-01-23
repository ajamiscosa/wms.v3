<?php

namespace App\Http\Controllers;

use App\Classes\ReportHelper;
use App\Currency;
use App\IssuanceReceipt;
use App\LineItem;
use App\Product;
use App\PurchaseOrder;
use App\ReceiveOrder;
use App\Requisition;
use App\Supplier;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\InventoryLog;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Excel;
use App\StockAdjustment;

class ReportController extends Controller
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

    public function index() {
        return view('report.index');
    }

    public function showInventoryLogReport(Request $request) {
        return view('report.inventorylog');
    }


    public function showInventoryBalanceReport() {
        return view('report.inventorybalance');
    }

    public function exportInventoryBalanceReport(Request $request) {

        $columns = array(
            'UniqueID',
            'Description',
            'Category',
            'Product Line',
            'UOM',
            'On Hand',
            'Available',
            'Reserved',
            'Incoming'
        );

        $data = array();
        $product = new Product();

        $products = $product->all();
        foreach($products as $product) {

            $uom = $product->UOM()!=null?$product->UOM()->Abbreviation:"";
            $entry = array(
                $product->UniqueID,
                $product->Description,
                $product->CategoryCode(),
                $product->ProductLineCode(),
                $uom,
                $product->Quantity,
                $product->getAvailableQuantity(),
                $product->getReservedQuantity(),
                $product->getIncomingQuantity()
            );
            array_push($data, $entry);
        }

        $fileName = sprintf('InventoryBalance%s.csv', Carbon::today()->format('Ymd'));
        return ReportHelper::export($fileName,$columns,$data);
    }

    public function showIssuanceReport(Request $request){
        return view('report.issuance');
    }

    public function exportIssuanceReport(Request $request) {

        $issuanceReceipt = new IssuanceReceipt();

        if(isset($request->start)) {
            $start = Carbon::parse($request->start);
            $end = Carbon::parse($request->end);

            $end = $end->addDay();

            $issuanceReceipts = $issuanceReceipt->whereBetween('Received',[$start, $end]);
            $outDateFormat = $start->format('dmy');
        }
        else {
            $issuanceReceipts = $issuanceReceipt->whereDate('Received','=', Carbon::today());
            $outDateFormat = Carbon::today()->format('dmy');
        }

        if($request->curr==null or $request->curr=="PHP"){
            $curr = "PHP";
            $divisor = 1;
        } else {
            $curr = "USD";
            $divisor = Currency::getExchangeRate($curr);
        }

        $columns = array(
            'Item ID',
            'Reference',
            'Date',
            'Job ID',
            'Reason to Adjust',
            'Number of Distributions',
            'G/L Source Account',
            'Quantity',
            'Amount',
            'Serial Number'
        );

        $data = array();
        foreach($issuanceReceipts->get() as $receipt) {
            $lineItem = $receipt->getLineItem();
            $product = $lineItem->Product();

            $issuance = $lineItem->Requisition();
            
            $remarks = json_decode($issuance->Remarks, true);
        
            if ($issuance->ChargeType=='C') {
                $remark = $remarks['data'][0]['message'];
                $reason = "";
            }
            else {
                $remark = "";
                $remarks = json_decode($receipt->Remarks, true);
                $reason = $remarks['data'][0]['message'];
            }
            $entry = array(
                $product->UniqueID,
                // $lineItem->OrderNumber,
                $receipt->OrderNumber,
                Carbon::parse($receipt->Received)->format('m/d/Y'),
                $remark??"",
                $reason??"",
                // $receipt->Series,
                1, // 1 daw to sabi ni Zarah. Sept 9 2019
                $receipt->getLineItem()->GeneralLedger()->Code, // $product->getIssuanceLedger()->Code, // $lineItem->GeneralLedger()->Code,
                $receipt->Quantity * -1,
                $product->getLastUnitCost() / $divisor,
                'NA'
            );
            array_push($data, $entry);
        }

        $fileName = sprintf('Issuance%s%s.csv', $outDateFormat, $curr);
        return ReportHelper::export($fileName,$columns,$data);
    }

    public function exportReceivingReport(Request $request) {

        $receiveOrder = new ReceiveOrder();

        if(isset($request->start)) {
            $start = Carbon::parse($request->start);
            $end = Carbon::parse($request->end);
            $end = $end->addDay();


            $receiveOrders = $receiveOrder->whereBetween('Received',[$start, $end]);
            $outDateFormat = $start->format('d-m-Y');
        }
        else {
            $receiveOrders = $receiveOrder->whereDate('Received','=', Carbon::today());
            $outDateFormat = Carbon::today()->format('d-m-Y');
        }

        if($request->curr==null or $request->curr=="PHP"){
            $curr = "PHP";
            $divisor = 1;
        } else {
            $curr = "USD";
            $divisor = Currency::getExchangeRate($curr);
        }

        $columns = array(
            'Vendor ID',
            'Invoice/CM #',
            'Date',
            'Drop Ship',
            'Waiting on Bill',
            'Accounts Payable Account',
            'Accounts Payable Amount',
            'Note Prints After Line Items',
            'Beginning Balance Transaction',
            'Applied To Purchase Order',
            'Number of Distributions',
            'PO Number',
            'PO Distribution',
            'Quantity',
            'Item ID',
            'Description',
            'G/L Account',
            'Amount',
            'Displayed Terms',
            'Date Due',
            'Ship Via'
        );

        $counter = 1;
        $data = array();
        foreach($receiveOrders->get() as $order) {
            $order->getTotalDistributions();
            $orderItem = $order->OrderItem();
            $lineItem = $orderItem->LineItem();
            $product = $lineItem->Product();
            $quote = $orderItem->SelectedQuote();
            $supplier = $quote->Supplier();
            $currency = $quote->Currency()->Code;
            $pr = $orderItem->Requisition();
            $po = $orderItem->PurchaseOrder();
            $term = $po->PaymentTerm();

            if($currency == "PHP") {
                if($curr == "PHP") {
                    $amount = number_format(round(($quote->Amount * $order->Quantity),2) ,2,'.',',');
                }
                else {
                    $amount = number_format(round(($quote->Amount * $order->Quantity) / $divisor,2) ,2,'.',',');
                }
            }
            else { // USD
                $divisor = Currency::getExchangeRate('USD');
                if($curr == "PHP") {
                    $amount = number_format(round($quote->Amount * $order->Quantity * $divisor,2) ,2,'.',',');
                }
                else {
                    $amount = number_format(round(($quote->Amount * $order->Quantity),2) ,2,'.',',');
                }
            }

            
            $entry = array(
                $supplier->Code,
                sprintf("%s/%s", $order->OrderNumber, $order->ReferenceNumber),
                Carbon::parse($order->Received)->format('m/d/Y'),
                'FALSE',
                'FALSE',
                $po->APAccount()->Code,
                $amount,
                'FALSE',
                'FALSE',
                'TRUE',
                $order->getTotalDistributions(),
                $po->OrderNumber,
                $counter,
                $order->Quantity,
                $product->UniqueID,
                $product->Description,
                $product->getGeneralLedger()->Code,
                $amount,
                $term->Description,
                Carbon::parse($po->OrderDate)->addDays($supplier->Due)->format('m/d/Y'),
                sprintf("%s/%s", $pr->OrderNumber, 'STOCKS')
            );


            

            if($counter < $order->getTotalDistributions()) $counter++;
            else $counter = 1;
            array_push($data, $entry);
        }

        $fileName = sprintf('RR %s %s.csv', $outDateFormat, $curr);
        return ReportHelper::export($fileName,$columns,$data);
    }






    public function showReceivingReport(Request $request){
        return view('report.receiving');
    }



    public function showSuppliesAndProcessChemReport(Request $request){
        return view('report.supplypchem');
    }


    public function getVariablesForConsumptionReportOfProduct($uniqueID, $var) {
        $product = new Product();
        $product = $product->where('UniqueID','=',$uniqueID)->firstOrFail();

        $today = Carbon::today();
        $thisMonth = $today->addMonth()->firstOfMonth();

        $sixMonthsAgo = $today->subMonth(6)->firstOfMonth();

        $lineItem = new LineItem();
        $lineItems = $lineItem
            ->where('OrderNumber', 'LIKE', 'IR%')
            ->whereBetween('Received',[$sixMonthsAgo, $thisMonth])
            ->get();


        dd($lineItems);
        $receipts = array();
        foreach($lineItems as $lineItem){
            foreach($lineItem->getIssuanceReceipts() as $ir) {
                array_push($receipts, $ir);
            }
        }

        $data = array();
        foreach($receipts as $receipt) {
            $data[$today->year][Carbon::parse($receipt->Received)->format('n')] += $receipt->getLineItem()->Quantity;
        }


    }

    public function showConsumptionReportOfProduct($uniqueID){
        $product = new Product();
        $product = $product->where('UniqueID','=',$uniqueID)->firstOrFail();

        return view('report.consumption.view',['data'=>$product]);
    }

    public function showConsumptionReport(Request $request){
        return view('report.consumption');
    }

    public function exportConsumptionReport(Request $request, $id)
    {
        $product = Product::where('UniqueID','=',$id)->first();

        if($product){

            $file = Storage::url('/app/template/consumption.xlsx');

            $data = array(
                'B2' => $product->UniqueID,
                'C2' => $product->Description,
                //
                'W1' => Carbon::today()->subMonth(12)->format('M-y'),
                'X1' => Carbon::today()->subMonth(11)->format('M-y'),
                'Y1' => Carbon::today()->subMonth(10)->format('M-y'),
                'Z1' => Carbon::today()->subMonth(9)->format('M-y'),
                'AA1' => Carbon::today()->subMonth(8)->format('M-y'),
                'AB1' => Carbon::today()->subMonth(7)->format('M-y'),
                'AC1' => Carbon::today()->subMonth(6)->format('M-y'),
                'AD1' => Carbon::today()->subMonth(5)->format('M-y'),
                'AE1' => Carbon::today()->subMonth(4)->format('M-y'),
                'AF1' => Carbon::today()->subMonth(3)->format('M-y'),
                'AG1' => Carbon::today()->subMonth(2)->format('M-y'),
                'AH1' => Carbon::today()->subMonth(1)->format('M-y'),
                'AI1' => Carbon::today()->subMonth(0)->format('M-y'),
                ////
                'W2' => $product->getTotalUsageOnMonth(Carbon::today()->subMonth(12)),
                'X2' => $product->getTotalUsageOnMonth(Carbon::today()->subMonth(11)),
                'Y2' => $product->getTotalUsageOnMonth(Carbon::today()->subMonth(1)),
                'Z2' => $product->getTotalUsageOnMonth(Carbon::today()->subMonth(9)),
                'AA2' => $product->getTotalUsageOnMonth(Carbon::today()->subMonth(8)),
                'AB2' => $product->getTotalUsageOnMonth(Carbon::today()->subMonth(7)),
                'AC2' => $product->getTotalUsageOnMonth(Carbon::today()->subMonth(6)),
                'AD2' => $product->getTotalUsageOnMonth(Carbon::today()->subMonth(5)),
                'AE2' => $product->getTotalUsageOnMonth(Carbon::today()->subMonth(4)),
                'AF2' => $product->getTotalUsageOnMonth(Carbon::today()->subMonth(3)),
                'AG2' => $product->getTotalUsageOnMonth(Carbon::today()->subMonth(2)),
                'AH2' => $product->getTotalUsageOnMonth(Carbon::today()->subMonth(1)),
                'AI2' => $product->getTotalUsageOnMonth(Carbon::today()->subMonth(0)),
            );


            $today = Carbon::today()->format('Ymd');

            \Excel::load($file, function($reader) use ($data) {
                $reader->sheet(0, function($sheet) use ($data) {
                    foreach($data as $key=>$value) {
                        $sheet->cell($key, function($cell) use ($value) {
                            $cell->setValue($value);
                        });
                    }
                });

            })
            ->setFilename("ConsumptionReport-{$product->UniqueID}-{$today}")
            ->export('xlsx');

        }


    }




    public function showItemMovementReport(Request $request){
        return view('report.itemmovement');
    }

    public function exportItemMovementReport(Request $request) {
        $date = Carbon::now()->format('Ymd');
        \Excel::create("ItemMovementReport-{$date}", function($excel) {

            $excel->sheet('New sheet', function($sheet) {

                $sheet->loadView('report.view.itemmovement');

            });

        })->download('xlsx');
    }









    public function showPurchaseRequestStatusReport(Request $request) {
        return view('report.prstatus');
    }

    public function exportPurchaseRequestStatusReport(Request $request) {

        $requisition = new Requisition();
        $rsList = $requisition->where('Type','=','PR');

        if(isset($request->start)) {
            $start = Carbon::parse($request->start);
            $end = Carbon::parse($request->end);

            $end = $end->addDay();

            $rsList = $rsList->whereBetween('created_at',[$start, $end]);
            $outDateFormat = $start->format('dmy');
        }
        else {
            $outDateFormat = Carbon::today()->format('dmy');
        }

        $rsList = $rsList->get();
        
        $date = Carbon::now()->format('Ymd');
        \Excel::create("PRStatusReport-{$date}", function($excel) use ($rsList) {

            $excel->sheet('PRStatusReport', function($sheet) use ($rsList) {
                $sheet->loadView('report.view.prstatus',['data'=>$rsList]);
            });

        })->download('xlsx');
    }

    public function showRecentlyAddedSuppliersReport(Request $request) {
        return view('report.suppliers');
    }

    public function exportSupplierReport(Request $request) {
        $supplier = new Supplier();

        if(isset($request->start)) {
            $start = Carbon::parse($request->start);
            $end = Carbon::parse($request->end);
            $end = $end->addDay();
            if($start->format('Ymd')===$end->format('Ymd')) {
            }

            $suppliers = $supplier->whereBetween('created_at', [$start, $end]);
            $title = sprintf("%s-%s", $start->format('Ymd'), $end->format('Ymd'));
        }
        else {
            $suppliers = $supplier->whereDate('created_at', '=', Carbon::today()->toDateString());
            $title = Carbon::today()->format('Ymd');
        }

        // dd($suppliers->get());

        $columns = array(
            'Vendor ID',
            'Vendor Name', 'Inactive', 'Contact', 'Address-Line One', 'Address-Line Two', 'City', 'State', 'Zip', 'Country',
            'Vend Type', '1099 Type', 'Telephone 1', 'Telephone 2', 'Fax Number', 'Vendor E-mail', 'Vendor Web Site',
            'Expense Account', 'Tax ID Number', 'Account Number', 'Ship Via', 'Use Standard Terms', 'C.O.D. Terms',
            'Prepaid Terms', 'Terms Type', 'Due Days', 'Discount Days', 'Discount Percent', 'Credit Limit',
            'Due Month End Terms', 'Office Manager', 'Account Rep', 'Special Note', 'Vendor Since Date',
            'ID Replacement', 'Use Payment Settings', 'Vendor Payment Method', 'Vendor Cash Account'
        );

        $data = array();
        foreach($suppliers->get() as $supplier) {
            $entry = array(
                $supplier->Code,
                $supplier->Name,
                $supplier->status?"FALSE":"TRUE",
                $supplier->Contact,
                $supplier->AddressLine1,
                $supplier->AddressLine2,
                $supplier->City,
                $supplier->State,
                $supplier->Zip,
                $supplier->Country,
                $supplier->SupplierType()->Description,
                null,
                $supplier->Telephone1,
                $supplier->Telephone2,
                $supplier->FaxNumber,
                $supplier->Email,
                $supplier->WebSite,
                $supplier->APAccount,
                $supplier->TIN,
                null,
                null,
                null,
                null,
                null,
                "FALSE",
                $supplier->Due,
                0,
                0,
                0,
                "FALSE",
                null,
                null,
                null,
                null,
                null,
                "TRUE",
                null,
                null
            );

            array_push($data, $entry);
        }

        $fileName = sprintf('Suppliers%s.csv', $title);
        return ReportHelper::export($fileName,$columns,$data);
    }


    public function showPurchaseOrdersReport() {
        return view('report.po');
    }

    public function exportPurchaseOrdersReport(Request $request) {
        $purchaseOrder = new PurchaseOrder();

        if(isset($request->start)) {
            $start = Carbon::parse($request->start);
            $end = Carbon::parse($request->end);

            if($start->format('Ymd')===$end->format('Ymd')) {
                $end = $end->addDay();
            }

            $purchaseOrders = $purchaseOrder->whereBetween('created_at', [$start, $end]);
            $title = sprintf("%s-%s", $start->format('Ymd'), $end->format('Ymd'));
        }
        else {
            $purchaseOrders = $purchaseOrder->whereDate('created_at', '=', Carbon::today()->toDateString());
            $title = Carbon::today()->format('Ymd');
        }


        $columns = array(
            'Vendor ID', 'Vendor Name', 'Remit to Address Line 1', 'Remit to Address Line 2',
            'Remit to City', 'Remit to State', 'Remit to Zip', 'Remit to Country', 'PO #',
            'Date', 'Closed', 'P.O. Good Thru Date', 'Drop Ship', 'Customer SO #', 'Customer Invoice #',
            'Customer ID', 'Ship to Name', 'Ship to Address-Line One', 'Ship to Address-Line Two',
            'Ship to City', 'Ship to State', 'Ship to Zipcode', 'Ship to Country', 'Discount Amount',
            'Displayed Terms', 'Accounts Payable Account', 'Ship Via', 'P.O. Note',
            'Internal Note', 'Note Prints After Line Items', 'Number of Distributions', 'PO Distribution',
            'Quantity', 'Stocking Quantity', 'Item ID', 'U/M ID', 'U/M No. of Stocking Units',
            'Description', 'G/L Account', 'Unit Price', 'Stocking Unit Price', 'UPC / SKU',
            'Weight', 'Amount', 'Job ID'
        );

        $data = array();

        foreach($purchaseOrders->get() as $po) {
            if($po->Status=='A') {
                $supplier = $po->Supplier();
                $currency = $supplier->Currency();
                $term = $po->PaymentTerm();
                $apAccount = $po->APAccount();
                $orderItems = $po->OrderItems();

                $counter = 1;
                foreach($orderItems as $orderItem) {
                    $lineItem = $orderItem->LineItem();
                    $product = $lineItem->Product();
                    $uom = $product->UOM()!=null?$product->UOM()->Abbreviation:"";
                    $quote = $orderItem->SelectedQuote();
                    $entry = array(
                        $supplier->Code,
                        $supplier->Name,
                        $supplier->AddressLine1,
                        $supplier->AddressLine2,
                        $supplier->City,
                        $supplier->State,
                        $supplier->Zip,
                        $supplier->Country,
                        //
                        $po->OrderNumber,
                        $po->OrderDate->format('m/d/Y'),
                        "TRUE",
                        $po->OrderDate->addMonths(1)->format('m/d/Y'),
                        "FALSE",
                        null,
                        null,
                        null,
                        "PHP II-VI Performance Metals Inc.",
                        "Lot 6 Blk 1 Phase 2",
                        "Cavite Economic Zone Rosario",
                        "Cavite",
                        "DC",
                        "4106",
                        "Philippines",
                        0,
                        $term->Description,
                        $apAccount->Code,
                        sprintf("%s",$po->ChargeNo), // this is WIP
                        null,
                        null,
                        "FALSE",
                        count($orderItems)+1,
                        $counter,
                        $lineItem->Quantity,
                        $lineItem->Quantity,
                        $product->UniqueID,
                        $uom,
                        1,
                        $product->Description,
                        $product->getGeneralLedger()->Code,
                        $quote->Amount,
                        $quote->Amount,
                        null,
                        0,
                        $quote->Amount * $lineItem->Quantity,
                        null
                    );
                    $counter++;
                    array_push($data, $entry);
                }
                
                $entry = array(
                    $supplier->Code,
                    $supplier->Name,
                    $supplier->AddressLine1,
                    $supplier->AddressLine2,
                    $supplier->City,
                    $supplier->State,
                    $supplier->Zip,
                    $supplier->Country,
                    //
                    $po->OrderNumber,
                    $po->OrderDate->format('m/d/Y'),
                    "TRUE",
                    $po->OrderDate->addMonths(1)->format('m/d/Y'),
                    "FALSE",
                    null,
                    null,
                    null,
                    "PHP II-VI Performance Metals Inc.",
                    "Lot 6 Blk 1 Phase 2",
                    "Cavite Economic Zone Rosario",
                    "Cavite",
                    "DC",
                    "4106",
                    "Philippines",
                    0,
                    $term->Description,
                    $apAccount->Code,
                    sprintf("%s",$po->ChargeNo), // this is WIP
                    null,
                    null,
                    "FALSE",
                    count($orderItems)+1,
                    $counter,
                    0,
                    0,
                    null,
                    null,
                    1,
                    "X X X NOTHING FOLLOWS X X X",
                    '13500-00-09',
                    0,
                    0,
                    null,
                    0,
                    0,
                    null
                );

                array_push($data, $entry);
            }

        }

        
        $fileName = sprintf('PurchaseOrders%s.csv', $title);
        return ReportHelper::export($fileName,$columns,$data);
    }

    public function showCustomPOList() {
        return view('report.custompolist');
    }

    public function exportCustomPOList(Request $request) {
        $po = new PurchaseOrder();
        if(isset($request->start)) {
            $start = Carbon::parse($request->start);
            $end = Carbon::parse($request->end);

            if($start->format('Ymd')===$end->format('Ymd')) {
                $end = $end->addDay();
            }

            $po = $po->whereBetween('created_at', [$start, $end]);
            $title = sprintf("%s-%s", $start->format('Ymd'), $end->format('Ymd'));
        }
        else {
            $po = $po->whereDate('created_at', '=', Carbon::today()->toDateString());
            $title = Carbon::today()->format('Ymd');
        }

        $columns = array(
            'Vendor ID',
            'Vendor Name',
            'PO Number',
            'Date',
            'Ship Via',
            'PO Total',
            'Terms'
        );
        $po = $po->where('Status','=','A');
        $data = array();
        foreach($po->get() as $order) {
            $supplier = $order->Supplier();
            $entry = array(
                $supplier->Code,
                $supplier->Name,
                $order->OrderNumber,
                Carbon::parse($order->OrderDate)->format('m/d/Y'),
                $order->getShipVia(),
                $order->Total,
                $order->PaymentTerm()->Description
            );
            array_push($data, $entry);
        }

        $fileName = sprintf('PO-Order-List-%s.csv', $title);
        return ReportHelper::export($fileName,$columns,$data);
    }

    public function showCapexList() {

    }

    public function exportCapexList(Request $request) {
        $columns = array(
            'Job ID', 'Job Description', 'Use Phases',
            'Inactive', 'Supervisor', 'Customer ID',
            'Address Line 1', 'Address Line 2', 'City', 'State',
            'Zip', 'Country', 'Start Date', 'Projected End Date',
            'Actual End Date', 'Job Status', 'Job Type',
            'PO Number', 'Billing Method', '% Complete',
            'Labor Burden Percent', 'Retainage Percent', 'Second Contact',
            'Special Instruct', 'Site Phone #', 'Contract Date',
            'Work Phone #', 'Job Note', 'Distribution Phase ID',
            'Distribution Cost Code ID', '# of Units',
            'Distribution Est. Revenues', 'Distribution Est. Expenses'
        );
    }


    public function showRecentlyAddedItemsReport() {
        return view('report.items');
     }

    public function exportItemsReport(Request $request) {
        try {
            $product = new Product();
            $product = $product
                            ->where('UniqueID','NOT LIKE','%-TEMP')
                            ->where('UniqueID','NOT LIKE','SER-%');

            if(isset($request->start)) {
                $start = Carbon::parse($request->start);
                $end = Carbon::parse($request->end);

                if($start->format('Ymd')===$end->format('Ymd')) {
                    $end = $end->addDay();
                }

                $products = $product->whereBetween('created_at', [$start, $end]);
                $title = sprintf("%s-%s", $start->format('Ymd'), $end->format('Ymd'));
            }
            else {
                $products = $product->whereDate('created_at', '=', Carbon::today()->toDateString());
                $title = Carbon::today()->format('Ymd');
            }

            $columns = array(
                'Item ID','Item Description','Inactive',
                'Description for Purchases','Last Unit Cost',
                'Quantity On Hand','Minimum Stock','Reorder Quantity',
                'G/L Sales Account','G/L Inventory Account',
                'G/L COGS/Salary Acct','Item Type','Location','Stocking U/M'
            );

            $data = array();
            foreach($products->get() as $product) {
                $location = $product->Location();
                $location = $location!=null?$location->Name:"";

                $uom = $product->UOM();
                $uom = $uom!=null?$uom->Abbreviation:"";
                
                $entry = array(
                    $product->UniqueID,
                    $product->Description,
                    "FALSE",
                    $product->Description,
                    $product->LastUnitCost,
                    $product->Quantity,
                    $product->ReOrderQuantity,
                    $product->MinimumQuantity,
                    '41120-00-05',
                    $product->getGeneralLedger()->Code,
                    $product->getIssuanceLedger()->Code,
                    null,
                    $location,
                    $uom
                );

                array_push($data, $entry);
            }

            $fileName = sprintf('Items%s.csv', $title);
            return ReportHelper::export($fileName,$columns,$data);
        }
        catch(\Exception $ex) {
            dd($ex);
        }
    }

    public function showStockAdjustmentsReport() {
        return view('report.adjustments');
    }

    public function exportAdjustmentReport(Request $request) {
        $adjustment = new StockAdjustment();

        if(isset($request->start)) {
            $start = Carbon::parse($request->start);
            $end = Carbon::parse($request->end);

            $end = $end->addDay();

            $adjustments = $adjustment->whereBetween('created_at',[$start, $end]);
            $outDateFormat = $start->format('dmy');
        }
        else {
            $adjustments = $adjustment->whereDate('created_at','=', Carbon::today());
            $outDateFormat = Carbon::today()->format('dmy');
        }

        if($request->curr==null or $request->curr=="PHP"){
            $curr = "PHP";
            $divisor = 1;
        } else {
            $curr = "USD";
            $divisor = Currency::getExchangeRate($curr);
        }

        $columns = array(
            'Item ID',
            'Reference',
            'Date',
            'Job ID',
            'Reason to Adjust',
            'Number of Distributions',
            'G/L Source Account',
            'Quantity',
            'Amount',
            'Serial Number'
        );

        $data = array();
        foreach($adjustments->get() as $adjustment) {
            if($adjustment->Status == 'A') {// $lineItem = $receipt->getLineItem();
                $product = $adjustment->Product();
                
                $entry = array(
                    $product->UniqueID,
                    $adjustment->Number,
                    Carbon::parse($adjustment->created_at)->format('m/d/Y'),
                    null,
                    $adjustment->Reason,
                    // null,
                    1, // 1 daw to sabi ni Zarah. Sept 9 2019
                    $product->getIssuanceLedger()->Code,
                    $adjustment->Final - $adjustment->Initial,
                    0, // $product->getLastUnitCost() / $divisor, 0 daw sabi ni zarah. Sept 19 2019
                    'NA'
                );
                array_push($data, $entry);
            }
        }

        $fileName = sprintf('Adjustments%s%s.csv', $outDateFormat, $curr);
        return ReportHelper::export($fileName,$columns,$data);
    }

    public function showItemRestockReport() { 
        return view('report.restock');
    }

    public function exportItemRestockReport() { 
        $columns = array(
            'UniqueID',
            'Description',
            'ReOrderPoint',
            'ReOrderQuantity',
            'Quantity',
            'IncomingQuantity',
            'UOM'
        );

        $data = array();
        $product = new Product();
        $products = $product->whereRaw('Quantity < ReOrderPoint');

        foreach($products->get() as $product) {

            $uom = $product->UOM()!=null?$product->UOM()->Abbreviation:"";
            $entry = array(
                $product->UniqueID,
                $product->Description,
                $product->ReOrderPoint,
                $product->ReOrderQuantity,
                $product->Quantity,
                $product->getIncomingQuantity(),
                $uom
            );
            array_push($data, $entry);
        }

        $fileName = sprintf('ItemsForRestock%s.csv', Carbon::today()->format('Ymd'));
        return ReportHelper::export($fileName,$columns,$data);
    }

    public function exportItemRestockReportAsFile() { 
        
        \Excel::create(sprintf('ItemsForRestock%s', Carbon::today()->format('Ymd')), function($excel) {

            $excel->sheet('New sheet', function($sheet) {

                $product = new Product();
                $products = $product->whereRaw('Quantity < ReOrderPoint');
                $sheet->loadView('report.view.restock', ['products'=>$products]);

            });

        })->store('xlsx');
        
    }
}
