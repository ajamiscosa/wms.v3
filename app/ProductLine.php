<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Traits\RecordSignature as Signature;

class ProductLine extends Model
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
    protected $table = 'productlines';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'Code','Identifier', 'Description', 'Status'
    ];

    public static function FindIdByInventoryLedgerCode($code) {
        $code = Str::substr($code, 9);
        $pl = new ProductLine();
        try {
            $pl = $pl->where('Code','=',$code)->firstOrFail();
            return $pl->ID;
        } catch(\Exception $exception) {

        }
        return 0;
    }

    public static function FindProductLineByCode($code) { 
        $pl = new ProductLine();
        try {
            $pl = $pl->where('Code','=',$code)->firstOrFail();
            return $pl->ID;
        } catch(\Exception $exception) {

        }
    }
}

