<?php

namespace App\Http\Requests\ServicesReloads;

use App\ServicesReload;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\File;

/**
 * @property ServicesReload services_reload
 */
class UpdateRequest extends FormRequest
{
    public $imagePath;

    public function rules()
    {
        return [
            'image'                 => 'file',
            'title'                 => 'string',
            'amount'                => 'int',
            'course'                => 'string',
            'category_id'           => 'int|exists:categories,id'
        ];
    }

    public function persist(): self
    {
        $this->manageRelations();

        $this->services_reload->update(array_merge($this->request->all(), $this->getMergingData()));

        return $this;
    }

    public function manageRelations()
    {
        $this->updateImage();
    }

    public function getMergingData(): array
    {
        return [
            'image' => $this->imagePath ? $this->imagePath : $this->services_reload->image,
        ];
    }

    public function getServiceReload(): ServicesReload
    {
        return $this->services_reload;
    }

    public function updateImage()
    {

        if ($this->hasFile('image')) {

            $file = $this->file('image');
            $nameOri = join('_', explode(' ', $file->getClientOriginalName()));
            $fileName = '/public/image/servicesReload/'.time().'_categories_'.$nameOri;
            $file->move(public_path('image/servicesReload'), $fileName);

            if(file_exists(public_path(substr($this->services_reload->image, 7,strlen ( $this->services_reload->image))))) {
                File::delete(public_path(substr($this->services_reload->image, 7,strlen ( $this->services_reload->image))));
            }
            $this->imagePath = $this->imagePath = $fileName;
        }
    }
}
