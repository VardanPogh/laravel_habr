<?php

namespace App;

use App\Fillables\FixedService\Relations;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string image
 */
class FixedServices extends Model
{
    use Relations;

    protected $fillable = [
        'image',
        'title',
        'category_id',
        'form_type'
    ];
}
