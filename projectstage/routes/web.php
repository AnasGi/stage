<?php

use App\Http\Controllers\AcompteController;
use App\Http\Controllers\BilanController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CmController;
use App\Http\Controllers\CnssController;
use App\Http\Controllers\DroittimberController;
use App\Http\Controllers\EtatController;
use App\Http\Controllers\IrController;
use App\Http\Controllers\TvamController;
use App\Http\Controllers\TvatController;
use Illuminate\Support\Facades\Route;

//clients
Route::get('/clients' , [ClientController::class , 'index'])->name('clients.index');
Route::post('/clients/import-clients', [ClientController::class, 'import'])->name('clients.import');

//cnss
Route::get('/cnss' , [CnssController::class , 'index'])->name('cnss.index');
Route::post('/cnss/import-cnss', [CnssController::class, 'import'])->name('cnss.import');

//tvam
Route::get('/Tva_mensuelle' , [TvamController::class , 'index'])->name('tvam.index');
Route::post('/Tva_mensuelle/import-tvam', [TvamController::class, 'import'])->name('tvam.import');


//tvat
Route::get('/Tva_trimistrielle' , [TvatController::class , 'index'])->name('tvat.index');
Route::post('/Tva_trimistrielle/import-tvat', [TvatController::class, 'import'])->name('tvat.import');


//ir
Route::get('/ir' , [IrController::class , 'index'])->name('ir.index');
Route::post('/ir/import-ir', [IrController::class, 'import'])->name('ir.import');


//droittimber
Route::get('/droittimber' , [DroittimberController::class , 'index'])->name('droittimber.index');
Route::post('/droittimber/import-droittimber', [DroittimberController::class, 'import'])->name('droittimber.import');


//acompte
Route::get('/acompte' , [AcompteController::class , 'index'])->name('acompte.index');
Route::post('/acompte/import-acompte', [AcompteController::class, 'import'])->name('acompte.import');


//etat
Route::get('/etat' , [EtatController::class , 'index'])->name('etat.index');
Route::post('/etat/import-etat', [EtatController::class, 'import'])->name('etat.import');


//bilan
Route::get('/bilan' , [BilanController::class , 'index'])->name('bilan.index');
Route::post('/bilan/import-bilan', [BilanController::class, 'import'])->name('bilan.import');


//cm
Route::get('/cm' , [CmController::class , 'index'])->name('cm.index');
Route::post('/cm/import-cm', [CmController::class, 'import'])->name('cm.import');
