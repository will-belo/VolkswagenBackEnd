<?php

use App\Http\Controllers\AccessController;
use App\Http\Controllers\AutoRepairController;
use App\Http\Controllers\ConcessionaireControler;
use App\Http\Controllers\TrainingController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\ConvertBooleans;
use App\Http\Middleware\JwtMiddleware;
use App\Http\Middleware\SanitizeInputs;
use Illuminate\Support\Facades\Route;

Route::post('/getByCNPJ', [AutoRepairController::class, 'getByCNPJ'])->middleware(SanitizeInputs::class);

Route::post('/signup', 
    [AccessController::class, 'signup']
)->middleware([ConvertBooleans::class, SanitizeInputs::class]);

Route::get('/getAllTrainings', [TrainingController::class, 'getAll']);

Route::middleware(JwtMiddleware::class)->group(function(){
    Route::apiResource('users', UserController::class);
    Route::get('/getConcessionaireByAddress', [ConcessionaireControler::class, 'getByAddress']);
});