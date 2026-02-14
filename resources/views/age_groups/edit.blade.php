@extends('layouts.core')

@section('title', 'Edite | Age Group Management')
    
@section('content')
    @include('age_groups.header')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Age Group Details</h5>
            <div class="card-content p-2">
                {{ Form::model($age_group, ['route' => ['age_groups.update', $age_group], 'method' => 'PATCH', 'class' => 'form']) }}
                    @include('age_groups.form')
                    <div class="text-center">
                        <a href="{{ route('age_groups.index') }}" class="btn btn-secondary">Cancel</a>
                        {{ Form::submit('Submit', ['class' => 'btn btn-primary']) }}
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
@stop
