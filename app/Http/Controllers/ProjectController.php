<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectRequest;
use App\Project;
use App\Repositories\ProjectRepository;
use App\Utils\Statuses;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProjectController extends Controller
{
    protected $projectRepository;
    protected $project;

    public function __construct(ProjectRepository $projectRepository, Project $project)
    {
        $this->projectRepository = $projectRepository;
        $this->project = $project;
    }

    public function index()
    {
        return $this->projectRepository->all();
    }

    public function store(StoreProjectRequest $request)
    {
        $project = new Project($request->all());
        $request->user()->projects()->save($project);
        return $project;
    }

    public function show(Project $project)
    {
        return $project;
    }

    public function update(Request $request, Project $project)
    {
        $this->authorize('update', $project);

        $this->validate($request, [
            'name' => 'filled|max:255',
            'description' => 'filled',
            'status' => [Rule::in(Statuses::all())],
            'deadline' => 'date_format:Y-m-d',
        ]);

        $project->fill($request->all());
        $project->save();
        return $project;
    }

    public function destroy(Project $project)
    {
        $project->delete();
    }

    public function restoreProject(int $projectID)
    {
        $this->project->withTrashed()->findOrFail($projectID)->restore();
    }
}
