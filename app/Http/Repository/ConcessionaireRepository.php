<?php
namespace App\Http\Repository;

use App\Models\Concessionaire;

class ConcessionaireRepository
{
    public function __construct(
        protected Concessionaire $model
    ){}

    public function getByAddress($state, $city)
    {
        $data = $this->model->join('address as e', 'concessionaire.concessionaire_address', '=', 'e.id')
        ->join('city as ci', 'e.city_id', '=', 'ci.id')
        ->join('state as es', 'ci.state_id', '=', 'es.id')
        ->where('es.value', $state)
        ->where('ci.value', $city)
        ->get();
        
        return $data;
    }
}