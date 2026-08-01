<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $featuredProjects = Project::published()
            ->where('is_featured', true)
            ->ordered()
            ->get();

        return view('home', [
            'featuredProjects' => $featuredProjects,
        ]);
    }
}
