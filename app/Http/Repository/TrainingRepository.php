<?php
namespace App\Http\Repository;

use App\Models\Training;

class TrainingRepository
{
    public function __construct(
        protected Training $model
    ){}

    public function all(){
        $data = $this->model->all();
        
        return $data;
    }
}