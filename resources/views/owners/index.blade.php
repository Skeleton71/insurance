@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            @if(Auth::user()->isVisitor())
                <div class="alert alert-warning mt-5">
                    <strong>Limited Access</strong>
                    <p>Visitors have limited access. Please contact an administrator for full access.</p>
                </div>
            @else
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3>Car Owners</h3>
                        <div>
                            @if(Auth::user()->canEdit())
                                <a href="{{ route('owners.create') }}" class="btn btn-primary">Add New Owner</a>
                            @endif
                            <a href="{{ route('cars.index') }}" class="btn btn-secondary">Cars</a>
                        </div>
                    </div>
                    <div class="card-body">
                        @if($owners->count() > 0)
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Surname</th>
                                        <th>Created</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($owners as $owner)
                                    <tr>
                                        <td>{{ $owner->id }}</td>
                                        <td>{{ $owner->name }}</td>
                                        <td>{{ $owner->surname }}</td>
                                        <td>{{ $owner->created_at->format('d.m.Y H:i') }}</td>
                                        <td>
                                            @if(Auth::user()->canEdit())
                                                <a href="{{ route('owners.edit', $owner->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                                <form action="{{ route('owners.destroy', $owner->id) }}" method="POST" style="display: inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <p class="text-center">No owners found. <a href="{{ route('owners.create') }}">Create one!</a></p>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection