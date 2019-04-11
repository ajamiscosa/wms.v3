<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentLineItem extends Model
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
    protected $table = 'paymentitems';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'PaymentNumber', 'ItemType',
        'ReferenceNumber', 'Amount'
    ];
}
