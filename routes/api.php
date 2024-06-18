<?php

use App\Http\Controllers\AccessController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AutoRepairController;
use App\Http\Controllers\ConcessionaireControler;
use App\Http\Controllers\TrainingController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserLegacyController;
use App\Http\Middleware\ConvertBooleans;
use App\Http\Middleware\JwtMiddleware;
use App\Http\Middleware\SanitizeInputs;
use App\Services\UserService;
use Illuminate\Support\Facades\Route;

Route::post('/getByCNPJ', [AutoRepairController::class, 'getByCNPJ'])->middleware(SanitizeInputs::class);

Route::post('/signup', 
    [AccessController::class, 'signup']
)->middleware([ConvertBooleans::class, SanitizeInputs::class]);

Route::get('/trainings', [TrainingController::class, 'index']);

Route::post('/getByCpf', [UserLegacyController::class, 'search']);

Route::post('/sendMail', [UserService::class, 'teste']);

Route::middleware(JwtMiddleware::class)->group(function(){
    Route::apiResource('users', UserController::class);
    Route::apiResource('training', TrainingController::class);
    Route::get('/trainings/{id}', [TrainingController::class, 'exib']);
    Route::get('/getConcessionaireByAddress', [ConcessionaireControler::class, 'getByAddress']);

    Route::apiResource('/admin/trainings', AdminController::class);
});