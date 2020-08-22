<?php

namespace App\Http\Controllers\ServicesReloadConfirm;

use App\Http\Controllers\Controller;
use App\Http\Requests\ServicesReloadConfirm\IndexRequest;
use App\Http\Requests\ServicesReloadConfirm\StoreRequest;
use Symfony\Component\HttpFoundation\JsonResponse;

class ServicesReloadConfirmController extends Controller
{
    public function index(IndexRequest $request)
    {
        return view('reloads', ['confirmedReloads' => $request->getServiceConfirmedReloads()]);
    }

    public function store(StoreRequest $request): JsonResponse
    {
        return response()->json($request->persist()->getServiceReloadConfirm());
    }
}
