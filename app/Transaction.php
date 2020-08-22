<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'user_id',
        'service_id',
        'client_id',
        'price',
        'agent_percent',
        'agent_price',
        'admin_percent',
        'options',
        'pratica',
        'motivazione',
        'admin_id',
        'payment_status',
        'payment_details',
        'payment_date',
    ];
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function client()
    {
        return $this->hasOne(Client::class, 'id', 'client_id');
    }

    public function service()
    {
        return $this->hasOne(Services::class, 'id', 'service_id');
    }

    public function admin()
    {
        return $this->hasOne(User::class, 'id', 'admin_id');
    }
}
