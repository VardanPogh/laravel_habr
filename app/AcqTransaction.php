<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AcqTransaction extends Model
{
    protected $fillable = [
        //GroupA
//        'first_name',
//        'last_name',
//        'tax_code',
//        'date_of_birth',
//        'birth_place',
//        'province',
//        'gender',
//        'email',
//        'phone_number',
//        GroupB

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
        'client_id',
        'user_id',
        // GroupC
//        'plant_location_address',
        //
        'new_sim_number',
        'iccid_serial_sim',
        'iccid_serial_sim_2',
        'service_id',
    ];
}
