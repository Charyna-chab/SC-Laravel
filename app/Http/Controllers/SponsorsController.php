<?php

namespace App\Http\Controllers;

use App\Http\Requests\Sponsor\UpdateSponsorRequest;
use App\Models\Sponsors;
use Illuminate\Http\Request;

class SponsorsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sponsors = Sponsors::all();
        return response()->json([
            'status'=> 'Get Sponsors successfully',
            'Staff' => $sponsors
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=> 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'link'=> 'required|string',
        ]);

        $imagePath = null;
        if ($request->hasFile('logo')){
            $imagePath = $request->file('logo')->store('Sponsor','public');
        }

        $sponsor = Sponsors::create([
            'name' => $request->name,
            'logo' => $imagePath,
            'link' => $request->link,
            
        ]);
        return response()->json([
            'message' => 'Sponsor create successfully',
            'data' => $sponsor,
            'image_url' => $imagePath ? asset('storage/' .$imagePath) : null,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $sponsor = Sponsors::findOrFail($id);
        return response()->json([
            'status' => 'Get Sponsor successfully',
            'Staff' => $sponsor
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSponsorRequest $request, $id)
    {
        $sponsor = Sponsors::find($id);
        if(!$sponsor){
            return response()->json([
                'status' => 'error',
                'message' => 'Sponsor not found'
            ]);
        }
        $sponsor = Sponsors::update($request->validated());
        return response()->json($sponsor);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $sponsor = Sponsors::find($id);
        if(!$sponsor){
            return response()->json([
                'message' => 'Sponsor not found'
            ],404);
        }
        $sponsor->delete();
        return response()->json([
            'message' => 'Sponsor deleted successfully'
        ]);
    }
}
