<?php

namespace App\Http\Controllers;

use App\Services\TrainingService;
use Illuminate\Http\Request;

class TrainingController extends Controller
{
    public function __construct(
        protected TrainingService $service
    ){}

    public function getAll()
    {
        $training = $this->service->getAllTrainings();
        
        if($training->isNotEmpty()){
            return response()->json($training, 200);
        }

        return response()->json('Nenhum treinamento encontrado', 404);
    }
}
