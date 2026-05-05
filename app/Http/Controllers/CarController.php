<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Owner;
use App\Models\Photo;
use App\Http\Requests\StoreCarRequest;
use App\Http\Requests\UpdateCarRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class CarController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('auth'),
            new Middleware('role:admin,editor,visitor', only: ['index', 'show']),
            new Middleware('role:admin,editor', only: ['create', 'store', 'edit', 'update', 'destroy', 'deletePhoto']),
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
        $car = Car::create($request->validated());

        if ($request->hasFile('photos')) {
            $currentPhotoCount = $car->photos()->count();
            $newPhotoCount = count($request->file('photos'));
            
            if ($currentPhotoCount + $newPhotoCount > 5) {
                $car->delete();
                return redirect()->back()
                    ->withErrors(['photos' => __('messages.photo_limit_exceeded')])
                    ->withInput();
            }

            foreach ($request->file('photos') as $file) {
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('car_photos', $filename, 'public');
                
                Photo::create([
                    'car_id' => $car->id,
                    'filename' => $filename,
                    'path' => $path,
                    'original_name' => $file->getClientOriginalName(),
                ]);
            }
        }

        return redirect()->route('cars.index')
            ->with('success', __('messages.car_added_successfully'));
    }

    public function show(Car $car)
    {
        $car->load(['owner', 'photos']);
        return view('cars.show', compact('car'));
    }

    public function edit(Car $car)
    {
        $owners = Owner::all();
        $car->load('photos');
        return view('cars.edit', compact('car', 'owners'));
    }

    public function update(UpdateCarRequest $request, Car $car)
    {
        $car->update($request->validated());

        if ($request->hasFile('photos')) {
            $currentPhotoCount = $car->photos()->count();
            $newPhotoCount = count($request->file('photos'));
            
            if ($currentPhotoCount + $newPhotoCount > 5) {
                return redirect()->back()
                    ->withErrors(['photos' => __('messages.photo_limit_exceeded')])
                    ->withInput();
            }

            foreach ($request->file('photos') as $file) {
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('car_photos', $filename, 'public');
                
                Photo::create([
                    'car_id' => $car->id,
                    'filename' => $filename,
                    'path' => $path,
                    'original_name' => $file->getClientOriginalName(),
                ]);
            }
        }

        return redirect()->route('cars.index')
            ->with('success', __('messages.car_updated_successfully'));
    }

    public function destroy(Car $car)
    {
        foreach ($car->photos as $photo) {
            Storage::disk('public')->delete($photo->path);
            $photo->delete();
        }

        $car->delete();

        return redirect()->route('cars.index')
            ->with('success', __('messages.car_deleted_successfully'));
    }

    public function deletePhoto(Photo $photo)
    {
        if (!auth()->user()->isEditor()) {
            abort(403);
        }
        Storage::disk('public')->delete($photo->path);
        
        $photo->delete();

        return redirect()->back()
            ->with('success', __('messages.photo_deleted_successfully'));
    }
}