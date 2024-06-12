<?php

namespace App\Handlers;

use Illuminate\Http\Request;
use App\Services\AccessService;
use App\Strategy\AutoRepairValidation;
use App\Strategy\AutoRepairExistValidation;

class ValidateAutoRepairHandler extends AbstractHandler
{
    public function handle(Request $request, AccessService $service, array &$context)
    {
        if ($request->check) {
            $validationResult = $this->validateAutoRepair($request, $service);

            if (!$validationResult['status']) {
                return response()->json($validationResult['message'], 400);
            }
        }

        return parent::handle($request, $service, $context);
    }

    private function validateAutoRepair(Request $request, AccessService $service)
    {
        $strategy = !empty($request->auto_repair_id)
            ? new AutoRepairExistValidation()
            : new AutoRepairValidation();

        return $strategy->validate($request, $service);
    }
}