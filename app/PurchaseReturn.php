<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PurchaseReturn extends Model
{
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
    protected $table = 'returns';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'OrderNumber', 'PurchaseOrder',
        'Date', 'Status', 'Total', 'Remarks'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'Date'
    ];
	
    public function PurchaseOrder()
    {
        return $this->belongsTo('App\PurchaseOrder','PurchaseOrder','OrderNumber')->first();
    }

    public function LineItems()
    {
        return $this->hasMany('App\LineItem','OrderNumber','OrderNumber')->get();
    }
}
