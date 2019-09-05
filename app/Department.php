<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\RecordSignature as Signature;

class Department extends Model
{
    use Signature;
    
    private $generalLedger;
    private $person;
    private $department;
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
    protected $table = 'departments';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'Code','Name', 'Manager', 'Approvers', 'Parent', 'GL', 'Legacy', 'Status'
    ];
	
    public function getGeneralLedgerCodes($type) {
        $this->generalLedger = new GeneralLedger();
        $glCode = $this->GL < 10 ? str_pad($this->GL, 2, '0', STR_PAD_LEFT) : $this->GL;
        $gl = $this->generalLedger
            ->where('Code','like',sprintf('%%-%s-%%', $glCode))
            ->where('Type','=',$type)->get();
        return $gl;
    }

    public function Users() {
        return $this->hasMany('App\User','Department','ID')->get();
    }

    public function Manager() {
        return $this->hasOne('App\User','ID','Manager')->first();
    }

    public function Approvers() {
        $this->person = new Person();

        $data = array();
        $approvers = json_decode($this->Approvers);
        foreach($approvers as $approver) {
            $person = $this->person->where('ID','=',$approver)->first();
            array_push($data, $person);
        }
        return $data;
    }

    public function ApproverIDs() {
        $this->person = new Person();

        $data = array();
        $approvers = json_decode($this->Approvers);
        foreach($approvers as $approver) {
            $person = $this->person->where('ID','=',$approver)->first();
            array_push($data, $person->ID);
        }
        return $data;
    }

    public function ParentDepartment() {
        $this->department = new Department();
        return $this->department->where('ID','=',$this->Parent)->first();
    }

    public function GLCode() {
        $this->generalLedger = new GeneralLedger();
        return $this->generalLedger->where('ID','=',$this->GL)->first();
    }

    public static function findByName($name) {
        $department = new Department();
        $department = $department->where('Name','=',$name)->firstOrFail();
        return $department;
    }

    public static function findByID($id) {
        $department = new Department();
        $department = $department->where('ID','=',$id)->firstOrFail();
        return $department;
    }
}
