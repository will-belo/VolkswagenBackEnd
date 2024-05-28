<?php

namespace App\Services;

use Exception;
use App\Interfaces\UserRepositoryInterface;
use Illuminate\Http\Request;

class UserService
{
    public function __construct(
        protected UserRepositoryInterface $userRepo,
    ){}
    
    public function all(Request $request)
    {
        $data = $this->userRepo->find($request->id);

        return $data;
    }
}