<?php

namespace App\Http\Requests\ServicesReloads;

use App\ServicesReload;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Http\FormRequest;

class IndexRequest extends FormRequest
{
    public function rules()
    {
        return [
            //
        ];
    }

    public function getServiceReloads(): Collection
    {
        return ServicesReload::all();
    }
}
