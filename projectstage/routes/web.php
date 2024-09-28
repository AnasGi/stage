<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\CnssController;
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
