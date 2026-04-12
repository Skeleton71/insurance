<?php

namespace App\Http\Controllers;

use App\Models\Owner;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class OwnerController extends Controller implements HasMiddleware
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
        $owners = Owner::with('cars')->get();
        return view('owners.index', compact('owners'));
    }

    public function create()
    {
        return view('owners.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'surname' => 'required'
        ]);

        Owner::create($validated);

        return redirect()->route('owners.index')
            ->with('success', 'Owner added successfully');
    }

    public function show(Owner $owner)
    {
        $owner->load('cars');
        return view('owners.show', compact('owner'));
    }

    public function edit(Owner $owner)
    {
        return view('owners.edit', compact('owner'));
    }

    public function update(Request $request, Owner $owner)
    {
        $validated = $request->validate([
            'name' => 'required',
            'surname' => 'required'
        ]);

        $owner->update($validated);

        return redirect()->route('owners.index')
            ->with('success', 'Owner updated successfully');
    }

    public function destroy(Owner $owner)
    {
        $owner->delete();

        return redirect()->route('owners.index')
            ->with('success', 'Owner deleted successfully');
    }
}