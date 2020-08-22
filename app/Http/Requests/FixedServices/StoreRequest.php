<?php

namespace App\Http\Requests\FixedServices;

use App\FixedServices;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public $fixedServices;
    public $imagePath;

    public function rules()
    {
        return [
            'image'                 => 'required|file',
            'title'                 => 'required|string',
            'form_type'             => 'required|string',
            'category_id'           => 'required|int|exists:categories,id'
        ];
    }

    public function persist(): self
    {
        $this->manageRelations();

        $this->fixedServices = FixedServices::create(array_merge($this->request->all(), $this->getMergingData()));

        return $this;
    }

    public function manageRelations()
    {
        $this->createImage();
    }

    public function getMergingData(): array
    {
        return [
            'image' => $this->imagePath,
        ];
    }

    public function createImage()
    {
        if ($this->hasFile('image')) {

            $file = $this->file('image');
            $nameOri = join('_', explode(' ', $file->getClientOriginalName()));
            $fileName = '/public/image/fixedServices/'.time().'_service_'.$nameOri;
            $file->move(public_path('image/fixedServices'), $fileName);
            chmod(public_path('image/fixedServices'), 0777);
            $this->imagePath = $fileName;
        }
    }

    public function getFixedService(): FixedServices
    {
        return $this->fixedServices;
    }
}
