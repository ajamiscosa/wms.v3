<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\RecordSignature as Signature;

class Quote extends Model
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
    protected $table = 'quotes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'Variant', 'Supplier', 'Currency', 'Amount', 'ValidFrom', 'Validity', 'Valid', 'FileName'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'ValidFrom'
    ];
	
    public function Product()
    {
        return $this->belongsTo('App\Product','Product','ID')->first();
    }

    public function Supplier()
    {
        return $this->belongsTo('App\Supplier','Supplier','ID')->first();
    }

    public function Currency()
    {
        return $this->belongsTo('App\Currency','Currency','ID')->first();
    }
}
