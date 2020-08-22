<?php

namespace App\Http\Controllers\FixedServices;

use App\FixedServices;
use App\Http\Controllers\Controller;
use App\Http\Requests\FixedServices\DestroyRequest;
use App\Http\Requests\FixedServices\IndexRequest;
use App\Http\Requests\FixedServices\ShowRequest;
use App\Http\Requests\FixedServices\StoreRequest;
use App\Http\Requests\FixedServices\UpdateRequest;
use Symfony\Component\HttpFoundation\JsonResponse;

class FixedServicesController extends Controller
{
    public function index(IndexRequest $request): JsonResponse
    {
        return response()->json($request->getFixedServices());
    }

    public function show(ShowRequest $request, FixedServices $fixedService): JsonResponse
    {
        return response()->json($request->getServiceReload());
    }

    public function store(StoreRequest $request)
    {
        return response()->json($request->persist()->getFixedService());
    }

    public function update(UpdateRequest $request, FixedServices $fixedService): JsonResponse
    {
        return response()->json($request->persist()->getFixedService());
    }

    public function destroy(DestroyRequest $request, FixedServices $fixedService): JsonResponse
    {
        return response()->json($request->persist()->getFixedService());
    }

}
