<?php

namespace App\Http\Controllers;

use App\Http\Requests\Project\StoreProjectRequest;
use App\Http\Requests\Project\UpdateProjectRequest;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::all();
       return response()->json([
            'status'=> 'Get Projects successfully',
            'Staff' => $projects
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectRequest $request)
    {
            $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('Project', 'public');
        }

        $project = Project::create([
            'title' => $request->title,
            'description' => $request->description,
            'category' => $request->category,
            'image' => $imagePath,
        ]);

        return response()->json([
            'message' => 'Project created successfully',
            'data' => $project,
            'image_url' => $imagePath ? asset('storage/' . $imagePath) : null,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $project = Project::findOrFail($id);
        return response()->json([
            'status' => 'Get Project successfully',
            'Project' => $project
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjectRequest $request, $id)
    {
        $project = Project::find($id);

        if (!$project) {
            return response()->json([
                'status' => 'error',
                'message' => 'Staff not found'
            ], 404);
        }

        // Get all fields except image
        $data = $request->only(['name', 'position', 'description']);

        // If image is uploaded, handle it
        if ($request->hasFile('image')) {
            // Delete old image if it exists
            if ($project->image && Storage::disk('public')->exists($project->image)) {
                Storage::disk('public')->delete($project->image);
            }

            // Store new image
            $imagePath = $request->file('image')->store('Project', 'public');
            $data['image'] = $imagePath;
        }

        // Update project
        $project->update($data);

        return response()->json([
            'message' => 'Staff updated successfully',
            'pro$project' => $project,
            'image_url' => $data['image'] ?? $project->image,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $project = Project::find($id);
        if(!$project){
            return response()->json([
                'message' => 'Project not found'
            ],404);
        }
        $project->delete();
        return response()->json([
            'message' => 'Project deleted successfully'
        ]);
    }
}
