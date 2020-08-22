<?php

namespace App\Http\Requests\FixedServices;

use App\FixedServices;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property FixedServices fixed_service
 */
class ShowRequest extends FormRequest
{
    public function rules()
    {
        return [
            //
        ];
    }

    public function getServiceReload(): FixedServices
    {
        return $this->fixed_service;
    }
}
