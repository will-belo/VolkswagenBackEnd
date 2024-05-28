<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(
        protected UserService $service
    ){}

    public function getAll(Request $request)
    {
        $userData = $this->service->all($request);

        if($userData){
            return response()->json($userData, 200);
        }

        return response()->json('usuário não encontrado', 404);
    }
}
