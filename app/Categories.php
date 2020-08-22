<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    
    public function services ()
    {
        return $this->hasMany(Services::class, 'category_id', 'id');
    }
}
