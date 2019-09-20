<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Svg\Tag\Line;
use Mockery\CountValidator\Exception;
use App\Traits\RecordSignature as Signature;

class Product extends Model
{
    use Signature;
    /**
     * The primary key of the table
     * @var string
     */
    protected $primaryKey = "ID";

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'products';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'UniqueID', 'Name', 'Description', 'UOM',
        'Category', 'ProductLine', 'Series', 'ItemType',
        'Location', 'Quantity',
        'ReOrderQuantity',
        'MinimumQuantity', 'MaximumQuantity', 'ReOrderPoint',
        'LastUnitCost',
        'InventoryGL', 'IssuanceGL',
        'Status'
    ];

    public function Quotes() {
        $quotes = $this->hasMany('App\Quote','Product','ID')->orderByDesc('created_at')->get();
        $data = array();
        foreach($quotes as $quote) {
            if(in_array($quote->Supplier, array_column($data, 'Supplier'))) {
                $index = array_search($quote->Supplier,array_column($data, 'Supplier'));
                array_push($data[$index]['Data'],$quote);
            } else {
                $supplier = array();
                $supplier['Supplier'] = $quote->Supplier;
                $supplier['Data'] = array();
                array_push($supplier['Data'], $quote);
                array_push($data, $supplier);

            }
        }
        return $data;
    }

    public function ValidQuotes() {
        $quote = $this->hasMany('App\Quote','Product','ID')->orderBy('Amount')->get();
        $quote = $quote->where('Valid','=',1);
        return $quote;
    }

    public function PreferredQuote() {
        return $this->ValidQuotes()->first();
    }

    public function Category() {
        // doesn't need counter pair @ Category entity. 1 way is enough.
        return $this->belongsTo('App\Category', 'Category', 'ID')->firstOrFail();
    }

    public function CategoryCode() {
        return $this->Category()->Identifier;
    }

    public function ProductLine() {
        return $this->belongsTo('App\ProductLine','ProductLine','ID')->firstOrFail();
    }

    public function ProductLineCode() {
        return $this->ProductLine()->Identifier;
    }

    public function UOM() {
        return $this->belongsTo('App\UnitOfMeasure', 'UOM', 'ID')->first();
    }

    public function Location() {
        return $this->belongsTo('App\Location', 'Location', 'ID')->first();
    }

    public function IssuanceReceipts(){
        return $this->hasManyThrough('App\IssuanceReceipt', 'App\LineItem', 'Product', 'LineItem')->get();
    }

    public function getGeneralLedger() {
        return $this->hasOne('App\GeneralLedger','ID','InventoryGL')->firstOrFail();
    }

    public function getIssuanceLedger() {
        return $this->hasOne('App\GeneralLedger','ID','IssuanceGL')->firstOrFail();
    }

    public function getLastFiveAwardedQuotations() {
        $data = array();
        $counter = 0;
        $orderItems = $this->hasManyThrough('App\OrderItem','App\LineItem','Product','LineItem')->get();
        foreach($orderItems as $orderItem) {
            if($orderItem->PurchaseOrder()) {
                $po = $orderItem->PurchaseOrder();
                if($po->Status=='A') { // filter only approved PO
                    if($counter < 5) {
                        array_push($data, $orderItem->SelectedQuote());
                        $counter++;
                    }
                }
            }
        }
        return $data;
    }

    public function scopeAllActive($query) {
        return $query->where('Status','=',1)->get();
    }

    public function getLastUnitCost() {
        $orderItem = $this->hasManyThrough('App\OrderItem','App\LineItem','Product','LineItem')->get()->last();
        if($orderItem!=null){
            $quote = $orderItem->SelectedQuote()!=null?$orderItem->SelectedQuote()->Amount:0;
        }
        else {
            $quote = 0;
        }
        return $quote;
        // get PO
        // get item price from PO
        // return item price.
    }
    public function getAverageCost() {
        $orderItems = $this->hasManyThrough('App\OrderItem','App\LineItem','Product','LineItem')->get();
        $entries = count($orderItems);
        $total = 0;
        foreach($orderItems as $orderItem) {
            $quote = $orderItem->SelectedQuote();
            $total += $quote->Amount;
        }

        return $total / $entries;
        // get PO
        // get item price from PO
        // return item price.
    }

    public function generateUniqueID($type=false) {
        if(!$type) {
            $desc = substr($this->Name,0,3);
            $desc = str_replace(" ","-",$desc); // replace spaces with dashes.
            $desc = strtoupper($desc); // Uppercase it just to make it standard.
            $category = $this->Category()->Identifier;
            $line = $this->ProductLine()->Identifier;
            return sprintf("%s-%s%s-%s",$desc,$category,$line, str_pad($this->getNextItemSeriesNumber(), 3,'0',STR_PAD_LEFT ));
        } else {
            if($type==="svc") {
                $desc = substr($this->Name,0,3);
                $desc = str_replace(" ","-",$desc); // replace spaces with dashes.
                $desc = strtoupper($desc); // Uppercase it just to make it standard.

                return sprintf("%s-%s%s",$desc, Carbon::today()->format("my"), str_pad($this->getNextServiceSeriesNumber(), 3,'0',STR_PAD_LEFT ));
            } else {
                $desc = substr($this->Name,0,3);
                $desc = str_replace(" ","-",$desc); // replace spaces with dashes.
                $desc = strtoupper($desc); // Uppercase it just to make it standard.
                $category = $this->Category()->Identifier;
                $line = $this->ProductLine()->Identifier;

                return sprintf("%s-%s%s-%s-TEMP",$desc,$category,$line, str_pad($this->getNextItemSeriesNumber(), 3,'0',STR_PAD_LEFT ));
            }
        }
    }

    public function getNextItemSeriesNumber() {
        $desc = substr($this->Name,0,3);
        $desc = str_replace(" ","-",$desc); // replace spaces with dashes.
        $category = $this->Category()->Identifier;
        $line = $this->ProductLine()->Identifier;

        $prefix = sprintf('%s-%s%s',$desc,$category,$line);
        try{
            $lastMatch = $this->where('UniqueID','like','%'.$prefix.'%')->get()->last();
            $lastCount = $lastMatch->Series;
            $lastCount++;
        }catch(\Exception $exception) {
            $lastCount = 1;
        }

        return $lastCount;
    }

    public function getNextServiceSeriesNumber() {
        $lastCount = 0;
        $prefix = sprintf("SER-%s", Carbon::today()->format("my"));
        try{
            $lastMatch = $this->where('UniqueID','LIKE',$prefix."%")->orderByDesc('UniqueID')->first();
            if($lastMatch) {
                $lastCount = $lastMatch->Series;
            }
            $lastCount++;
        }catch(ModelNotFoundException $exception) {
            $lastCount = 1;
        }

        return $lastCount;
    }

    public function getReservedQuantity() {
        $counter = 0;
        $lineItem = new LineItem();
        $lineItems = $lineItem->where('Product','=', $this->ID)->get();
        foreach($lineItems as $lineItem) {
            try{
                if(count($lineItems)>0 && $lineItem->isRequisition()) {
                    if(
                        $lineItem->Requisition()->Type=='IR'
                        and
                        $lineItem->Requisition()->Status=='A'
                    ) {
                        $counter += $lineItem->getRemainingReceivableQuantity();
                    }
                }
            }catch(ErrorException $ex) {
                dd($lineItem);
            }
        }

        return $counter;
    }

    public function getIncomingQuantity() {
        $counter = 0;
        $lineItem = new LineItem();
        $lineItems = $lineItem->where('Product','=', $this->ID)->get();
        foreach($lineItems as $lineItem) {
            if(count($lineItems)>0 and $lineItem->isOrderItem() and $lineItem->Ordered) {
                $orderItem = $lineItem->OrderItem();
                $purchaseOrder = $orderItem->PurchaseOrder();
                try{
                    if($purchaseOrder->Status=='A') {
                        $counter += $lineItem->getRemainingDeliverableQuantity();
                    }
                }
                catch(\Exception $ex) {
                    
                }
            }
        }

        return $counter;
    }

    public function getPurchaseOrders() {
        $data = array();
        
        $lineItem = new LineItem();
        $lineItems = $lineItem->where('Product','=', $this->ID)->get();
        foreach($lineItems as $lineItem) {
            if(count($lineItems)>0 and $lineItem->isOrderItem() and $lineItem->Ordered) {
                $orderItem = $lineItem->OrderItem();
                $purchaseOrder = $orderItem->PurchaseOrder();

                if($purchaseOrder->Status=='A') {
                    array_push($data, $purchaseOrder);
                }
            }
        }

        return $data;
    }

    public function getOrderItems() {
        $orderItems = $this->hasManyThrough('App\OrderItem','App\LineItem','Product','LineItem')->get();
        return $orderItems;
    }

    public function getAvailableQuantity() {
        return $this->Quantity - $this->getReservedQuantity();
    }

    public function LineItems() {
        return $this->hasMany("App\LineItem","Product", "ID")->get();
    }

    public function isTemporary() {
        return Str::endsWith($this->UniqueID, '-TEST');
    }

    public function hasPurchaseRequests() {
        $lineItem = new LineItem();
        return count($lineItem->where('Product','=',$this->ID)->get())>0;
    }

    // TODO!
    // BEGIN TODO
    public function getAverageUsage($type) {
        $today = Carbon::today();
        // Type: W|Weekly, M|Monthly
        // Step 1. Get all IssuanceReceipt of the product.
        $issuanceReceipts = $this->IssuanceReceipts();

        if($type=='W'){
            $today->startOfWeek(Carbon::MONDAY);
            $today->endOfWeek(Carbon::SUNDAY);
            $issuanceReceipts = $issuanceReceipts
            ->where('Received','>=',$today->startOfWeek())
            ->where('Received','<=',$today->endOfWeek());

            $total = 0;
            foreach($issuanceReceipts as $issuanceReceipt) {
                $total += $issuanceReceipt->Quantity;
            }

            return $total / 7;
        } else if($type=='M') {
            $today->startOfWeek(Carbon::MONDAY);
            $today->endOfWeek(Carbon::SUNDAY);
            $issuanceReceipts = $issuanceReceipts
            ->where('Received','>=',$today->startOfMonth())
            ->where('Received','<=',$today->endOfMonth());

            $total = 0;
            foreach($issuanceReceipts as $issuanceReceipt) {
                $total += $issuanceReceipt->Quantity;
            }

            return $total / $today->daysInMonth;
        } else 
            throw new \Exception("Invalid Average Usage Type.");
    }

    public function getTotalUsageOnMonth($date) {
        $issuanceReceipt = new IssuanceReceipt();
        $start = $date->startOfMonth();
        $end = $date->endOfMonth();

        $issuanceReceipts = $issuanceReceipt->whereBetween('Received',[$start, $end]);

        $total = 0;
        foreach($issuanceReceipts->get() as $issuanceReceipt) {
            $total += $issuanceReceipt->Quantity;
        }

        return $total;
    }

    public function getSafetyStockCount() {
        // Formula:
        // $safetyStocks = Average Usage * 3 days.
        return $this->getAverageUsage("W") * 3;
    }

    public function getMinimumStockLevel() { // Re-Order Point
        // Formula:
        // $rop = (Average Usage * Lead Time) + Safety Stock Count
        // Lead Time? Sa pending na reorder PO?
        return ( $this->getAverageUsage("W") * 7 ) + $this->getSafetyStockCount();
    }

    public function getMaximumStockLevel() {
        // TODO
        // Formula:
        // Economical Order Quantity
        // $eoq = AverageMonthlyUsage * $this->Class months
        // return $eoq;
        return $this->getAverageUsage('M') * 3;
    }

    public function getItemObsolescenceRisk() {
        $today = Carbon::today();
        $issuanceReceipts = $this->IssuanceReceipts();
        
        if(count($issuanceReceipts)>0){
            $issuanceReceipts = $issuanceReceipts->sortBy(function($col)
            {
                return $col['Received'];
            })->values()->all();

            if(count($issuanceReceipts)==1) {
                $issuanceReceipt = $issuanceReceipts[0];
            } else {
                $issuanceReceipt = $issuanceReceipts[count($issuanceReceipts)-1];
            }

            $diff = Carbon::parse($issuanceReceipt->Received)->diffInMonths($today);
        } else {
            return "No Available Data";
        }
        // Formula:
        // $lastTransactionDate = get date of last transaction on item.
        // $diff = $today->differenceInMonths($lastTransactionDate)
        // if($diff < 12) return "Fast Moving"
        if($diff < 12) return "Fast Moving";
        if($diff >= 12 && $diff < 24) return "Slow Moving";
        if($diff >= 24 && $diff < 36) return "Non-Moving";
        else return "Obsolete";
    }


    public function getReceivedQuantity(){
        $lineItems = $this->LineItems();

        $total = 0.0;
        foreach($lineItems as $lineItem) {
            if($lineItem->isOrderItem()) {
                $total += $lineItem->Quantity - $lineItem->getRemainingDeliverableQuantity();
            }
        }

        return $total;
    }

    public function getIssuedQuantity(){
        $lineItems = LineItem::
                    where('OrderNumber','like','IR%')
                    ->where('Product','=',$this->ID);

        $total = 0.0;
        foreach($lineItems->get() as $lineItem) {
            $receipts = $lineItem->IssuanceReceipts();
            foreach($receipts as $receipt) {
                $total += $receipt->Quantity;
            }
        }

        return $total;
    }

    public function getLastApprovedQuotation() {

    }

    public function setDeferred() {
        if(!$this->isDeferred()) {
            $defer = new Defer();
            $defer->Product = $this->ID;
            $defer->Added = Carbon::today();
            return $defer->save();
        }

        return false;
    }

    public function isDeferred() {
        $defer = new Defer();
        $defer = $defer->where('Product', $this->ID)->count();
        return $defer>0;
    }

    public function restoreDeferred() {
        if($this->isDeferred()) {
            $defer = new Defer();
            $defer = $defer->where('Product','=',$this->ID)->firstOrFail();
            return $defer->forceDelete();
        }
        return false;
    }
}
