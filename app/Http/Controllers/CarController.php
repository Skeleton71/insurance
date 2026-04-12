<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Owner;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class CarController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('auth'),
            new Middleware('role:admin,editor,visitor', only: ['index', 'show']),
            new Middleware('role:admin,editor', only: ['create', 'store', 'edit', 'update', 'destroy']),
        ];
    }

    public function index()
    {
        $cars = Car::with('owner')->get();
        return view('cars.index', compact('cars'));
    }

    public function create()
    {
        $owners = Owner::all();
        return view('cars.create', compact('owners'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'reg_number' => 'required|unique:cars',
            'brand' => 'required',
            'model' => 'required',
            'owner_id' => 'required|exists:owners,id'
        ]);

        Car::create($validated);

        return redirect()->route('cars.index')
            ->with('success', 'Car added successfully');
    }

    public function show(Car $car)
    {
        $car->load('owner');
        return view('cars.show', compact('car'));
    }

    public function edit(Car $car)
    {
        $owners = Owner::all();
        return view('cars.edit', compact('car', 'owners'));
    }

    public function update(Request $request, Car $car)
    {
        $validated = $request->validate([
            'reg_number' => 'required|unique:cars,reg_number,' . $car->id,
            'brand' => 'required',
            'model' => 'required',
            'owner_id' => 'required|exists:owners,id'
        ]);

        $car->update($validated);

        return redirect()->route('cars.index')
            ->with('success', 'Car updated successfully');
    }

    public function destroy(Car $car)
    {
        $car->delete();

        return redirect()->route('cars.index')
            ->with('success', 'Car deleted successfully');
    }
}