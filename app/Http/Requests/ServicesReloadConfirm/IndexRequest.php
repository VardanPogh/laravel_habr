<?php

namespace App\Http\Requests\ServicesReloadConfirm;

use App\ServicesReloadConfirm;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class IndexRequest extends FormRequest
{
    public function rules()
    {
        return [
            //
        ];
    }

    public function getServiceConfirmedReloads(): Collection
    {
        return ServicesReloadConfirm::where('user_id', Auth::id())->with('service')->get();
    }
}
