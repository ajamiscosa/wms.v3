<?php

namespace App\Http\Controllers;

use App\Contact;
use App\PhonebookEntry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Psy\Util\Json;

class ContactController extends Controller
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
        return view('accounts.stakeholders.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('accounts.stakeholders.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $contact = new Contact();
        $contact->Name = $request->Name;
        $contact->Address = $request->Address;
        $contact->Email = $request->EmailAddress;
        $contact->Website = $request->Website;
        $contact->TIN = $request->TIN;
        $contact->CreditLimit = $request->CreditLimit;
        $contact->PaymentTerm = $request->PaymentTerm;
        $contact->Type = count($request->Type)>1?'B':$request->Type[0];
        $contact->ContactPersons = json_encode($request->ContactPerson);
        $contact->save();

        if(count($request->ContactNumber)>0) {
            foreach($request->ContactNumber as $number){
                if($number!=null) {
                    $entry = new PhonebookEntry();
                    $entry->Type = 'C';
                    $entry->Number = $number;
                    $entry->ReferenceID = $contact->ID;
                    $entry->save();
                }
            }
        }

        $name = explode(' ', $request->Name);
        $name = implode('-',$name);
        return redirect()->to('/stakeholder/view/'.$contact->ID."-".$name);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Contact  $stakeholder
     * @return \Illuminate\Http\Response
     */
    public function show($stakeholder)
    {
        $data = explode('-', $stakeholder, 2);
        $stakeholder = Contact::where('ID','=',$data[0])->first();
        return view('accounts.stakeholders.view', ['data'=>$stakeholder]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function edit($stakeholder)
    {
        $data = explode('-', $stakeholder, 2);
        $stakeholder = Contact::where('ID','=',$data[0])->first();
        return view('accounts.stakeholders.update', ['data'=>$stakeholder]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $stakeholder)
    {
        $data = explode('-', $stakeholder, 2);
        $stakeholder = Contact::where('ID','=',$data[0])->first();

        $stakeholder->Name = $request->Name;
        $stakeholder->Address = $request->Address;
        $stakeholder->Email = $request->EmailAddress;
        $stakeholder->Website = $request->Website;
        $stakeholder->TIN = $request->TIN;
        $stakeholder->CreditLimit = $request->CreditLimit;
        $stakeholder->PaymentTerm = $request->PaymentTerm;
        $stakeholder->Type = count($request->Type)>1?'B':$request->Type[0];
        $stakeholder->ContactPersons = json_encode($request->ContactPerson);
        $stakeholder->save();

        PhonebookEntry::where([
            ['ReferenceID','=',$stakeholder->ID],
            ['Type','=','C']
        ])->delete();

        if(count($request->ContactNumber)>0) {
            foreach($request->ContactNumber as $number){
                if($number!=null) {
                    $contact = new PhonebookEntry();
                    $contact->Type = 'C';
                    $contact->Number = $number;
                    $contact->ReferenceID = $stakeholder->ID;
                    $contact->save();
                }
            }
        }

        $name = explode(' ', $stakeholder->Name);
        $name = implode('-',$name);
        return redirect()->to('/stakeholder/view/'.$stakeholder->ID."-".$name);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contact $contact)
    {
        //
    }

    /**
     * Fetches all available data.
     *
     * @param  \App\Contact  $contact
     * @param  \Illuminate\Http\Request  $request
     * @return Json
     */
    public function data(Request $request)
    {
        return response()->json(['aaData'=>Contact::all()]);
    }
}
