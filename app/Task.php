<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int user_id
 * @property int assigned_to
 * @property int project_id
 */
class Task extends Model
{
    protected $fillable = [
        'name',
        'description',
        'status',
        'deadline',
    ];
}
