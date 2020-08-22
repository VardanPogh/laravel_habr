<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    public $fillable = ['id', 'service_id', 'first_name', 'last_name', 'tax_code', 'address', 'house_number', 'manager', 'cap', 'birthday', 'city', 'provincia', 'birth_place', 'birth_provincia',  'gender', 'fixed_delivery', 'fixed_manager', 'mobile', 'mobile_delivery', 'alternative_mobile', 'email', 'alternative_email', 'type', 'business_name', 'vat_number'];
    public function documents()
    {
        return $this->hasMany(ClientDocument::class, 'client_id', 'id');
    }

    public function service()
    {
        return $this->hasOne(Services::class, 'id', 'service_id');
    }

    public function manager()
    {
        return $this->hasOne(ManagerOptions::class, 'id', 'manager');
    }
}
