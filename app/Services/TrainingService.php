<?php

namespace App\Services;

use App\Http\Repository\TrainingRepository;
use App\Models\User;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class TrainingService
{
    public function __construct(
        protected TrainingRepository $trainingRepo,
    ){}
    
    public function getAllTrainings()
    {
        $data = $this->trainingRepo->all();

        if($data->isNotEmpty()){
            return [
                'data' => $data,
                'status' => 200,
            ];
        }

        return [
            'data' => 'Nenhum treinamento encontrado',
            'status' => 404
        ];
    }

    public function getAllTrainingsById($id)
    {
        $userModel = new User;  

        try{
            $data = $this->trainingRepo->find($id, $userModel);

            if($data->isEmpty()){
                throw new Exception("Nenhum treinamento encontrado");
            }
        }catch(\Exception $error){
            return [
                'data' => $error->getMessage(),
                'status' => 404
            ];
        }
        
        return [
            'data' => $data,
            'status' => 200
        ];
    }

    public function saveTrainingUser(Request $request)
    {
        try{
            if(!empty($request->concessionaireId)){
                $data = $this->trainingRepo->create($request->trainingId, $request->userId, $request->concessionaireId);
            }else{
                $data = $this->trainingRepo->create($request->trainingId, $request->userId);
            }

            return [
                'data' => "Cadastro realizado com sucesso!",
                'status' => 201,
            ];
        }catch(QueryException $error){
            return [
                'data' => $error->getMessage(),
                'status' => 400,
            ];
        }catch(\Exception $error){
            return [
                'data' => $error->getMessage(),
                'status' => 400,
            ];
        }
    }
}