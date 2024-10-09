<?php

use App\Http\Controllers\AcceuilController;
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
    
    //update user
    Route::get('/modifier-user/{user}' , [UserController::class , 'edit'])->name('user.edit');
    Route::put('/modifier-user/{user}' , [UserController::class , 'update'])->name('user.update');
    
    // signup
    Route::get('/nouvel-responsable' , [RegisterController::class , 'index'])->name('register.form');
    Route::post('/nouvel-responsable' , [RegisterController::class , 'register'])->name('register');

    // Main page
    Route::get('/' , [AcceuilController::class , 'index'])->name('main.index');
    
    // Clients
    Route::get('/clients', [ClientController::class, 'index'])->name('clients.index');
    Route::post('/clients/import-clients', [ClientController::class, 'import'])->name('clients.import');
    Route::post('/clients/ajouter', [ClientController::class, 'store'])->name('clients.store');
    Route::get('/clients/supprimer/{client}', [ClientController::class, 'destroy'])->name('clients.destroy');
    Route::put('/clients/modifier/{client}', [ClientController::class, 'update'])->name('clients.update');
    Route::get('/clients/modifier/{client}', [ClientController::class, 'edit'])->name('clients.edit');

    // CNSS
    Route::get('/cnss', [CnssController::class, 'index'])->name('cnss.index');
    Route::post('/cnss/import-cnss', [CnssController::class, 'import'])->name('cnss.import');
    Route::post('/cnss/ajouter', [CnssController::class, 'store'])->name('cnss.store');
    Route::get('/cnss/supprimer/{cnss}', [CnssController::class, 'destroy'])->name('cnss.destroy');
    Route::put('/cnss/modifier/{cnss}', [CnssController::class, 'update'])->name('cnss.update');
    Route::get('/cnss/modifier/{cnss}', [CnssController::class, 'edit'])->name('cnss.edit');

    // TVA Mensuelle
    Route::get('/Tva_mensuelle', [TvamController::class, 'index'])->name('tvam.index');
    Route::post('/Tva_mensuelle/import-tvam', [TvamController::class, 'import'])->name('tvam.import');
    Route::post('/Tva_mensuelle/ajouter', [TvamController::class, 'store'])->name('tvam.store');
    Route::get('/Tva_mensuelle/supprimer/{tvam}', [TvamController::class, 'destroy'])->name('tvam.destroy');
    Route::put('/Tva_mensuelle/modifier/{tvam}', [TvamController::class, 'update'])->name('tvam.update');
    Route::get('/Tva_mensuelle/modifier/{tvam}', [TvamController::class, 'edit'])->name('tvam.edit');

    // TVA Trimestrielle
    Route::get('/Tva_trimistrielle', [TvatController::class, 'index'])->name('tvat.index');
    Route::post('/Tva_trimistrielle/import-tvat', [TvatController::class, 'import'])->name('tvat.import');
    Route::post('/Tva_trimistrielle/ajouter', [TvatController::class, 'store'])->name('tvat.store');
    Route::get('/Tva_trimistrielle/supprimer/{tvat}', [TvatController::class, 'destroy'])->name('tvat.destroy');
    Route::put('/Tva_trimistrielle/modifier/{tvat}', [TvatController::class, 'update'])->name('tvat.update');
    Route::get('/Tva_trimistrielle/modifier/{tvat}', [TvatController::class, 'edit'])->name('tvat.edit');

    // IR
    Route::get('/ir', [IrController::class, 'index'])->name('ir.index');
    Route::post('/ir/import-ir', [IrController::class, 'import'])->name('ir.import');
    Route::post('/ir/ajouter', [IrController::class, 'store'])->name('ir.store');
    Route::get('/ir/supprimer/{ir}', [IrController::class, 'destroy'])->name('ir.destroy');
    Route::put('/ir/modifier/{ir}', [IrController::class, 'update'])->name('ir.update');
    Route::get('/ir/modifier/{ir}', [IrController::class, 'edit'])->name('ir.edit');

    // Droit Timber
    Route::get('/droittimbre', [DroittimberController::class, 'index'])->name('droittimbre.index');
    Route::post('/droittimbre/import-droittimber', [DroittimberController::class, 'import'])->name('droittimbre.import');
    Route::post('/droittimbre/ajouter', [DroittimberController::class, 'store'])->name('droittimbre.store');
    Route::get('/droittimbre/supprimer/{Droittimber}', [DroittimberController::class, 'destroy'])->name('droittimbre.destroy');
    Route::put('/droittimbre/modifier/{Droittimber}', [DroittimberController::class, 'update'])->name('droittimbre.update');
    Route::get('/droittimbre/modifier/{Droittimber}', [DroittimberController::class, 'edit'])->name('droittimbre.edit');

    // Acompte
    Route::get('/acompte', [AcompteController::class, 'index'])->name('acompte.index');
    Route::post('/acompte/import-acompte', [AcompteController::class, 'import'])->name('acompte.import');
    Route::post('/acompte/ajouter', [AcompteController::class, 'store'])->name('acompte.store');
    Route::get('/acompte/supprimer/{acompte}', [AcompteController::class, 'destroy'])->name('acompte.destroy');
    Route::put('/acompte/modifier/{acompte}', [AcompteController::class, 'update'])->name('acompte.update');
    Route::get('/acompte/modifier/{acompte}', [AcompteController::class, 'edit'])->name('acompte.edit');

    // Etat
    Route::get('/etat', [EtatController::class, 'index'])->name('etat.index');
    Route::post('/etat/import-etat', [EtatController::class, 'import'])->name('etat.import');
    Route::post('/etat/ajouter', [EtatController::class, 'store'])->name('etat.store');
    Route::get('/etat/supprimer/{etat}', [EtatController::class, 'destroy'])->name('etat.destroy');
    Route::put('/etat/modifier/{etat}', [EtatController::class, 'update'])->name('etat.update');
    Route::get('/etat/modifier/{etat}', [EtatController::class, 'edit'])->name('etat.edit');

    // tp
    Route::get('/tp', [TpController::class, 'index'])->name('tp.index');
    Route::post('/tp/import-tp', [TpController::class, 'import'])->name('tp.import');
    Route::post('/tp/ajouter', [TpController::class, 'store'])->name('tp.store');
    Route::get('/tp/supprimer/{Tp}', [TpController::class, 'destroy'])->name('tp.destroy');
    Route::put('/tp/modifier/{Tp}', [TpController::class, 'update'])->name('tp.update');
    Route::get('/tp/modifier/{Tp}', [TpController::class, 'edit'])->name('tp.edit');

    // Bilan
    Route::get('/bilan', [BilanController::class, 'index'])->name('bilan.index');
    Route::post('/bilan/import-bilan', [BilanController::class, 'import'])->name('bilan.import');
    Route::post('/bilan/ajouter', [BilanController::class, 'store'])->name('bilan.store');
    Route::get('/bilan/supprimer/{Bilan}', [BilanController::class, 'destroy'])->name('bilan.destroy');
    Route::put('/bilan/modifier/{Bilan}', [BilanController::class, 'update'])->name('bilan.update');
    Route::get('/bilan/modifier/{Bilan}', [BilanController::class, 'edit'])->name('bilan.edit');

    // CM
    Route::get('/cm', [CmController::class, 'index'])->name('cm.index');
    Route::post('/cm/import-cm', [CmController::class, 'import'])->name('cm.import');
    Route::post('/cm/ajouter', [CmController::class, 'store'])->name('cm.store');
    Route::get('/cm/supprimer/{Cm}', [CmController::class, 'destroy'])->name('cm.destroy');
    Route::put('/cm/modifier/{Cm}', [CmController::class, 'update'])->name('cm.update');
    Route::get('/cm/modifier/{Cm}', [CmController::class, 'edit'])->name('cm.edit');

    // pv
    Route::get('/pv', [PvController::class, 'index'])->name('pv.index');
    Route::post('/pv/import-pv', [PvController::class, 'import'])->name('pv.import');
    Route::post('/pv/ajouter', [PvController::class, 'store'])->name('pv.store');
    Route::get('/pv/supprimer/{Pv}', [PvController::class, 'destroy'])->name('pv.destroy');
    Route::put('/pv/modifier/{Pv}', [PvController::class, 'update'])->name('pv.update');
    Route::get('/pv/modifier/{Pv}', [PvController::class, 'edit'])->name('pv.edit');

    // irprof
    Route::get('/irprof', [IrprofController::class, 'index'])->name('irprof.index');
    Route::post('/irprof/import-irprof', [IrprofController::class, 'import'])->name('irprof.import');
    Route::post('/irprof/ajouter', [IrprofController::class, 'store'])->name('irprof.store');
    Route::get('/irprof/supprimer/{Irprof}', [IrprofController::class, 'destroy'])->name('irprof.destroy');
    Route::put('/irprof/modifier/{Irprof}', [IrprofController::class, 'update'])->name('irprof.update');
    Route::get('/irprof/modifier/{Irprof}', [IrprofController::class, 'edit'])->name('irprof.edit');

    // Logout
    Route::post('logging-out', [LogoutController::class, 'logout'])->name('logout');
});
