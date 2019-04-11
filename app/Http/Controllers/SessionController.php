<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SessionController extends Controller
{
    public static function addToList(Request $request) {
        $sessionListItems = $request->session()->get($request->variable);
        if(isset($sessionListItems)){
            if(!in_array($request->value, $sessionListItems)) {
                $request->session()->push($request->variable, $request->value);
            }
        } else {
            $request->session()->push($request->variable, $request->value);
        }
    }

    public static function removeFromList(Request $request) {
        $sessionListItems = $request->session()->get($request->variable);
        if(isset($sessionListItems)){
            if(!in_array($request->value, $sessionListItems)) {
                $request->session()->pull($request->variable, $request->value);
            }
        } else {
            $request->session()->pull($request->variable, $request->value);
        }
    }
}
