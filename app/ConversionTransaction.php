<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConversionTransaction extends Model
{
    protected $fillable = [
        'document_date',
        'type_of_document',
        'document_number',
        'issue_date',
        'expiry_date',
        'place_of_issue',
        'issuing_body',
        'emission_province',
        'document_front',
        'document_retro',
        'plant_location_address',
        'alternative_telephone_number',
        'fixed_tim_number',
        'user_id',
        'client_id',
        'service_id'
    ];
}
