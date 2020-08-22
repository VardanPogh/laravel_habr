<?php

namespace App\Fillables\ServicesReload;

use App\ServicesReloadConfirm;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait Relations
{
    public function confirms(): HasMany
    {
        return $this->hasMany(ServicesReloadConfirm::class);
    }
}
