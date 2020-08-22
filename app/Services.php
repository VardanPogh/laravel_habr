<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Services extends Model
{
    public function client()
    {
        return $this->hasMany(Client::class, 'id', 'service_id');
    }
}
