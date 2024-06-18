<?php


namespace App\Services;

use App\Adapter\EmailSenderAdapter;
use Illuminate\Support\Facades\Http;

class RdStationService
{
    public function __construct(
        private $url = "https://api.rd.services", // 
        private $token = ''
    ){}

    public function config()
    {
        $data = Http::asForm()->post("{$this->url}/auth/token", [
            'client_id' => '26a3266f-c022-449c-b91e-c10ed7f23d8d',
            'client_secret' => '08bffb4411764945a5f1ee4566fa875e',
            'refresh_token' => 'wAZ1wfzM1NpWsXyxNZL9_t9jIJD4hVRa2U6X1ledx1k',
        ]);

        $this->token = $data;
    }

    public function send($endpoint, $data, $options)
    {
        $this->config();

        $params = [
            'legal_bases' => [ 
                'category' => 'communications',
                'type' => 'legitimate_interest',
                'status' => 'granted' 
            ]
        ];
        
        Http::withToken($this->token)->asForm()->patch("{$endpoint}/email:{$options}", $data);
    }
}