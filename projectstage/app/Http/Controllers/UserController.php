<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('login');
    }

    public function login(Request $request){
        if(Auth::attempt(['name'=>$request->collaborateur , 'password'=>$request->password])){
            $request->session()->regenerate();
            return redirect('/');
        }
        else{
            return back()->withErrors([
                'error'=> 'somthing wrong'
            ])->onlyInput('name');
        }
    }
}
