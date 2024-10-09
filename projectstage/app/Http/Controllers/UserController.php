<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Pv;
use App\Models\User;
use App\Models\Cnss;
use App\Models\Ir;
use App\Models\Bilan;
use App\Models\Irprof;
use App\Models\Tp;
use App\Models\Cm;
use App\Models\Acompte;
use App\Models\Tvat;
use App\Models\Tvam;
use App\Models\Droittimber;
use App\Models\Etat;
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

    public function show(Request $request){
        $users = User::where('role' , 'Responsable')->get();

        $clients = Client::all();

        $clientId = $request->query('id');

        $selectedClient = Client::find($clientId);

        if($clientId){
    
            $Tvam = Tvam::where('clients_id' , $clientId)->where('annee' , Date('Y'))->get();
            $Cnss = Cnss::where('clients_id' , $clientId)->where('annee' , Date('Y'))->get();
            $Ir = Ir::where('clients_id' , $clientId)->where('annee' , Date('Y'))->get();
            $Droittimber = Droittimber::where('clients_id' , $clientId)->where('annee' , Date('Y'))->get();
            $Acompte = Acompte::where('clients_id' , $clientId)->where('annee' , Date('Y'))->get();
            $Tvat = Tvat::where('clients_id' , $clientId)->where('annee' , Date('Y'))->get();
            $Etat = Etat::where('clients_id' , $clientId)->where('annee' , Date('Y'))->get();
            $Cm = Cm::where('clients_id' , $clientId)->where('annee' , Date('Y'))->get();
            $Bilan = Bilan::where('clients_id' , $clientId)->where('annee' , Date('Y'))->get();
            $Irprof = Irprof::where('clients_id' , $clientId)->where('annee' , Date('Y'))->get();
            $Tp = Tp::where('clients_id' , $clientId)->where('annee' , Date('Y'))->get();
            $Pv = Pv::where('clients_id' , $clientId)->where('annee' , Date('Y'))->get();

        }

        return view('showUsers' , compact('users') + [
            'clients'=>$clients ?? null,
            'Tvam'=>$Tvam ?? null,
            'Cnss'=>$Cnss ?? null,
            'Ir'=>$Ir ?? null,
            'Droittimber'=>$Droittimber ?? null,
            'Acompte'=>$Acompte ?? null,
            'Tvat'=>$Tvat ?? null,
            'Tp'=>$Tp ?? null,
            'Etat'=>$Etat ?? null,
            'Bilan'=>$Bilan ?? null,
            'Irprof'=>$Irprof ?? null,
            'Cm'=>$Cm ?? null,
            'Pv'=>$Pv ?? null,
            'id'=>$request->query('id') ?? null,
            'selectedClient'=>$selectedClient??null
        ]);
    }

    public function delete(User $user){
        $user->delete();

        return back()->with('userDlt' , 'Le collaborateur a été supprimer avec succée!');
    }
    
}
