<?php

namespace App\Http\Controllers;

use App\Handlers\AccessHandler;
use App\Handlers\AddressHandler;
use App\Handlers\AutoRepairHandler;
use App\Handlers\SinglePassHandler;
use App\Handlers\ValidateAutoRepairHandler;
use App\Handlers\ValidateSituationHandler;
use App\Handlers\ValidateUserHandler;
use App\Interfaces\Handler;
use Illuminate\Http\Request;
use App\Services\AccessService;
use App\Traits\NormalizeRequest;

class AccessController extends Controller
{
    use NormalizeRequest;

    private Handler $handler;

    public function __construct(
        protected AccessService $service
    ){
        $this->handler = new ValidateUserHandler();

        $validateSituationHandler  = new ValidateSituationHandler();

        $validateAutoRepairHandler = new ValidateAutoRepairHandler();

        $singlePassHandler         = new SinglePassHandler();

        $addressHandler            = new AddressHandler();

        $accessHandler             = new AccessHandler();

        $autoRepairHandler         = new AutoRepairHandler();

        $this->handler            ->setNext($validateSituationHandler);
        $validateSituationHandler ->setNext($validateAutoRepairHandler);
        $validateAutoRepairHandler->setNext($singlePassHandler);
        $singlePassHandler        ->setNext($addressHandler);
        $addressHandler           ->setNext($accessHandler);
        $accessHandler            ->setNext($autoRepairHandler);
    }
    
    /**
     * 
     * Controller geral
     */
    public function signup(Request $request)
    {
        $context = [];

        $response = $this->handler->handle($request, $this->service, $context);

        if($response){
            return $response;
        }
        
        return response()->json([
            'token'   => $context['singlePassToken'],
            'user_id' => $context['singlePassId'],
            'message' => 'Usuário cadastrado com sucesso',
        ], 201);
    }
}
