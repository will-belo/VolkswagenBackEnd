<?php

namespace App\Handlers;

use Illuminate\Http\Request;
use App\Services\AccessService;

class ValidateUserHandler extends AbstractHandler
{
    public function handle(Request $request, AccessService $service, array &$context)
    {
        $validateUser = $service->validateUser($request);

        if (!$validateUser['status']) {
            return response()->json($validateUser['message'], 400);
        }

        return parent::handle($request, $service, $context);
    }
}