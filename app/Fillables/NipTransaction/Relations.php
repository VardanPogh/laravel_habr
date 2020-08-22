<?php

namespace App\Fillables\NipTransaction;

use App\Client;
use App\FixedServices;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

trait Relations
{
    public function service(): HasOne
    {
        return $this->hasOne(FixedServices::class, 'id', 'fixed_service_id');
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }
}
