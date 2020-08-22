<?php

namespace App\Http\Requests\FixedServices;

use App\FixedServices;
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

    public function getFixedServices(): Collection
    {
        return FixedServices::all();
    }
}
