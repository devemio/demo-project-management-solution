<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $hidden = [
        'user_id',
        'deleted_at',
        'updated_at',
    ];
}
