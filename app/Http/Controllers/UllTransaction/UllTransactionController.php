<?php

namespace App\Http\Controllers\UllTransaction;

use App\Http\Controllers\Controller;
use App\Http\Requests\UllTransactions\StoreRequest;
use Symfony\Component\HttpFoundation\JsonResponse;

class UllTransactionController extends Controller
{
    public function store(StoreRequest $request): JsonResponse
    {
        return response()->json($request->persist()->getUllService());
    }
}
