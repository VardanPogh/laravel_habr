<?php

namespace App\Http\Controllers\NipTransaction;

use App\Http\Controllers\Controller;
use App\Http\Requests\NipTransactions\StoreRequest;
use Symfony\Component\HttpFoundation\JsonResponse;

class NipTransactionController extends Controller
{
    public function store(StoreRequest $request): JsonResponse
    {
        return response()->json($request->persist()->getNipService());
    }
}
