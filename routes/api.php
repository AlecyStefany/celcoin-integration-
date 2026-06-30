<?php

use App\Http\Controllers\BoletoController;
use Illuminate\Support\Facades\Route;

Route::post('/boletos', [BoletoController::class, 'store']);
