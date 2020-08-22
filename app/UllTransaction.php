<?php

namespace App;

use App\Fillables\UllTransaction\Relations;
use Illuminate\Database\Eloquent\Model;

class UllTransaction extends Model
{
    use Relations;

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
        'current_manager',
        'migration_code',
        'service_id',
        'client_id',
        'user_id',
        'current_landline_number',
    ];
}
