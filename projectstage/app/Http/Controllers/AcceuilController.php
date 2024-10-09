<?php

namespace App\Http\Controllers;

use App\Models\Acompte;
use App\Models\Client;
use App\Models\Cnss;
use App\Models\Droittimber;
use App\Models\Etat;
use App\Models\Ir;
use App\Models\Cm;
use App\Models\Irprof;
use App\Models\Bilan;
use App\Models\Tp;
use App\Models\Tvam;
use App\Models\Tvat;
use App\Models\User;
use Auth;
use Date;
use Illuminate\Http\Request;

class AcceuilController extends Controller
{
    public function index(Request $request){
        if (Auth::user()->role == 'Admin') {
            $clients = Client::all();
        } else {
            $clients = Client::where('users_id' , Auth::user()->id)->get();
        }

        $clientToFind = $request->input('code');

        if($request->input('annee')){
            $annee = $request->input('annee');
        }
        else{
            $annee = Date('Y');
        }

        if($clientToFind){

            $clientId = Client::where('code' , $request->input('code'))->value('id');

            $userId = Client::where('code' , $clientId)->value('users_id');
            $userName = User::where('id' , $userId)->value('name');

            $Tvam = Tvam::where('clients_id' , $clientId)->where('annee' , $annee)->first();
            $Cnss = Cnss::where('clients_id' , $clientId)->where('annee' , $annee)->first();
            $Ir = Ir::where('clients_id' , $clientId)->where('annee' , $annee)->first();
            $Droittimber = Droittimber::where('clients_id' , $clientId)->where('annee' , $annee)->first();
            $Acompte = Acompte::where('clients_id' , $clientId)->where('annee' , $annee)->first();
            $Tvat = Tvat::where('clients_id' , $clientId)->where('annee' , $annee)->first();
            $Etat = Etat::where('clients_id' , $clientId)->where('annee' , $annee)->first();
            $Cm = Cm::where('clients_id' , $clientId)->where('annee' , $annee)->first();
            $Bilan = Bilan::where('clients_id' , $clientId)->where('annee' , $annee)->first();
            $Irprof = Irprof::where('clients_id' , $clientId)->where('annee' , $annee)->first();
            $Tp = Tp::where('clients_id' , $clientId)->where('annee' , $annee)->first();

        }

        return view('acceuil' , compact('clients' ) + [
            'clientToFind'=>$clientToFind ?? null,
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
            'userName'=>$userName ?? null
        ]);
    }
}
