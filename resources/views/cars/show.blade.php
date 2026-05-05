@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3>{{ __('messages.car_details') }}</h3>
                    <div>
                        <a href="{{ route('cars.edit', $car) }}" class="btn btn-warning btn-sm">{{ __('messages.edit') }}</a>
                        <a href="{{ route('cars.index') }}" class="btn btn-secondary btn-sm">{{ __('messages.back_to_list') }}</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p class="text-muted mb-0">{{ __('messages.registration_number') }}</p>
                            <p class="fw-bold fs-5">{{ $car->reg_number }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="text-muted mb-0">{{ __('messages.brand') }}</p>
                            <p class="fw-bold fs-5">{{ $car->brand }}</p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p class="text-muted mb-0">{{ __('messages.model') }}</p>
                            <p class="fw-bold fs-5">{{ $car->model }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="text-muted mb-0">{{ __('messages.owner') }}</p>
                            <p class="fw-bold fs-5">
                                <a href="{{ route('owners.show', $car->owner) }}">
                                    {{ $car->owner->full_name }}
                                </a>
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <p class="text-muted mb-0">{{ __('messages.created') }}</p>
                            <p class="fw-bold">{{ $car->created_at->format('d.m.Y H:i') }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="text-muted mb-0">{{ __('messages.last_updated') }}</p>
                            <p class="fw-bold">{{ $car->updated_at->format('d.m.Y H:i') }}</p>
                        </div>
                    </div>

                    @if($car->photos->count() > 0)
                    <div class="mt-4">
                        <h4>{{ __('messages.current_photos') }}</h4>
                        <div class="row">
                            @foreach($car->photos as $photo)
                            <div class="col-md-4 mb-3">
                                <div class="card">
                                    <img src="{{ $photo->url }}" class="card-img-top" alt="{{ $photo->original_name }}" style="height: 200px; object-fit: cover;">
                                    <div class="card-body p-2">
                                        <p class="card-text small">{{ $photo->original_name }}</p>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection