<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MnpTransaction extends Model
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
        'current_mobile_operator',
        'temporary_tim_number',
        'user_id',
        'client_id',
        'iccid_serial_sim',
        'service_id',
    ];
}
