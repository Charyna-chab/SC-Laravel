<?php

namespace App\Http\Controllers;

use App\Http\Requests\Staff\StoreStaffRequest;
use App\Http\Requests\Staff\UpdateStaffRequest;
use App\Models\Staffs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use NunoMaduro\Collision\Adapters\Phpunit\State;

class StaffsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $staffs = Staffs::all();
        return response()->json([
            'status'=> 'Get Staffs successfully',
            'Staff' => $staffs
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStaffRequest $request)
    {
       $request->validate([
            'name'=> 'required|string|max:255',
            'position'=> 'required|string',
            'description'=> 'required|string',
            'image'=> 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')){
            $imagePath = $request->file('image')->store('Staff','public');
        }

        $staff = Staffs::create([
            'name' => $request->name,
            'position' => $request->position,
            'description' => $request->description,
            'image' => $imagePath
        ]);
        return response()->json([
            'message' => 'Staff create successfully',
            'data' => $staff,
            'image_url' => $imagePath ? asset('storage/' .$imagePath) : null,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $staff = Staffs::findOrFail($id);
        return response()->json([
            'status' => 'Get Staff successfully',
            'Staff' => $staff
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
        public function update(UpdateStaffRequest $request, $id)
    {
        $staff = Staffs::find($id);

        if (!$staff) {
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
            if ($staff->image && Storage::disk('public')->exists($staff->image)) {
                Storage::disk('public')->delete($staff->image);
            }

            // Store new image
            $imagePath = $request->file('image')->store('staffs', 'public');
            $data['image'] = $imagePath;
        }

        // Update staff
        $staff->update($data);

        return response()->json([
            'message' => 'Staff updated successfully',
            'staff' => $staff,
            'image_url' => $data['image'] ?? $staff->image,
        ]);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
       $staff = Staffs::find($id);
        if(!$staff){
            return response()->json([
                'message' => 'Staff not found'
            ],404);
        }
        $staff->delete();
        return response()->json([
            'message' => 'Staff deleted successfully'
        ]);
    }
}
