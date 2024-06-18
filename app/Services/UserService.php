<?php

namespace App\Services;

use App\Adapter\EmailSenderAdapter;
use Exception;
use App\Interfaces\UserRepositoryInterface;
use Illuminate\Http\Request;

class UserService
{
    public function __construct(
        protected UserRepositoryInterface $userRepo,
        protected EmailSenderAdapter $email,
    ){}
    
    public function allInfos(string $id)
    {
        $data = $this->userRepo->find($id);

        return $data;
    }

    public function sendEmail(Request $data)
    {
        $this->email->send('/platform/contacts', $data, $data->email);
    }
}