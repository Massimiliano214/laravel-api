<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;

class ProjectController extends Controller
{
    public function index() {
        $projects = Project::with(['technologies', 'type'])->paginate(6);

        return response()->json([
            'success' => true,
            'results' => $projects
        ]);
    }

    public function show() {
        $projects = Project::where('slug', $slug)->with(['technologies', 'type'])->first();

        return response()->json([
            'success' => true,
            'project' => $project
        ]);
    }
}
