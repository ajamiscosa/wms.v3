<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\RecordSignature as Signature;

class PaymentMode extends Model
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
    protected $table = 'paymentmodes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'Name', 'Description'
    ];
}
