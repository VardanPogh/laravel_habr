<?php

namespace App;

use App\Fillables\NipTransaction\Relations;
use Illuminate\Database\Eloquent\Model;

class NipTransaction extends Model
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
        'user_id',
        'client_id',
        // GroupC
        'plant_location_address',
        //
        'alternative_telephone_number',
        'service_id',
    ];
}
