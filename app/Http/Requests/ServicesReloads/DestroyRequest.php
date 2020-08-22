<?php

namespace App\Http\Requests\ServicesReloads;

use App\ServicesReload;
use Illuminate\Foundation\Http\FormRequest;use Illuminate\Support\Facades\File;

/**
 * @property ServicesReload services_reload
 */
class DestroyRequest extends FormRequest
{
    public function rules()
    {
        return [
            //
        ];
    }

    public function persist(): self
    {
        File::delete(public_path(substr($this->services_reload->image, 7,strlen ( $this->services_reload->image))));
        $this->services_reload->delete();

        return $this;
    }

    public function getServiceReload(): string
    {
       return "Service Reload has been deleted";
    }
}
