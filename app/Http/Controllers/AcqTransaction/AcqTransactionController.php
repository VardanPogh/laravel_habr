<?php

namespace App\Http\Controllers\AcqTransaction;

use App\Http\Controllers\Controller;
use App\Http\Requests\AcqTransactions\StoreRequest;
use Symfony\Component\HttpFoundation\JsonResponse;

class AcqTransactionController extends Controller
{
    public function store(StoreRequest $request): JsonResponse
    {
        return response()->json($request->persist()->getAsqService());
    }
}
