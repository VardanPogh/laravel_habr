<?php

namespace App\Http\Requests\FixedServices;

use App\FixedServices;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\File;

/**
 * @property FixedServices fixed_service
 */
class UpdateRequest extends FormRequest
{
    public $imagePath;

    public function rules()
    {
        return [
            'image'                 => 'file',
            'title'                 => 'string',
            'form_type'             => 'string',
            'category_id'           => 'int|exists:categories,id'
        ];
    }

    public function persist(): self
    {
        $this->manageRelations();

        $this->fixed_service->update(array_merge($this->request->all(), $this->getMergingData()));

        return $this;
    }

    public function manageRelations()
    {
        $this->updateImage();
    }

    public function getMergingData(): array
    {
        return [
            'image' => $this->imagePath ? $this->imagePath : $this->fixed_service->image,
        ];
    }

    public function getFixedService(): FixedServices
    {
        return $this->fixed_service;
    }

    public function updateImage()
    {

        if ($this->hasFile('image')) {
            $file = $this->file('image');
            $nameOri = join('_', explode(' ', $file->getClientOriginalName()));
            $fileName = '/public/image/fixedServices/'.time().'_service_'.$nameOri;
            $file->move(public_path('image/fixedServices'), $fileName);
            chmod(public_path('image/fixedServices'), 0777);

            if(file_exists(public_path(substr($this->fixed_service->image, 7,strlen ($this->fixed_service->image))))) {
                File::delete(public_path(substr($this->fixed_service->image, 7,strlen ($this->fixed_service->image))));
            }
            $this->imagePath = $fileName;
        }
    }
}
