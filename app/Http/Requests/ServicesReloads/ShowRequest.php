<?php

namespace App\Http\Requests\ServicesReloads;

use App\ServicesReload;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property ServicesReload services_reload
 */
class ShowRequest extends FormRequest
{
    public function rules()
    {
        return [
            //
        ];
    }

    public function getServiceReload(): ServicesReload
    {
        return $this->services_reload;
    }
}
