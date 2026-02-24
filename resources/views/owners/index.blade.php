@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3>Car Owners</h3>
                    <a href="{{ route('owners.create') }}" class="btn btn-primary float-end">Add New Owner</a>
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
                                        <a href="{{ route('owners.edit', $owner->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                        <form action="{{ route('owners.destroy', $owner->id) }}" method="POST" style="display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                        </form>
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
        </div>
    </div>
</div>
@endsection