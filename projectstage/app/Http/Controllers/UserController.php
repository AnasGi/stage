<?php

namespace App\Http\Controllers;

use App\Models\User;
use Auth;
use Hash;
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
                'error'=> "Le mot de pass ou le nom d'utilisateur est invalide"
            ])->onlyInput('name');
        }
    }

    public function edit(User $user){

        return view('editUser' , compact('user'));
    }

    public function update(Request $request , User $user){

        $valid = $request->validate([
            "name"=>'min:4|max:30',
            "password"=>'min:4|max:30',
        ]);

        $user->update([
            'name'=>$request->input('name'),
            'password'=>Hash::make($request->input('password'))
        ]);

        return back()->with('userMod' , 'Votre coordonnées a été modifier');

    }
    
}
