<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UnitOfMeasure extends Model
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
    protected $table = 'uom';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'Name', 'Abbreviation', 'Status'
    ];


    public static function findByName($name) {
        $uom = new UnitOfMeasure();
        return $uom->where('Name','=',$name)->firstOrFail();
    }

    public static function FindIdByAbbreviation($abbr) {
        $uom = new UnitOfMeasure();
        try {
            $uom = $uom->where('Abbreviation','=',$abbr)->firstOrFail();
            return $uom->ID;
        } catch(\Exception $exception) {

        }
        return 0;
    }

    public static function Active() {
        $uom = new UnitOfMeasure();
        return $uom->where('Status','=',1)->get();
    }
}
