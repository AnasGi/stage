<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\CnssController;
use Illuminate\Support\Facades\Route;

Route::get('/' , [ClientController::class , 'index'])->name('acueil.index');
Route::post('import-clients', [ClientController::class, 'import'])->name('clients.import');


Route::get('/cnss' , [CnssController::class , 'index'])->name('cnss.index');
Route::post('/cnss/import-cnss', [CnssController::class, 'import'])->name('cnss.import');

