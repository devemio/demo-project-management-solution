<?php

namespace App\Repositories;

use App\Project;
use Illuminate\Http\Request;

class ProjectRepository extends BaseRepository
{
    private $project;

    public function __construct(Request $request, Project $project)
    {
        parent::__construct($request);
        $this->project = $project;
    }

    public function all()
    {
        return $this->project->where('user_id', $this->getUserID())->get();
    }
}