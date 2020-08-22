<?php

namespace App\Http\Controllers\ServicesReload;

use App\Http\Controllers\Controller;
use App\Http\Requests\ServicesReloads\DestroyRequest;
use App\Http\Requests\ServicesReloads\IndexRequest;
use App\Http\Requests\ServicesReloads\ShowRequest;
use App\Http\Requests\ServicesReloads\StoreRequest;
use App\Http\Requests\ServicesReloads\UpdateRequest;
use App\ServicesReload;
use Symfony\Component\HttpFoundation\JsonResponse;

class ServicesReloadController extends Controller
{
    public function index(IndexRequest $request): JsonResponse
    {
        return response()->json($request->getServiceReloads());
    }

    public function show(ShowRequest $request, ServicesReload $servicesReload): JsonResponse
    {
        return response()->json($request->getServiceReload());
    }

    public function store(StoreRequest $request)
    {
        return response()->json($request->persist()->getServiceReload());
    }

    public function update(UpdateRequest $request, ServicesReload $servicesReload): JsonResponse
    {
        return response()->json($request->persist()->getServiceReload());
    }

    public function destroy(DestroyRequest $request, ServicesReload $servicesReload): JsonResponse
    {
        return response()->json($request->persist()->getServiceReload());
    }
}
