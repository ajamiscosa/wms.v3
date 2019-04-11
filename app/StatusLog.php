<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StatusLog extends Model
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
    protected $table = 'statuslogs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'OrderNumber', 'TransactionType', 'LogType'
    ];
	
    public function By() {
        return User::where('ID','=',$this->created_by)->first();
    }
}
