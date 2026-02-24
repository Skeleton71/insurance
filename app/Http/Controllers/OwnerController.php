<?php

namespace App\Http\Controllers;

use App\Models\Owner;
use Illuminate\Http\Request;

class OwnerController extends Controller
{
    public function index()
    {
        $owners = Owner::latest()->get();
        return view('owners.index', compact('owners'));
    }

    public function create()
    {
        return view('owners.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
        ]);

        Owner::create($request->all());

        return redirect()->route('owners.index')
            ->with('success', 'Owner created successfully.');
    }

    public function edit(Owner $owner)
    {
        return view('owners.edit', compact('owner'));
    }

    public function update(Request $request, Owner $owner)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
        ]);

        $owner->update($request->all());

        return redirect()->route('owners.index')
            ->with('success', 'Owner updated successfully.');
    }

    public function destroy(Owner $owner)
    {
        $owner->delete();

        return redirect()->route('owners.index')
            ->with('success', 'Owner deleted successfully.');
    }
}