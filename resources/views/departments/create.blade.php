@extends('layouts.core')

@section('title', 'Departments')
    
@section('content')
    @include('departments.partials.header')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Create</h5>
            <div class="card-content p-2">
                {{ Form::open(['route' => 'departments.store', 'method' => 'POST', 'class' => 'form']) }}
                    @include('departments.form')
                    <div class="text-center">
                        <a href="{{ route('departments.index') }}" class="btn btn-secondary">Cancel</a>
                        {{ Form::submit('Submit', ['class' => 'btn btn-primary']) }}
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
@stop
