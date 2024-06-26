<?php

namespace App\Services;

use App\Http\Repository\ConcessionaireRepository;
use App\Http\Repository\TrainingRepository;
use App\Models\User;

class ConcessionaireAreaService
{
    public function __construct(
        protected TrainingRepository $repository,
    ){}
    
    public function trainings(string $id)
    {
        $data = $this->repository->especifyConcessionaire($id);

        return $data;
    }
    
    public function users(string $training, string $concessionaire)
    {
        $data = User::whereHas('trainings', function ($query) use ($training, $concessionaire) {
            $query->where('trainings_id', $training)
                ->where('concessionaire_id', $concessionaire);
        })
        ->get();

        return $data;
    }
}