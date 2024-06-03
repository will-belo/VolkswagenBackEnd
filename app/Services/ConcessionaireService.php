<?php

namespace App\Services;

use App\Http\Repository\ConcessionaireRepository;
use Illuminate\Http\Request;
use RuntimeException;

class ConcessionaireService
{
    public function __construct(
        protected ConcessionaireRepository $concessionaireRepo,
    ){}
    
    public function getConcessionaireByAddress(Request $request)
    {
        if($request->has('state') && $request->has('city')){
            $data = $this->concessionaireRepo->getByAddress($request->query('state'), $request->query('city'), $request->query('training'));
            
            if($data->isEmpty()){
                throw new RuntimeException('Nenhuma concessionária encontrada nessa cidade');
            }

            return $data;
        }

        throw new RuntimeException('Estado e cidade são necessários');
    }
}