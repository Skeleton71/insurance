@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card mb-4">
                <div class="card-header">
                    <h3>{{ __('Profile') }}</h3>
                </div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label">{{ __('Name') }}</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ Auth::user()->name }}" required>
                            @error('name')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">{{ __('Email') }}</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ Auth::user()->email }}" required>
                            @error('email')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">{{ __('Role') }}</label>
                            <input type="text" class="form-control" value="{{ ucfirst(Auth::user()->role) }}" disabled>
                        </div>

                        <button type="submit" class="btn btn-primary">{{ __('Update Profile') }}</button>
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5>{{ __('Delete Account') }}</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted">Once your account is deleted, there is no going back. Please be certain.</p>

                    <form method="POST" action="{{ route('profile.destroy') }}" style="display: inline-block;">
                        @csrf
                        @method('DELETE')
                        <input type="password" name="password" class="form-control mb-3" placeholder="Enter your password" required>
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete your account?')">{{ __('Delete Account') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
