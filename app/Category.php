<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Traits\RecordSignature as Signature;

class Category extends Model
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
    protected $table = 'categories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'Identifier', 'Description', 'Status'
    ];


    public static function FindIdByInventoryLedgerCode($code) {
        $prefix = Str::substr($code,0,5);
        switch($prefix) {
            case "13610": return 2;
            case "13620": return 3;
            case "13500": return 4;
            case "13300": return 5;
            default: return 1;
        }
    }
}

