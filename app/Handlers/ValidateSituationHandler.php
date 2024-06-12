<?php

namespace App\Handlers;

use App\Handlers\AbstractHandler;
use Illuminate\Http\Request;
use App\Services\AccessService;

class ValidateSituationHandler extends AbstractHandler
{
    public function handle(Request $request, AccessService $service, array &$context)
    {
        $situation = $service->verifySituation($request);
        
        switch($situation){
            case 0:
                $return = true;
                break;
            case 1:
                $return = false;
                break;
            case 2:
                return response()->json('Usuário já Cadastrado!', 201);
                break;
        }

        $context['situation'] = $return;

        return parent::handle($request, $service, $context);
    }
}