<?php

namespace App\Http\Controllers;

use App\Models\Owner;
use App\Http\Requests\StoreOwnerRequest;
use App\Http\Requests\UpdateOwnerRequest;
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

    public function store(StoreOwnerRequest $request)
    {
        Owner::create($request->validated());

        return redirect()->route('owners.index')
            ->with('success', __('messages.owner_added_successfully'));
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

    public function update(UpdateOwnerRequest $request, Owner $owner)
    {
        $owner->update($request->validated());

        return redirect()->route('owners.index')
            ->with('success', __('messages.owner_updated_successfully'));
    }

    public function destroy(Owner $owner)
    {
        $owner->delete();

        return redirect()->route('owners.index')
            ->with('success', __('messages.owner_deleted_successfully'));
    }
}