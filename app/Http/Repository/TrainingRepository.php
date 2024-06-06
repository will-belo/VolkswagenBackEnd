<?php
namespace App\Http\Repository;

use App\Models\Training;
use App\Models\TrainingUser;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class TrainingRepository
{
    public function __construct(
        protected Training $model,
        protected User $modelUser,
        protected TrainingUser $modelFK
    ){}

    public function all()
    {
        $data = $this->model->all();
        
        return $data;
    }

    public function find($id)
    {   
        try{
            $data = $this->modelUser->where('id', $id)
            ->whereHas('trainings', function ($query) use ($id) {
                $query->where('common_user_id', $id);
            })
            ->with(['concessionaire' => function ($query) use ($id) {
                $query->where('common_user_id', $id);
            }, 'trainings' => function ($query) use ($id) {
                $query->where('common_user_id', $id);
            }])
            ->get();
        }catch(ModelNotFoundException){
            throw new Exception("Nenhum usuário encontrado");
        }
        
        return $data;
    }

    public function create(int $trainingID, int $userID, int $concessionaireID = 0)
    {
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

    public function update(int $id, Request $request)
    {
        $record = $this->modelFK->findOrFail($id);
        
        $record->update(['concessionaire_id' => $request->concessionaireId]);

        return $record;
    }
}