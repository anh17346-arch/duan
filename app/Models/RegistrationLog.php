<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegistrationLog extends Model
{
    protected $fillable = ['email','ip','user_agent','status'];

}
