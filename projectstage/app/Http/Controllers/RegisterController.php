<?php

namespace App\Http\Controllers;

use App\Models\User;
use Hash;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function index(){
        return view('register');
    }

    public function register(Request $request){
        $validateInfo = $request->validate([
            'name'=>'required|max:50|string',
            'password'=>'required|string',
            'role'=>'required',
        ]);

        $user = User::create([
            'name'=>$request->input('name'),
            'password'=>Hash::make($request->input('password')),
            'passwordText'=>$request->input('password'),
            'role'=>$request->input('role')
        ]);

        return back()->with('newUser' , 'Le nouvel utilisateur a été creer avec succer');
    }
}
