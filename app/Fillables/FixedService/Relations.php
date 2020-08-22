<?php

namespace App\Fillables\FixedService;

use App\AcqTransaction;
use App\ConversionTransaction;
use App\MnpTransaction;
use App\NipTransaction;
use App\UllTransaction;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait Relations
{
    public function ullServices(): HasMany
    {
        return $this->hasMany(UllTransaction::class, 'fixed_service_id');
    }

    public function nipServices(): HasMany
    {
        return $this->hasMany(NipTransaction::class, 'fixed_service_id');
    }

    public function acqServices(): HasMany
    {
        return $this->hasMany(AcqTransaction::class, 'fixed_service_id');
    }

    public function conversionServices(): HasMany
    {
        return $this->hasMany(ConversionTransaction::class, 'fixed_service_id');
    }

    public function mnpServices(): HasMany
    {
        return $this->hasMany(MnpTransaction::class, 'fixed_service_id');
    }
}
