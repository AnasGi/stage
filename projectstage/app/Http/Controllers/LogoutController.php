<?php

namespace App\Http\Controllers;

use App\Models\User;
use Auth;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    public function logout(Request $request){
        $loggedUser = User::where('name' , Auth::user()->name);
        $loggedUser->update([
            'active'=>false,
            'loggedout_at'=>Date('d/m/Y H:i')
        ]);
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/Authentification');
    }
}
