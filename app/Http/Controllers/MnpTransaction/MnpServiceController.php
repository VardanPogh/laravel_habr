<?php

namespace App\Http\Controllers\MnpTransaction;

use App\Http\Controllers\Controller;
use App\Http\Requests\MnpTransactions\StoreRequest;
use Symfony\Component\HttpFoundation\JsonResponse;

class MnpServiceController extends Controller
{
    public function store(StoreRequest $request): JsonResponse
    {
        return response()->json($request->persist()->getMnpService());
    }
}
