<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\RecordSignature as Signature;

class Person extends Model
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
    protected $table = 'people';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'LastName', 'FirstName', //'MiddleName',
        'Gender', 'Birthday', 'Email', 'ContactNumber',
        'Position', 'ImageFile'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'Birthday'
    ];

    public function Name() {
        return $this->FirstName.' '.$this->LastName;
    }

    public function AbbreviatedName () {
        $firstName = explode(' ',$this->FirstName);
        if(count($firstName)>1) {
            return $firstName[0][0].''.$firstName[1][0].' '.$this->LastName;
        }
        else {
            return sprintf("%s%s %s", $this->FirstName[0],strlen($this->MiddleName)>0?$this->MiddleName[0]:'',$this->LastName);
        }
    }
    public function User() {
        return $this->belongsTo('App\User', 'ID', 'Person')->first();
    }
}
