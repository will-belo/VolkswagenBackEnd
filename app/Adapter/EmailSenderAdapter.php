<?php


namespace App\Adapter;

use Illuminate\Http\Request;

interface EmailSenderAdapter
{
    public function send(string $endpoint, Request $data, string $options = '');
}