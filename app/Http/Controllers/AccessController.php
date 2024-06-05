<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Services\AccessService;
use App\Traits\NormalizeRequest;

class AccessController extends Controller
{
    use NormalizeRequest;

    public function __construct(
        protected AccessService $service
    ){}
    
    public function signup(Request $request)
    {
        $validateUser = $this->service->validateUser($request);

        if(!$validateUser['status']){
            return response()->json($validateUser['message'], 400);
        }

        if($request->check){
            if($request->exist && !empty($request->auto_repair_id)){
                $validateIfExist = $this->service->validateAutoRepairExist($request);

                if(!$validateIfExist['status']){
                    return response()->json($validateIfExist['message'], 400);
                }
                
            }else{
                $validateAutoRepair = $this->service->validateAutoRepair($request);
            
                if(!$validateAutoRepair['status']){
                    return response()->json($validateAutoRepair['message'], 400);
                }
            }
        }
        $singlePassID = $this->service->singePassRequest($request);

        if(!$singlePassID['status']){
            return response()->json($singlePassID['message'], 400);
        }

        $address_ID = $this->service->createAddress($request);
        
        if(!$address_ID['status']){
            return response()->json($address_ID['message'], 400);
        }

        $user = $this->service->createUser($request, $address_ID, $singlePassID['iD']);
        
        if($user['status']){
            if($request->check){
                $NormalizedRequest = $this->normalizeRequestData($request);

                if($request->exist && !empty($request->auto_repair_id)){
                    $verify = $this->service->link_AutoRepair_User($NormalizedRequest, $user['iD'], $request->auto_repair_id);

                    if(!$verify['status']){
                        return response()->json($verify['message'], 400);
                    }
                }else{
                    $address_auto_repair_ID = $this->service->createAddress($NormalizedRequest);
    
                    $auto_repair            = $this->service->createAutoRepair($NormalizedRequest, $address_auto_repair_ID);
    
                    $verify                 = $this->service->link_AutoRepair_User($NormalizedRequest, $user['iD'], $auto_repair);
    
                    if(!$verify['status']){
                        return response()->json($verify['message'], 400);
                    }
                }
            }

            return response()->json('Usuário Cadastrado', 201);
        }

        return response()->json($user['message'], 500);
    }
}