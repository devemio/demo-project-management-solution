<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int id
 * @property int user_id
 * @property int assigned_to
 * @property int project_id
 * @property Project project
 */
class Task extends Model
{
    protected $fillable = [
        'name',
        'description',
        'status',
        'deadline',
    ];

    protected $hidden = [
        'project'
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
