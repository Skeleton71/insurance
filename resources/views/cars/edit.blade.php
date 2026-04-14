@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3>{{ __('messages.edit_car') }}</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('cars.update', $car) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="reg_number" class="form-label">{{ __('messages.registration_number') }}</label>
                            <input type="text" class="form-control @error('reg_number') is-invalid @enderror" 
                                   id="reg_number" name="reg_number" value="{{ old('reg_number', $car->reg_number) }}" required>
                            @error('reg_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="brand" class="form-label">{{ __('messages.brand') }}</label>
                            <input type="text" class="form-control @error('brand') is-invalid @enderror" 
                                   id="brand" name="brand" value="{{ old('brand', $car->brand) }}" required>
                            @error('brand')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="model" class="form-label">{{ __('messages.model') }}</label>
                            <input type="text" class="form-control @error('model') is-invalid @enderror" 
                                   id="model" name="model" value="{{ old('model', $car->model) }}" required>
                            @error('model')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="owner_id" class="form-label">{{ __('messages.owner') }}</label>
                            <select class="form-select @error('owner_id') is-invalid @enderror" 
                                    id="owner_id" name="owner_id" required>
                                <option value="">{{ __('messages.select_owner') }}</option>
                                @foreach($owners as $owner)
                                    <option value="{{ $owner->id }}" {{ old('owner_id', $car->owner_id) == $owner->id ? 'selected' : '' }}>
                                        {{ $owner->full_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('owner_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 p-3 bg-light rounded">
                            <p class="text-muted mb-0">{{ __('messages.current_owner') }}</p>
                            <p class="fw-bold">{{ $car->owner->name }} {{ $car->owner->surname }}</p>
                            <p class="text-muted mb-0">{{ __('messages.account_created') }}</p>
                            <p class="small">{{ $car->owner->created_at->format('d.m.Y H:i') }}</p>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('cars.show', $car) }}" class="btn btn-secondary">{{ __('messages.cancel') }}</a>
                            <button type="submit" class="btn btn-primary">{{ __('messages.update_car') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection