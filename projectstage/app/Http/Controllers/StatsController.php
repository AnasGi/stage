<?php

namespace App\Http\Controllers;

use App\Models\Acompte;
use App\Models\Cnss;
use App\Models\Droittimber;
use App\Models\Tvam;
use App\Models\Ir;
use App\Models\Tvat;
use App\Models\Etat;
use App\Models\Irprof;
use App\Models\Bilan;
use App\Models\Cm;
use App\Models\Pv;
use App\Models\Tp;
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
        
        $tvamTable = [];
        $Tvam = Tvam::where('annee' , $annee)->get();
        
        $irTable = [];
        $Ir = Ir::where('annee' , $annee)->get();
        
        $droittimbreTable = [];
        $Droittimber = Droittimber::where('annee' , $annee)->get();

        $acompteTable = [];
        $Acompte = Acompte::where('annee' , $annee)->get();

        $tvatTable = [];
        $Tvat = Tvat::where('annee' , $annee)->get();

        $bilanTable = [];
        $Bilan = Bilan::where('annee' , $annee)->get();

        $others = [];
        $Etat = Etat::where('annee' , $annee)->get();
        $Cm = Cm::where('annee' , $annee)->get();
        $Pv = Pv::where('annee' , $annee)->get();
        $Irprof = Irprof::where('annee' , $annee)->get();
        $Tp = Tp::where('annee' , $annee)->get();

        //cnss
        if($Cnss->count() !== 0){

            for ($i=1; $i < 13; $i++) { 
    
                $nbre = 0;
                $year = $annee;
    
                $month = $i+1;
                if($month >= 13){
                    $month = 1;
                    $year +=1;
                }
    
                $compDate = (new DateTime("first day of {$year}-{$month}"))->modify('+6 days');
    
                foreach ($Cnss as $cnss) { 
    
                    $dateDepot = new DateTime($cnss->{ "date_depot_" .$i });
                    if( $cnss->{ "date_depot_" .$i } != null && ($dateDepot < $compDate) ){
                        $nbre+=1;
                    } 
                }
                
                $pourcentage = number_format((($nbre/$Cnss->count())*100) , 2);
                array_push( $cnssTable , $pourcentage);    

            }     
        }

        //tvam
        if($Tvam->count() !== 0){

            for ($i=1; $i < 13; $i++) { 
        
                $nbre = 0;
                $year = $annee;

                $month = $i+1;
                if($month >= 13){
                    $month = 1;
                    $year +=1;
                }

                $compDate = (new DateTime("last day of {$year}-{$month}"))->modify('-3 days');

                //tvam
                foreach ($Tvam as $tvam) { 

                    $dateDepot = new DateTime($tvam->{ "date_depot_" .$i });
                    if( $tvam->{ "date_depot_" .$i } != null && ($dateDepot < $compDate)  ){
                        $nbre+=1;
                    } 
                }
                $pourcentage = number_format((($nbre/$Tvam->count())*100) , 2);
                array_push( $tvamTable , $pourcentage);   
            }
        } 

        //ir
        if($Ir->count() !== 0){
            for ($i=1; $i < 13; $i++) { 
        
                $nbre = 0;
                $year = $annee;

                $month = $i+1;
                if($month >= 13){
                    $month = 1;
                    $year +=1;
                }

                $compDate = (new DateTime("last day of {$year}-{$month}"))->modify('-3 days');

                foreach ($Ir as $ir) { 
    
                    $dateDepot = new DateTime($ir->{ "date_depot_" .$i });
                    if( $ir->{ "date_depot_" .$i } != null && ($dateDepot < $compDate)  ){
                        $nbre+=1;
                    } 
                }
                $pourcentage = number_format((($nbre/$Ir->count())*100) , 2);
                array_push( $irTable , $pourcentage);  
            }
        }

        //droit de timbre
        if($Droittimber->count() !== 0){
            for ($i=1; $i < 13; $i++) { 
        
                $nbre = 0;
                $year = $annee;

                $month = $i+1;
                if($month >= 13){
                    $month = 1;
                    $year +=1;
                }

                $compDate = (new DateTime("last day of {$year}-{$month}"))->modify('-3 days');

                foreach ($Droittimber as $dt) { 
    
                    $dateDepot = new DateTime($dt->{ "date_depot_" .$i });
                    if( $dt->{ "date_depot_" .$i } != null && ($dateDepot < $compDate)  ){
                        $nbre+=1;
                    } 
                }
                $pourcentage = number_format((($nbre/$Droittimber->count())*100) , 2);
                array_push( $droittimbreTable , $pourcentage);  
            }
        }

        //acompte
        if($Acompte->count() !== 0){

            $month = 3;

            for ($i=1; $i < 6; $i++) { 
        
                $nbre = 0;
                $year = $annee;

                
                if($i == 1){
                    $year += 1;
                }
                elseif($i >= 3){
                    $month += 3;
                }


                $compDate = (new DateTime("last day of {$year}-{$month}"))->modify('-3 days');

                foreach ($Acompte as $acompte) { 
    
                    $dateDepot = new DateTime($acompte->{ "date_depot_" .$i });
                    if( $acompte->{ "date_depot_" .$i } != null && ($dateDepot < $compDate)  ){
                        $nbre+=1;
                    } 
                }
                $pourcentage = number_format((($nbre/$Acompte->count())*100) , 2);
                array_push( $acompteTable , $pourcentage);  
            }
        }

        //tvat
        if($Tvat->count() !== 0){

            $month = 4;

            for ($i=1; $i < 5; $i++) { 
        
                $nbre = 0;
                $year = $annee;

                if($i >= 2){
                    $month += 3;
                    if($month >= 12){
                        $month = 1;
                        $year += 1;
                    }
                }


                $compDate = (new DateTime("last day of {$year}-{$month}"))->modify('-3 days');

                foreach ($Tvat as $tvat) { 
    
                    $dateDepot = new DateTime($tvat->{ "date_depot_" .$i });
                    if( $tvat->{ "date_depot_" .$i } != null && ($dateDepot < $compDate)  ){
                        $nbre+=1;
                    } 
                }
                $pourcentage = number_format((($nbre/$Tvat->count())*100) , 2);
                array_push( $tvatTable , $pourcentage);  
            }
        }
        
        $year = $annee+1;
        if($Etat->count() !== 0){
            $nbre = 0;
            $month = 2;
            $compDate = (new DateTime("last day of {$year}-{$month}"))->modify('-3 days');
            foreach($Etat as $etat){
                $dateDepot = new DateTime($etat->date_depot);
                if($etat->date_depot != null && ($dateDepot < $compDate)){
                    $nbre+=1;
                }
            }
            $pourcentage = number_format((($nbre/$Etat->count())*100) , 2);
            array_push($others , $pourcentage);
        }
        if($Tp->count() !== 0 || $Cm->count() !== 0){
            $nbre = 0;
            $month = 1;
            $compDate = (new DateTime("last day of {$year}-{$month}"))->modify('-3 days');

            foreach($Tp as $tp){
                $dateDepot = new DateTime($tp->date_depot);
                if($tp->date_depot != null && ($dateDepot < $compDate)){
                    $nbre+=1;
                }
            }
            $pourcentage = number_format((($nbre/$Tp->count())*100) , 2);
            array_push($others , $pourcentage);

            foreach($Cm as $cm){
                $dateDepot = new DateTime($cm->date_depot);
                if($tp->date_depot != null && ($dateDepot < $compDate)){
                    $nbre+=1;
                }
            }
            $pourcentage = number_format((($nbre/$Cm->count())*100) , 2);
            array_push($others , $pourcentage);
        }
        if($Irprof->count() !== 0){
            $nbre = 0;
            $month = 4;
            $compDate = (new DateTime("last day of {$year}-{$month}"))->modify('-3 days');
            foreach($Irprof as $irprof){
                $dateDepot = new DateTime($irprof->date_depot);
                if($irprof->date_depot != null && ($dateDepot < $compDate)){
                    $nbre+=1;
                }
            }
            $pourcentage = number_format((($nbre/$Irprof->count())*100) , 2);
            array_push($others , $pourcentage);
        }
        if($Pv->count() !== 0){
            $nbre = 0;
            $month = 7;
            $compDate = (new DateTime("last day of {$year}-{$month}"))->modify('-3 days');
            foreach($Pv as $pv){
                $dateDepot = new DateTime($pv->date_depot);
                if($pv->date_depot != null && ($dateDepot < $compDate)){
                    $nbre+=1;
                }
            }
            $pourcentage = number_format((($nbre/$Pv->count())*100) , 2);
            array_push($others , $pourcentage);
        }
        if($Bilan->count() !== 0){
            $nbreP = 0;
            $totalP = 0;
            $nbreM = 0;
            $totalM = 0;

            foreach($Bilan as $bilan){
                if (str_ends_with($bilan->clients->status , 'Morale')) {
                    $month = 3;    
                }
                elseif (str_ends_with($bilan->clients->status , 'Physique')){
                    $month = 4;
                }
                $compDate = (new DateTime("last day of {$year}-{$month}"))->modify('-3 days');
                $dateDepot = new DateTime($bilan->date_depot);
                
                if($bilan->date_depot != null){
                    if($month == 3){
                        $totalM+=1;
                        if(($dateDepot < $compDate)){
                            $nbreM+=1;
                        }
                    }
                    else {
                        $totalP+=1;
                        if(($dateDepot < $compDate)){
                            $nbreP+=1;
                        }
                    }
                }
            }

            if($totalM == 0){
                $totalM = 1;
            }
            elseif($totalP == 0){
                $totalP = 1;
            }

            $pourcentageM = number_format(($nbreM/$totalM)*100 , 2);
            $pourcentageP = number_format(($nbreP/$totalP)*100 , 2);

            array_push($bilanTable , $pourcentageP , $pourcentageM);
        }



        return view('stats' , [
            'Tvam'=>$tvamTable ?? null,
            'Cnss'=>$cnssTable ?? null,
            'Ir'=>$irTable ?? null,
            'Droittimber'=>$droittimbreTable ?? null,
            'Acompte'=>$acompteTable ?? null,
            'Tvat'=>$tvatTable ?? null,
            'others'=>$others??null,
            'Bilan'=>$bilanTable ?? null,
        ]);
    }
}
