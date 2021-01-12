<?php

namespace Webkul\User\Models;

use Illuminate\Database\Eloquent\Model;
use Webkul\User\Models\Admin;

class AdminPasswordReset extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email',
        'token'
    ];
}
