<?php

namespace App\Http\Controllers;

use App\Contact;
use App\Person;
use App\PhonebookEntry;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PersonController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('accounts.persons.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('accounts.persons.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $person = new Person();
        $person->LastName = $request->LastName;
        $person->FirstName = $request->FirstName;
        $person->MiddleName = $request->MiddleName;
        $person->Position = $request->Position;
        $person->Email = $request->EmailAddress;
        $person->Gender = $request->Gender;
        $person->Birthday = Carbon::create(1900, 01, 01);
        $person->ImageFile = "{}";
        $person->save();

        if(isset($request->Accounts)) {
            foreach($request->Accounts as $account) {
                $account = Contact::where('ID','=',$account)->first();
                $contactPersons = json_decode($account->ContactPersons);
                if(!in_array($person->ID, $contactPersons)) {
                    array_push($contactPersons, $person->ID);
                }
                $personArray = json_decode('['.implode(',',$contactPersons).']',true);
                $account->ContactPersons = json_encode($personArray);
                $account->save();
            }

        }

        if(count($request->ContactNumber)>0) {
            foreach($request->ContactNumber as $number){
                if($number!=null) {
                    $contact = new PhonebookEntry();
                    $contact->Type = 'P';
                    $contact->Number = $number;
                    $contact->ReferenceID = $person->ID;
                    $contact->save();
                }
            }
        }

        return redirect()->to('/contact/view/'.$person->ID."-".$person->FirstName."-".$person->LastName);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Person  $person
     * @return \Illuminate\Http\Response
     */
    public function show($person)
    {
        $data = explode('-', $person, 2);
        $person = Person::where('ID','=',$data[0])->first();
        return view('accounts.persons.view', ['data'=>$person]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Person  $person
     * @return \Illuminate\Http\Response
     */
    public function edit($person)
    {
        $data = explode('-', $person, 2);
        $person = Person::where('ID','=',$data[0])->first();
        return view('accounts.persons.update', ['data'=>$person]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Person  $person
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $person)
    {

        $data = explode('-', $person, 2);
        $person = Person::where('ID','=',$data[0])->first();
        $person->LastName = $request->LastName;
        $person->FirstName = $request->FirstName;
        $person->MiddleName = $request->MiddleName;
        $person->Position = $request->Position;
        $person->Email = $request->EmailAddress;
        $person->Gender = $request->Gender;
        $person->Birthday = Carbon::create(1900, 01, 01);
        $person->ImageFile = "{}";
        $person->save();

        PhonebookEntry::where([
            ['ReferenceID','=',$person->ID],
            ['Type','=','P']
        ])->delete();


        if(count($request->ContactNumber)>0) {
            foreach($request->ContactNumber as $number){
                if($number!=null) {
                    $contact = new PhonebookEntry();
                    $contact->Type = 'P';
                    $contact->Number = $number;
                    $contact->ReferenceID = $person->ID;
                    $contact->save();
                }
            }
        }

        return redirect()->to('/contact/view/'.$person->ID."-".$person->FirstName."-".$person->LastName);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Person  $person
     * @return \Illuminate\Http\Response
     */
    public function destroy(Person $person)
    {
        //
    }

    /**
     * Fetches all available data.
     *
     * @param  \App\Person  $contact
     * @param  \Illuminate\Http\Request  $request
     * @return Json
     */
    public function data(Request $request)
    {
        $data = array();
        foreach(Person::companyContacts() as $person) {
            $entry = array();
            $entry['ID'] = $person->ID;
            $entry['FirstName'] = $person->FirstName;
            $entry['LastName'] = $person->LastName;
            $entry['Position'] = $person->Position;
            $entry['ContactNumber'] = $person->ContactNumber();
            $entry['Email'] = $person->Email;

            array_push($data, $entry);
        }
        return response()->json(['aaData'=>$data]);
    }
}
