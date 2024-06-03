<?php
namespace App\Http\Repository;

use App\Models\Training;
use App\Models\TrainingUser;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TrainingRepository
{
    public function __construct(
        protected Training $model,
        protected TrainingUser $modelFK
    ){}

    public function all(){
        $data = $this->model->all();
        
        return $data;
    }
    // RETORNAR DADOS DA OFICINA CASO SEJA PRESENCIAL OU RETORNAR SE O TREINAMENTO É ONLINE
    public function find($id, $model){   
        try{
            $user = $model->findOrFail($id);
        }catch(ModelNotFoundException){
            throw new Exception("Nenhum usuário encontrado");
        }

        $data = $user->trainings;

        return $data;
    }

    public function create(int $trainingID, int $userID, int $concessionaireID = 0){
        $exist = $this->modelFK->where('trainings_id', $trainingID)
            ->where('common_user_id', $userID)
            ->exists();

        if($exist){
            throw new Exception("Você já se cadastrou nesse treinamento");
        }
        
        $record = $this->modelFK->create([
            'common_user_id' => $userID,
            'concessionaire_id' => $concessionaireID,
            'trainings_id' => $trainingID,
            'presence' => 0,
        ]);
        
        return $record;
    }
}