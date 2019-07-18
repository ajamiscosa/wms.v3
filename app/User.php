<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Traits\RecordSignature as Signature;

class User extends Authenticatable
{
    use Notifiable;
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
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'Username', 'Password', 'Person', 'Status', 'Department', 'Roles'
    ];
	
    public function Person() {
        try {
            $result = $this->hasOne('App\Person', 'ID', 'Person')->firstOrFail();
            $person = new Person();
            $person = $person->where('ID','=',$result->ID)->firstOrFail();
            return $person;
        }catch(\Exception $exception) {
            return null;
        }
    }

    public function Department() {
        return $this->belongsTo('App\Department', 'Department', 'ID')->first();
    }

    public function Roles($intArray = 0) {
        $roles = array();
        if($intArray) {
            foreach(json_decode($this->Roles) as $role) {
                $role = Role::where('ID','=',$role)->first()->ID;
                array_push($roles, $role);
            }
        } else {
            foreach(json_decode($this->Roles) as $role) {
                $role = Role::where('ID','=',$role)->first();
                array_push($roles, $role);
            }
        }

        return $roles;
    }

    public function Permissions() {
        $permissions = array();
        foreach($this->Roles() as $role) {
            foreach(json_decode($role->Permissions) as $permission) {
                $permission = Permission::where('ID','=',$permission)->first();
                array_push($permissions, $permission);
            }
        }

        return $permissions;
    }

    public function isAuthorized($module, $action){
        $permissions = array();
        foreach($this->Roles() as $role) {
            foreach(json_decode($role->Permissions) as $permission) {
                array_push($permissions, $permission);
            }
        }

        $p = Permission::where([
            ['Module','=',$module],
            ['Permission','=',$action]
        ])->first();

        return in_array($p->ID, $permissions);
    }

    public function isAdministrator() {
        $role = new Role();
        $role = $role->where('Name','=','Administrator')->first();
        return in_array($role->ID, $this->Roles(1));
    }

    public function isPurchasingManager() {
        $role = new Role();
        $role = $role->where('Name','=','PurchasingManager')->first();
        return in_array($role->ID, $this->Roles(1));
    }

    public function isPlantManager() {
        $role = new Role();
        $role = $role->where('Name','=','PlantManager')->first();
        return in_array($role->ID, $this->Roles(1));
    }

    public function isOperationsDirector() {
        $role = new Role();
        $role = $role->where('Name','=','OperationsDirector')->first();
        return in_array($role->ID, $this->Roles(1));
    }

    public function isGeneralManager() {
        $role = new Role();
        $role = $role->where('Name','=','GeneralManager')->first();
        return in_array($role->ID, $this->Roles(1));
    }

    public function isManager() {
        $role = new Role();
        $role = $role->where('Name','=','Manager')->first();
        return in_array($role->ID, $this->Roles(1));
    }

    public function isSupervisor() {
        $role = new Role();
        $role = $role->where('Name','=','Supervisor')->first();
        return in_array($role->ID, $this->Roles(1));
    }

    public function isPPC() {
        $role = new Role();
        $role = $role->where('Name','=','PPC')->first();
        return in_array($role->ID, $this->Roles(1));
    }

    public function isMaterialsControl() {
        $role = new Role();
        $role = $role->where('Name','=','MaterialsControl')->first();
        return in_array($role->ID, $this->Roles(1));
    }
}
