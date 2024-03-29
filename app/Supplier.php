<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\RecordSignature as Signature;

class Supplier extends Model
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
    protected $table = 'suppliers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'Code',
        'Name',
        'TIN',
        'SupplierType',
        'Currency',
        'DeliveryLeadTime',
        'APAccount',
        'Term',
        'Contact',
        'AddressLine1',
        'AddressLine2',
        'City',
        'State',
        'Zip',
        'Country',
        'Telephone1',
        'Telephone2',
        'FaxNumber',
        'Email',
        'WebSite',
        'Status',
        'Classification'
    ];

    public function CreatedBy() {
        return $this->belongsTo('App\User', 'created_by', 'ID')->first();
    }

    public function Quotes() {
        return $this->hasMany('App\Quote','Supplier','ID')->get();
    }

    public function Products() {
        $products = array();
        foreach($this->Quotes() as $quote) {
            if(!in_array($quote->Product, $products)) {
                array_push($products,$quote->Product);
            }
        }

        $data = array();
        foreach($products as $product) {
            $p = Product::where('ID','=',$product)->first();
            array_push($data, $p);
        }

        return $data;
    }

    public function SupplierType()
    {
        return $this->belongsTo('App\SupplierType','SupplierType','ID')->first();
    }

    public function PaymentTerm()
    {
        return $this->belongsTo('App\Term','Term','ID')->first();
    }

    public function APAccount()
    {
        return $this->belongsTo('App\GeneralLedger','APAccount','ID')->first();
    }


    public function Currency() {
        return $this->hasOne('App\Currency','ID','Currency')->first();
    }
}
