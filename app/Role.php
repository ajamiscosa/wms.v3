<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\RecordSignature as Signature;

class Role extends Model
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
    protected $table = 'roles';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'Name', 'Permissions'
    ];

    public function Permissions() {
        return $this->hasMany('App\Permission','ID','Permission')->get();
    }

    public static function FindUserWithRole($name) {
        $role = new Role();
        $role = $role->where('Name','=',$name)->first();

        $user = new User();
        $users = $user->where('Status','!=',0)->get();

        foreach($users as $user){
            if(in_array($role->ID, json_decode($user->Roles))) {
                return $user;
            }
        }
    }
}
