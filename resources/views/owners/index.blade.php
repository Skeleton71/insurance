@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            @if(Auth::user()->isVisitor())
                <div class="alert alert-warning mt-5">
                    <strong>{{ __('messages.limited_access') }}</strong>
                    <p>{{ __('messages.visitor_message') }}</p>
                </div>
            @else
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3>{{ __('messages.owners') }}</h3>
                        <div>
                            @if(Auth::user()->canEdit())
                                <a href="{{ route('owners.create') }}" class="btn btn-primary">{{ __('messages.add_owner') }}</a>
                            @endif
                            <a href="{{ route('cars.index') }}" class="btn btn-secondary">{{ __('messages.cars') }}</a>
                        </div>
                    </div>
                    <div class="card-body">
                        @if($owners->count() > 0)
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>{{ __('messages.id') }}</th>
                                        <th>{{ __('messages.name_field') }}</th>
                                        <th>{{ __('messages.surname') }}</th>
                                        <th>{{ __('messages.created') }}</th>
                                        <th>{{ __('messages.actions') }}</th>
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
                                                <a href="{{ route('owners.edit', $owner->id) }}" class="btn btn-sm btn-warning">{{ __('messages.edit') }}</a>
                                                <form action="{{ route('owners.destroy', $owner->id) }}" method="POST" style="display: inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('{{ __('messages.are_you_sure') }}')">{{ __('messages.delete') }}</button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <p class="text-center">{{ __('messages.no_owners') }} <a href="{{ route('owners.create') }}">{{ __('messages.create_one') }}</a></p>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection