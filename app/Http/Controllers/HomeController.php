<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;

class HomeController extends Controller
{
    public function index()
    {
        $projects = Project::select('id', 'title', 'description', 'cover_image', 'github_link')
            ->orderBy('id', 'desc')
            ->get();

        return view('index', compact('projects'));
    }
}
