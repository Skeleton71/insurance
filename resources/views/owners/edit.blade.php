@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3>{{ __('messages.edit_owner') }}</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('owners.update', $owner) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="name" class="form-label">{{ __('messages.name_field') }}</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name', $owner->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="surname" class="form-label">{{ __('messages.surname') }}</label>
                            <input type="text" class="form-control @error('surname') is-invalid @enderror" 
                                   id="surname" name="surname" value="{{ old('surname', $owner->surname) }}" required>
                            @error('surname')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">{{ __('messages.account_created') }}</label>
                            <input type="text" class="form-control" value="{{ $owner->created_at->format('d.m.Y H:i') }}" disabled>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('owners.index') }}" class="btn btn-secondary">{{ __('messages.cancel') }}</a>
                            <button type="submit" class="btn btn-primary">{{ __('messages.update_owner') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection