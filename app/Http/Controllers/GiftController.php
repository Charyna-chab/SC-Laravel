<?php

namespace App\Http\Controllers;

use App\Models\Gift;
use Illuminate\Http\Request;

class GiftController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Gift::with('options')->get();
    }

    // ✅ Store a new gift
public function store(Request $request)
{
    $validated = $request->validate([
        'key' => 'required|unique:gifts,key',
        'label' => 'required',
        'title' => 'required',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'detail_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'description' => 'nullable|string',
        'options' => 'required|json', // Changed from array to json
    ]);

    // Decode the options JSON
    $options = json_decode($validated['options'], true);
    
    // Validate the decoded options
    validator($options, [
        '*' => 'array',
        '*.label' => 'required|string',
        '*.price' => 'required|numeric',
    ])->validate();

    if ($request->hasFile('image')) {
        $validated['image'] = $request->file('image')->store('gift_images', 'public');
    }

    if ($request->hasFile('detail_image')) {
        $validated['detail_image'] = $request->file('detail_image')->store('gift_detail_images', 'public');
    }

    $gift = Gift::create($validated);

    foreach ($options as $option) {
        $gift->options()->create($option);
    }

    return response()->json(['message' => 'Gift created', 'gift' => $gift->load('options')], 201);
}

    // ✅ Show single gift
    public function show($id)
    {
        $gift = Gift::with('options')->findOrFail($id);
        return response()->json($gift);
    }

    // ✅ Update gift
public function update(Request $request, $id)
{
    $gift = Gift::findOrFail($id);

    $validated = $request->validate([
        'key' => 'required|unique:gifts,key,' . $id,
        'label' => 'required',
        'title' => 'required',
        'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
        'existing_image' => 'sometimes|string',
        'detail_image' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
        'existing_detail_image' => 'sometimes|string',
        'description' => 'nullable|string',
        'options' => 'required|json',
    ]);

    // Handle image updates
    $validated['image'] = $request->hasFile('image') 
        ? $request->file('image')->store('gift_images', 'public')
        : $validated['existing_image'] ?? null;

    $validated['detail_image'] = $request->hasFile('detail_image') 
        ? $request->file('detail_image')->store('gift_detail_images', 'public')
        : $validated['existing_detail_image'] ?? null;

    // Decode and validate options
    $options = json_decode($validated['options'], true);
    validator($options, [
        '*' => 'array',
        '*.label' => 'required|string',
        '*.price' => 'required|numeric',
    ])->validate();

    // Update gift
    $gift->update(array_filter($validated));

    // Update options
    $gift->options()->delete();
    foreach ($options as $option) {
        $gift->options()->create($option);
    }

    return response()->json([
        'message' => 'Gift updated', 
        'gift' => $gift->load('options')
    ]);
}

    // ✅ Delete gift
    public function destroy($id)
    {
        $gift = Gift::findOrFail($id);
        $gift->delete();

        return response()->json(['message' => 'Gift deleted']);
    }
}
