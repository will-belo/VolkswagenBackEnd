<?php
namespace App\Http\Repository;

use App\Models\Concessionaire;

class ConcessionaireRepository
{
    public function __construct(
        protected Concessionaire $model,
    ){}

    public function getInfos($id)
    {
        $data = $this->model->find($id)->with('address')->get(); // Retornar endereço

        return $data;
    }

    public function getByAddress($state, $city, $id)
    {
        $data = $this->model->whereHas('trainingVacancies', function ($query) use ($id) {
            $query->where('training_id', $id);
        })
        ->whereHas('address.city', function ($query) use ($state, $city) {
            $query->where('value', $city)
            ->whereHas('state', function ($query) use ($state) {
                $query->where('value', $state);
            });
        })
        ->with('trainingVacancies', function ($query) use ($id) {
            $query->where('training_id', $id);
        })
        ->with('address.city.state')
        ->get();
        
        return $data;
    }
}