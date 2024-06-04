<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use RuntimeException;

class SinglePassService
{
    public function __construct(
        private String $base_url = 'http://login.oficinabrasil.com.br/api'
    ){}

    public function verify($token)
    {
        $response = Http::withToken($token)->get($this->base_url.'/verify');

        if(!$response->successful()){
            throw new RuntimeException('Token inválido');
        }
        
        return true;
    }

    public function postUser($params)
    {
        $response = Http::asForm()->post($this->base_url.'/register', $params);

        if(!$response->successful()){
            throw new RuntimeException('Erro ao gerar o login, tente novamente');
        }
        
        return $response->object();
    }
}