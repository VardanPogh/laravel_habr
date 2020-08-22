<?php


namespace App\Fillables\ServicesReloadConfirm;

use App\ServicesReload;
use Illuminate\Database\Eloquent\Relations\HasOne;

trait Relations
{
    public function service(): HasOne
    {
        return $this->hasOne(ServicesReload::class, 'id', 'services_reload_id');
    }
}
