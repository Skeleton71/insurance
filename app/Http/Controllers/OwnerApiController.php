<?php

namespace App\Http\Controllers;

use App\Models\Owner;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class OwnerApiController extends Controller
{
    public function index(): JsonResponse
    {
        $owners = Owner::with('cars')->get();
        return response()->json($owners);
    }
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
        ]);

        $owner = Owner::create($request->only(['name', 'surname']));
        return response()->json($owner, 201);
    }


    public function show(Owner $owner): JsonResponse
    {
        $owner->load('cars');
        return response()->json($owner);
    }

    public function update(Request $request, Owner $owner): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
        ]);

        $owner->update($request->only(['name', 'surname']));
        return response()->json($owner);
    }

    public function destroy(Owner $owner): JsonResponse
    {
        $owner->delete();
        return response()->json(['message' => 'Owner deleted successfully']);
    }
}