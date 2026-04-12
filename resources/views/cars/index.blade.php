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
                        <h3>{{ __('messages.cars') }}</h3>
                        <div>
                            @if(Auth::user()->canEdit())
                                <a href="{{ route('cars.create') }}" class="btn btn-primary">{{ __('messages.add_car') }}</a>
                            @endif
                            <a href="{{ route('owners.index') }}" class="btn btn-secondary">{{ __('messages.owners') }}</a>
                        </div>
                    </div>
                    <div class="card-body">
                        @if($cars->count() > 0)
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>{{ __('messages.id') }}</th>
                                        <th>{{ __('messages.reg_number') }}</th>
                                        <th>{{ __('messages.brand') }}</th>
                                        <th>{{ __('messages.model') }}</th>
                                        <th>{{ __('messages.owner') }}</th>
                                        <th>{{ __('messages.created') }}</th>
                                        <th>{{ __('messages.actions') }}</th>
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
                                            <a href="{{ route('cars.show', $car) }}" class="btn btn-sm btn-info">{{ __('messages.view') }}</a>
                                            @if(Auth::user()->canEdit())
                                                <a href="{{ route('cars.edit', $car) }}" class="btn btn-sm btn-warning">{{ __('messages.edit') }}</a>
                                                <form action="{{ route('cars.destroy', $car) }}" method="POST" style="display: inline-block;">
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
                            <p class="text-center">{{ __('messages.no_cars') }} <a href="{{ route('cars.create') }}">{{ __('messages.create_one') }}</a></p>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection