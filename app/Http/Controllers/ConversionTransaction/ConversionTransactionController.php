<?php

namespace App\Http\Controllers\ConversionTransaction;

use App\Http\Controllers\Controller;
use App\Http\Requests\ConversionTransactions\StoreRequest;
use Symfony\Component\HttpFoundation\JsonResponse;

class ConversionTransactionController extends Controller
{
    public function store(StoreRequest $request): JsonResponse
    {
        return response()->json($request->persist()->getConversionService());
    }
}
