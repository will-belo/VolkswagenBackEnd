<?php

namespace App\Handlers;

use Illuminate\Http\Request;
use App\Services\AccessService;

class SinglePassHandler extends AbstractHandler
{
    public function handle(Request $request, AccessService $service, array &$context)
    {
        $singlePassID = $service->singePassRequest($request);

        if (!$singlePassID['status']) {
            return response()->json($singlePassID['message'], 400);
        }

        $context['singlePassId'] = $singlePassID['iD'];
        $context['singlePassToken'] = $singlePassID['token'];
        
        return parent::handle($request, $service, $context);
    }
}