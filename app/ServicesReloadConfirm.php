<?php

namespace App;

use App\Fillables\ServicesReloadConfirm\Relations;
use Illuminate\Database\Eloquent\Model;

class ServicesReloadConfirm extends Model
{
    use Relations;

    protected $table = 'confirm_reloads';

    protected $fillable =[
      'reloaded_number',
      'confirm_reloaded_number',
      'user_id',
      'service_id'
    ];
}
