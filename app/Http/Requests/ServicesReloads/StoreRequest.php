<?php

namespace App\Http\Requests\ServicesReloads;

use App\ServicesReload;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public $serviceReload;
    public $imagePath;

    public function rules()
    {
        return [
            'image'                 => 'required|file',
            'title'                 => 'required|string',
            'amount'                => 'required|int',
            'course'                => 'required|string',
            'category_id'           => 'required|int|exists:categories,id'
        ];
    }

    public function persist(): self
    {
        $this->manageRelations();

        $this->serviceReload = ServicesReload::create(array_merge($this->request->all(), $this->getMergingData()));

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
            $fileName = '/public/image/servicesReload/'. time().'_categories_'.$nameOri;
            $file->move(public_path('image/servicesReload'), $fileName);
            chmod(public_path('image/servicesReload'), 0777);
            $this->imagePath = $fileName;
        }
    }

    public function getServiceReload(): ServicesReload
    {
        return $this->serviceReload;
    }
}
