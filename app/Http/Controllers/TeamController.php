<?php

namespace App\Http\Controllers;

use App\Http\Requests\Team\StoreTeamRequest;
use App\Http\Requests\Team\UpdateTeamRequest;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $teams = Team::all();
        return response()->json([
            'status'=> 'Get Teams successfully',
            'Team' => $teams
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTeamRequest $request)
    {
        $request->validate([
            'name'=> 'required|string|max:255',
            'position'=> 'required|string',
            'description'=> 'required|string',
            'image'=> 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')){
            $imagePath = $request->file('image')->store('Team','public');
        }

        $team = Team::create([
            'name' => $request->name,
            'position' => $request->position,
            'description' => $request->description,
            'image' => $imagePath
        ]);
        return response()->json([
            'message' => 'Team create successfully',
            'data' => $team,
            'image_url' => $imagePath ? asset('storage/' .$imagePath) : null,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $team = Team::findOrFail($id);
        return response()->json([
            'status' => 'Get Team successfully',
            'Staff' => $team
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTeamRequest $request,$id)
    {
        $team = Team::find($id);

        // dd($request->file('image'));

        if (!$team) {
            return response()->json([
                'status' => 'error',
                'message' => 'Team not found'
            ], 404);
        }

        // Get all fields except image
        $data = $request->only(['name', 'position', 'description']);

        // If image is uploaded, handle it
        if ($request->hasFile('image')) {
            // Delete old image if it exists
            if ($team->image && Storage::disk('public')->exists($team->image)) {
                Storage::disk('public')->delete($team->image);
            }

            // Store new image
            $imagePath = $request->file('image')->store('Team', 'public');
            $data['image'] = $imagePath;
        }

        // Update team
        $team->update($data);

        return response()->json([
            'message' => 'Team updated successfully',
            'team' => $team,
            'image_url' => $data['image'] ?? $team->image,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
       $team = Team::find($id);
        if(!$team){
            return response()->json([
                'message' => 'Team not found'
            ],404);
        }
        $team->delete();
        return response()->json([
            'message' => 'Team deleted successfully'
        ]);
    }
}
