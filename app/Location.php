<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\RecordSignature as Signature;

class Location extends Model
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
    protected $table = 'locations';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'Name', 'Status'
    ];
	
    public function scopeAllActive($query)
    {
        return $query->where('Status','=',1)->get();
    }

    public static function findByName($name) {
        $location = new Location();
        $location = $location->where('Name','=',$name)->firstOrFail();
        return $location;
    }

    public static function FindIdByName($name) {
        $location = new Location();
        try{
            $location = $location->where('Name','=',$name)->firstOrFail();
            return $location->ID;
        }catch(\Exception $exception) {

        }
        return 0;
    }
}
