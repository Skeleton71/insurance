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
                        <h3>Cars</h3>
                        <div>
                            @if(Auth::user()->canEdit())
                                <a href="{{ route('cars.create') }}" class="btn btn-primary">+ Add Car</a>
                            @endif
                            <a href="{{ route('owners.index') }}" class="btn btn-secondary">Owners</a>
                        </div>
                    </div>
                    <div class="card-body">
                        @if($cars->count() > 0)
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Reg Number</th>
                                        <th>Brand</th>
                                        <th>Model</th>
                                        <th>Owner</th>
                                        <th>Created</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($cars as $car)
                                    <tr>
                                        <td>{{ $car->id }}</td>
                                        <td>{{ $car->reg_number }}</td>
                                        <td>{{ $car->brand }}</td>
                                        <td>{{ $car->model }}</td>
                                        <td>{{ $car->owner->full_name }}</td>
                                        <td>{{ $car->created_at->format('d.m.Y H:i') }}</td>
                                        <td>
                                            <a href="{{ route('cars.show', $car) }}" class="btn btn-sm btn-info">View</a>
                                            @if(Auth::user()->canEdit())
                                                <a href="{{ route('cars.edit', $car) }}" class="btn btn-sm btn-warning">Edit</a>
                                                <form action="{{ route('cars.destroy', $car) }}" method="POST" style="display: inline-block;">
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
                            <p class="text-center">No cars found. <a href="{{ route('cars.create') }}">Create one!</a></p>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection