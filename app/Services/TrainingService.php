<?php

namespace App\Services;

use App\Http\Repository\TrainingRepository;

class TrainingService
{
    public function __construct(
        protected TrainingRepository $trainingRepo,
    ){}
    
    public function getAllTrainings()
    {
        $data = $this->trainingRepo->all();

        return $data;
    }
}