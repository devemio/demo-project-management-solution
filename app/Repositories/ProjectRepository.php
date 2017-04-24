<?php

namespace App\Repositories;

use App\Project;
use Illuminate\Http\Request;

class ProjectRepository
{
    private $project;
    private $request;

    public function __construct(Request $request, Project $project)
    {
        $this->project = $project;
        $this->request = $request;
    }

    public function all()
    {
        return $this->project->where('user_id', $this->request->user()->id)->get();
    }
}