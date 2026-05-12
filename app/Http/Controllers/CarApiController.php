<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Owner;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CarApiController extends Controller
{
    public function index(): JsonResponse
    {
        $cars = Car::with('owner', 'photos')->get();
        return response()->json($cars);
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'reg_number' => 'required|string|max:255|unique:cars',
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'owner_id' => 'required|exists:owners,id',
        ]);

        $car = Car::create($request->only(['reg_number', 'brand', 'model', 'owner_id']));
        return response()->json($car->load('owner'), 201);
    }
    public function show(Car $car): JsonResponse
    {
        $car->load('owner', 'photos');
        return response()->json($car);
    }

    public function update(Request $request, Car $car): JsonResponse
    {
        $request->validate([
            'reg_number' => 'required|string|max:255|unique:cars,reg_number,' . $car->id,
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'owner_id' => 'required|exists:owners,id',
        ]);

        $car->update($request->only(['reg_number', 'brand', 'model', 'owner_id']));
        return response()->json($car->load('owner'));
    }

    public function destroy(Car $car): JsonResponse
    {
        $car->delete();
        return response()->json(['message' => 'Car deleted successfully']);
    }
}