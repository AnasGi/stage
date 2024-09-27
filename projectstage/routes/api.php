<?php

use App\Http\Controllers\CnssController;
use Illuminate\Support\Facades\Route;

Route::get('/cnss' , [CnssController::class , 'index']);
