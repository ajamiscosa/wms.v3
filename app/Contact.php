<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
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
    protected $table = 'contacts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'Name', 'Type', 'Address', 'Email',
        'Website', 'CreditLimit', 'PaymentTerm',
        'TIN', 'ContactPersons'
    ];

    public function ContactNumber()
    {
        $numbers = $this->hasMany('App\PhonebookEntry', 'ReferenceID', 'ID')
        ->where([
                ['ReferenceID','=',$this->ID],
                ['Type','=','C']
            ]
        )->get();
        $str = "";
        foreach($numbers as $number)
        {
            $str.=$number->Number;
            if(count($numbers)>1)
            {
                $str.=" / ";
            }
        }
        $str = trim($str," / ");
        $this->save();
        return $str;
    }

    public function ContactNumbers()
    {
        return $this->hasMany('App\PhonebookEntry', 'ReferenceID', 'ID')
            ->where([
                ['ReferenceID','=',$this->ID],
                ['Type','=','C']
            ])->get();
    }


    public function CreatedBy()
    {
        return $this->belongsTo('App\User', 'created_by', 'ID')->first();
    }

    public function ContactPersons()
    {
        $data = array();
        $contactPersons = json_decode($this->ContactPersons);
        if($contactPersons) {
            foreach(json_decode($this->ContactPersons) as $person)
            {
                $entry = Person::where('ID', '=', $person)->first();
                array_push($data, $entry);
            }
        }
        return $data;
    }

    public function scopeSuppliers($query)
    {
        return $query->where('Type','=','S')->orWhere('Type','=','B')->get();
    }
}
