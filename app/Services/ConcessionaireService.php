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
        if($request->has('state') && $request->has('state')){
            $data = $this->concessionaireRepo->getByAddress($request->query('state'), $request->query('city'));
        
            return $data;
        }
        
        throw new RuntimeException('Estado e cidade são necessários');
    }
}