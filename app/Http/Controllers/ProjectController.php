<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\View\View;

class ProjectController extends Controller
{
    public function index(): View
    {
        return view('projects.index', [
            'projects' => $this->publishedProjects(),
        ]);
    }

    public function show(Project $project): View
    {
        abort_unless($project->published_at?->isPast(), 404);

        return view('projects.show', [
            'project' => $project,
        ]);
    }

    private function publishedProjects(): LengthAwarePaginator
    {
        return Project::published()->ordered()->paginate(12);
    }
}
