<?php

namespace App\Http\Controllers;

use App\Http\Requests\Volunteer\StoreVolunteerRequest;
use App\Http\Requests\Volunteer\UpdateVolunteerRequest;
use App\Models\VolunteerProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VolunteerProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $volunteers = VolunteerProfile::all();
        return response()->json([
            'status' => 'Get Volunteers successfully',
            'Volunteers' => $volunteers
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreVolunteerRequest $request)
    {
        $request->validate([
            'name' => 'required|string',
            'nationality' => 'required|string',
            'description' => 'required|string',
            'profile' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('profile')){
            $imagePath = $request->file('profile')->store('Volunteer','public');
        }

        $volunteer = VolunteerProfile::create([
            'name' => $request->name,
            'nationality' => $request->nationality,
            'description' => $request->description,
            'profile' => $imagePath
        ]);
        return response()->json([
            'message' => 'Staff create successfully',
            'data' => $volunteer,
            'image_url' => $imagePath ? asset('storage/' .$imagePath) : null,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
         $volunteer = VolunteerProfile::findOrFail($id);
        return response()->json([
            'status' => 'Get Volunteer successfully',
            'Volunteer' => $volunteer
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateVolunteerRequest $request, $id)
    {
        $volunteer = VolunteerProfile::find($id);

        if (!$volunteer) {
            return response()->json([
                'status' => 'error',
                'message' => 'Volunteer not found'
            ], 404);
        }

        $data = $request->only(['name', 'nationality', 'description']);

        if ($request->hasFile('profile')) {
            if ($volunteer->profile && Storage::disk('public')->exists($volunteer->profile)) {
                Storage::disk('public')->delete($volunteer->profile);
            }

            $imagePath = $request->file('profile')->store('Volunteer', 'public');
            $data['profile'] = $imagePath;
        }

        $volunteer->update($data);

        return response()->json([
            'message' => 'Volunteer updated successfully',
            'volunteer' => $volunteer,
            'image_url' => isset($data['profile']) 
                ? asset('storage/' . $data['profile']) 
                : asset('storage/' . $volunteer->profile),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $volunteer = VolunteerProfile::find($id);
        if(!$volunteer){
            return response()->json([
                'message' => 'Volunteer not found'
            ],404);
        }
        $volunteer->delete();
        return response()->json([
            'message' => 'Volunteer deleted successfully'
        ]);
    }
}
