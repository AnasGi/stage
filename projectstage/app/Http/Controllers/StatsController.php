<?php

namespace App\Http\Controllers;

use App\Models\Cnss;
use App\Models\Tvam;
use Date;
use DateTime;
use Illuminate\Http\Request;

class StatsController extends Controller
{
    public function index(Request $request){

        $annee = Date("Y");
        if($request->input('annee')){
            $annee = $request->input('annee');
        }

        $cnssTable = [];
        $Cnss = Cnss::where('annee' , $annee)->get();
        
        // $tvamTable = [];
        // $Tvam = Tvam::where('annee' , $annee)->get();

        
        for ($i=1; $i < 13; $i++) { 

            $nbre = 0;

            $month = $i+1;
            if($month >= 13){
                $month = 1;
                $annee +=1;
            }

            $compDate = (new DateTime("first day of {$annee}-{$month}"))->modify('+6 days');

            for ($j=0; $j < $Cnss->count() ; $j++) { 

                $dateDepot = new DateTime($Cnss[$j]->{ "date_depot_" .$i });
                if( $Cnss[$j]->{ "date_depot_" .$i } != null && ($dateDepot < $compDate)  ){
                    $nbre+=1;
                } 
            }
            
            $pourcentage = number_format((($nbre/$Cnss->count())*100) , 2);
            array_push( $cnssTable , $pourcentage);     
        }     


        return view('stats' , [
            // 'Tvam'=>$Tvam ?? null,
            'Cnss'=>$cnssTable ?? null,
            // 'Ir'=>$Ir ?? null,
            // 'Droittimber'=>$Droittimber ?? null,
            // 'Acompte'=>$Acompte ?? null,
            // 'Tvat'=>$Tvat ?? null,
            // 'Tp'=>$Tp ?? null,
            // 'Etat'=>$Etat ?? null,
            // 'Bilan'=>$Bilan ?? null,
            // 'Irprof'=>$Irprof ?? null,
            // 'Cm'=>$Cm ?? null,
            // 'Pv'=>$Pv ?? null,
        ]);
    }
}
