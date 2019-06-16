<?php

namespace App\Http\Controllers;

use App\Person;
use App\PhonebookEntry;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Validator;
use Psy\Util\Json;

class UserController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     */
    function __construct() {
        $this->middleware('auth')->except('login','androidlogin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return view('settings.accounts.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('settings.accounts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $person = new Person();
        $person->LastName = $request->LastName;
        $person->FirstName = $request->FirstName;
        $person->Position = $request->Position;
        $person->Email = $request->Email;
        $person->Gender = $request->Gender;
        $person->Birthday = Carbon::parse($request->Birthday);
        $person->ContactNumber = $request->ContactNumber;

        if($request->ImageFile!=null) {
            $person->ImageFile = $request->Username . "." . $request->ImageFile->extension();

            $imgfile = $request->ImageFile;
            Storage::putFileAs('/public/images/', $imgfile, $person->ImageFile);

        } else {
            $person->ImageFile = "{}";
        }

        $person->save();

        $user = new User();
        $user->Username = $request->Username;
        $user->Password = $request->Password;
        $user->Person = $person->ID;
        $user->Status = 1;
        $roleArray = json_decode('['.implode(',',$request->Role).']',true);
        $user->Roles = json_encode($roleArray);
        $user->save();

        return redirect()->to('/account/view/'.$user->Username);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $account
     * @return \Illuminate\Http\Response
     */
    public function show($account) {
        $user = new User();
        $account = $user->where('Username','=', $account)->first();
        return view('settings.accounts.view', ['data'=>$account]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $account
     * @return \Illuminate\Http\Response
     */
    public function edit($account) {
        $user = new User();
        $account = $user->where('Username','=', $account)->first();
        return view('settings.accounts.update', ['data'=>$account]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $account
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $account) {
        $user = User::where('Username','=', $account)->first();
        $person = Person::where('ID','=', $user->Person()->ID)->first();
        $person->LastName = $request->LastName;
        $person->FirstName = $request->FirstName;
        $person->Position = $request->Position;
        $person->Email = $request->Email;
        $person->Gender = $request->Gender;
        $person->Birthday = Carbon::createFromFormat('M d, Y',$request->Birthday);
        $person->ContactNumber = $request->ContactNumber?$request->ContactNumber:"N/A";

        if($request->ImageFile!=null) {
            $person->ImageFile = $request->Username . "." . $request->ImageFile->extension();

            $imgfile = $request->ImageFile;
            Storage::putFileAs('/public/images/', $imgfile, $person->ImageFile);

        } else {
            // retain.
        }

        $person->save();
        $temp = json_decode('['.implode(',',$request->Role).']',true);
        $approvers = json_encode($temp);
        $user->Roles = $approvers;
        $user->save();

        return redirect()->to("/account/view/$user->Username");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $account
     * @return \Illuminate\Http\Response
     */
    public function toggle(Request $request, $account) {
        $account = User::where('Username','=', $account)->first();
        $account->Status = !$account->Status;
        $account->save();

        return redirect()->to("/account/view/$account->Username");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $account
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $account) {
        //
    }

    /**
     * Fetches all available data.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Json
     */
    public function data(Request $request) {
        $data = array();
        $user = new User();
        $users = $user->all();
        foreach($users as $user) {
            $entry = array();

            $title = "";
            foreach($user->Roles() as $role) {
                $title .= $role->Name;
                $title .= " | ";
            }
            $title = trim($title,' | ');

            $entry['Username'] = $user->Username;
            $entry['Name'] = $user->Person()->Name();
            $entry['Title'] = $title;

            array_push($data, $entry);
        }
        return response()->json(['aaData'=>$data]);
    }

    public function login(Request $request) {
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'Username'=>'required|min:3',
            'Password'=>'required|min:4'
        ],
            [
                'Username.required'=>'Username is Required',
                'Username.min'=>'Username should be at least 3 characters.',
                'Password.required'=>'Password is Required',
                'Password.min'=>'Password should be at least 7 characters.'
            ]
        );

        if($validator->passes()){
            $credentials = $request->only('Username', 'Password');

            $user = $credentials['Username'];
            $pass = $credentials['Password'];

            $account = User::where('Username','=',$user)->first();

            if($account) {
                if($account->Password == $pass) {
                    Auth::login($account);
                    // if(session('link')) {
                    //     return redirect(session('link'));
                    // }
                    return redirect()->to('/');
                }
                else {
                    $validator->errors()->add('Password', 'Password is Incorrect');
                    return redirect()->back()->withErrors($validator);
                }
            }
            else {
                $validator->errors()->add('Username', 'User does not exist');
                return redirect()->back()->withErrors($validator);
            }
        }
        else {
            return redirect()->back()->withErrors($validator);
        }
    }

    public function androidlogin(Request $request) {
        $credentials = $request->only('Username', 'Password');

        $user = $credentials['Username'];
        $pass = $credentials['Password'];

        $account = User::where('Username','=',$user)->first();
        $status = "";
        $message = "";
        if($account) {
            if($account->Password == $pass) {
                Auth::login($account);
                $status = "success";
                $message = "ok";
            }
            else {
                $status = "failed";
                $message = "Incorrect Password";
            }
        }
        else {
            $status = "failed";
            $message = "Account doesn't exist.";
        }

        return response()->json(['status'=>$status, 'message'=>$message]);
    }

    public function changepw(Request $request) {
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'CurrentPassword'=>'required|min:4',
            'NewPassword'=>'required|min:4|confirmed'
        ],
            [
                'CurrentPassword.required'=>'Current Password is Required',
                'CurrentPassword.min'=>'Current Password should be at least 4 characters.',
                'NewPassword.required'=>'New Password is Required',
                'NewPassword.min'=>'New Password should be at least 4 characters.',
                'NewPassword.confirm'=>'New Passwords should match.',
            ]
        );

        $user = auth()->user();
        if($user->Password != $request->CurrentPassword) {
            $validator->errors()->add('CurrentPassword', 'Incorrect current password.');
            return redirect()->back()->withErrors($validator);
        } else {
            $user->Password = $request->NewPassword;
            $user->save();
            return redirect()->back()->with('message', 'Password successfully changed.');
        }
    }
}
