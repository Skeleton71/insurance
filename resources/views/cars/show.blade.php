@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3>Car Details</h3>
                    <div>
                        <a href="{{ route('cars.edit', $car) }}" class="btn btn-warning btn-sm">Edit</a>
                        <a href="{{ route('cars.index') }}" class="btn btn-secondary btn-sm">Back to List</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p class="text-muted mb-0">Registration Number</p>
                            <p class="fw-bold fs-5">{{ $car->reg_number }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="text-muted mb-0">Brand</p>
                            <p class="fw-bold fs-5">{{ $car->brand }}</p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p class="text-muted mb-0">Model</p>
                            <p class="fw-bold fs-5">{{ $car->model }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="text-muted mb-0">Owner</p>
                            <p class="fw-bold fs-5">
                                <a href="{{ route('owners.show', $car->owner) }}">
                                    {{ $car->owner->full_name }}
                                </a>
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <p class="text-muted mb-0">Created</p>
                            <p class="fw-bold">{{ $car->created_at->format('d.m.Y H:i') }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="text-muted mb-0">Last Updated</p>
                            <p class="fw-bold">{{ $car->updated_at->format('d.m.Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection