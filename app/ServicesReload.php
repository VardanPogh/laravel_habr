<?php

namespace App;

use App\Fillables\ServicesReload\Relations;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string image
 */
class ServicesReload extends Model
{
    use Relations;

    protected $fillable = [
        'image',
        'title',
        'amount',
        'course',
        'category_id'
    ];
}

