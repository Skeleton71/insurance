<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Owner;
use App\Http\Requests\StoreCarRequest;
use App\Http\Requests\UpdateCarRequest;
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

    public function store(StoreCarRequest $request)
    {
        Car::create($request->validated());

        return redirect()->route('cars.index')
            ->with('success', __('messages.car_added_successfully'));
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

    public function update(UpdateCarRequest $request, Car $car)
    {
        $car->update($request->validated());

        return redirect()->route('cars.index')
            ->with('success', __('messages.car_updated_successfully'));
    }

    public function destroy(Car $car)
    {
        $car->delete();

        return redirect()->route('cars.index')
            ->with('success', __('messages.car_deleted_successfully'));
    }
}