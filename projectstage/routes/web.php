<?php

use App\Http\Controllers\AcompteController;
use App\Http\Controllers\BilanController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CmController;
use App\Http\Controllers\CnssController;
use App\Http\Controllers\DroittimberController;
use App\Http\Controllers\EtatController;
use App\Http\Controllers\IrController;
use App\Http\Controllers\IrprofController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\PvController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\TpController;
use App\Http\Controllers\TvamController;
use App\Http\Controllers\TvatController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware(['guest'])->group(function () {
    // Login
    Route::get('/Authentification', [UserController::class, 'index']);
    Route::post('/Authentification', [UserController::class, 'login'])->name('login');
});

Route::middleware(['auth'])->group(function () {
    
    // Main page
    Route::get('/', function () {
        return view('acceuil');
    });

    // signup
    Route::get('/nouvel-responsable' , [RegisterController::class , 'index'])->name('register.form');
    Route::post('/nouvel-responsable' , [RegisterController::class , 'register'])->name('register');
    
    // Clients
    Route::get('/clients', [ClientController::class, 'index'])->name('clients.index');
    Route::post('/clients/import-clients', [ClientController::class, 'import'])->name('clients.import');

    // CNSS
    Route::get('/cnss', [CnssController::class, 'index'])->name('cnss.index');
    Route::post('/cnss/import-cnss', [CnssController::class, 'import'])->name('cnss.import');

    // TVA Mensuelle
    Route::get('/Tva_mensuelle', [TvamController::class, 'index'])->name('tvam.index');
    Route::post('/Tva_mensuelle/import-tvam', [TvamController::class, 'import'])->name('tvam.import');

    // TVA Trimestrielle
    Route::get('/Tva_trimistrielle', [TvatController::class, 'index'])->name('tvat.index');
    Route::post('/Tva_trimistrielle/import-tvat', [TvatController::class, 'import'])->name('tvat.import');

    // IR
    Route::get('/ir', [IrController::class, 'index'])->name('ir.index');
    Route::post('/ir/import-ir', [IrController::class, 'import'])->name('ir.import');

    // Droit Timber
    Route::get('/droittimbre', [DroittimberController::class, 'index'])->name('droittimbre.index');
    Route::post('/droittimbre/import-droittimber', [DroittimberController::class, 'import'])->name('droittimbre.import');

    // Acompte
    Route::get('/acompte', [AcompteController::class, 'index'])->name('acompte.index');
    Route::post('/acompte/import-acompte', [AcompteController::class, 'import'])->name('acompte.import');

    // Etat
    Route::get('/etat', [EtatController::class, 'index'])->name('etat.index');
    Route::post('/etat/import-etat', [EtatController::class, 'import'])->name('etat.import');

    // tp
    Route::get('/tp', [TpController::class, 'index'])->name('tp.index');
    Route::post('/tp/import-tp', [TpController::class, 'import'])->name('tp.import');

    // Bilan
    Route::get('/bilan', [BilanController::class, 'index'])->name('bilan.index');
    Route::post('/bilan/import-bilan', [BilanController::class, 'import'])->name('bilan.import');

    // CM
    Route::get('/cm', [CmController::class, 'index'])->name('cm.index');
    Route::post('/cm/import-cm', [CmController::class, 'import'])->name('cm.import');

     // pv
     Route::get('/pv', [PvController::class, 'index'])->name('pv.index');
     Route::post('/pv/import-pv', [PvController::class, 'import'])->name('pv.import');

    // irprof
    Route::get('/irprof', [IrprofController::class, 'index'])->name('irprof.index');
    Route::post('/irprof/import-irprof', [IrprofController::class, 'import'])->name('irprof.import');


    // Logout
    Route::post('logging-out', [LogoutController::class, 'logout'])->name('logout');
});
