<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int user_id
 */
class Project extends Model
{
    use SoftDeletes;

    protected $hidden = [
        'user_id',
        'deleted_at',
        'updated_at',
    ];

    protected $fillable = [
        'name',
        'description',
        'status',
        'deadline',
    ];

    protected $dates = ['deleted_at'];

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
