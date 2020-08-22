<?php

namespace App\Http\Requests\FixedServices;

use App\FixedServices;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\File;

/**
 * @property FixedServices fixed_service
 */
class DestroyRequest extends  FormRequest
{
    public function rules()
    {
        return [
            //
        ];
    }

    public function persist(): self
    {
        File::delete(public_path(substr($this->fixed_service->image, 7,strlen ($this->fixed_service->image))));
        $this->fixed_service->delete();

        return $this;
    }

    public function getFixedService(): string
    {
        return "Fixed service has been deleted";
    }
}
