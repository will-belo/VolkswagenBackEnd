<?php 

namespace App\Services;

use App\Adapter\EmailSenderAdapter;

class EmailAdapterImplements implements EmailSenderAdapter
{
    public function __construct(
        protected RdStationService $service
    ){}

    public function send(string $endpoint, array $data, string $options = '')
    {
        return $this->service->send($endpoint, $data, $options);
    }
}