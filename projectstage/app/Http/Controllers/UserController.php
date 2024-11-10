<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\History;
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
        if(Auth::attempt(['name'=>$request->name , 'password'=>$request->password])){
            $loggedUser = User::where('name' , Auth::user()->name);
            $loggedUser->update([
                'active'=>true,
            ]);
            $request->session()->regenerate();
            return redirect('/clients');
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

        $validated = $request->validate([
            "name" => 'min:4|max:30',
            "password" => 'nullable|min:4|max:30',
        ]);
        
        $user->update([
            'name' => $validated['name'],
            'password' => $validated['password'] ? Hash::make($validated['password']) : $user->password,
            'passwordText' => $validated['password'] ? $validated['password'] : $user->password
        ]);
        
        return back()->with('userMod' , 'Votre coordonnées a été modifier');

    }

    public function show(Request $request){
        $users = User::all();

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
            'selectedClient'=>$selectedClient??null,
        ]);
    }

    public function modify(Request $request){

        $userId = request('user_id');

        $clients = Client::all();

        foreach($clients as $client){
            if($client->users_id == $userId){
                $client->update([
                    'users_id' => $request->input('user')
                ]);
            }
        }

        return redirect()->route('users.show')->with('collabmodified' , 'le collaborateur a été modifier!');
    }

    public function showTable(){
        $clients = Client::all();
        $users = User::withCount('clients')
        ->orderBy('clients_count', 'asc') // or 'asc' for ascending order
        ->get();
    
        $lastUpdate = Client::select('updated_at')->orderBy('updated_at' , 'desc')->first()->value('updated_at');

        return view('showUsersTable' , compact('clients' , 'users')+['lastUpdate'=>$lastUpdate??null]);
    }

    public function delete(User $user){
        $user->delete();

        return back()->with('userDlt' , 'Le collaborateur a été supprimer avec succée!');
    }
    
}
