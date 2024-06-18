<?php 

namespace App\Services;

use App\Adapter\EmailSenderAdapter;
use Illuminate\Http\Request;

class EmailAdapterImplements implements EmailSenderAdapter
{
    public function __construct(
        protected RdStationService $service
    ){}

    public function send(string $endpoint, Request $data, string $options = '')
    {
        return $this->service->send($endpoint, $data, $options);
    }
}