<?php
namespace App\Http\Repository;

use App\Interfaces\UserRepositoryInterface;
use App\Models\User;
use Exception;

class UserRepository implements UserRepositoryInterface
{
    public function __construct(
        protected User $model
    ){}
    
    public function find($id)
    {
        $data = $this->model->where('user_login_id', $id)->get()->first();

        return $data;
    }

    public function create($user_DATA, $login_ID, $addres_ID)
    {
        $record = $this->model->create([
            'name'                => $user_DATA->name,
            'email'               => $user_DATA->email,
            'phone'               => $user_DATA->phone,
            'gender'              => $user_DATA->gender,
            'born_at'             => $user_DATA->born_at,
            'document'            => $user_DATA->document,
            'user_login_id'       => $login_ID,
            'common_user_address' => $addres_ID,
        ]);
        
        return $record;
    }
}