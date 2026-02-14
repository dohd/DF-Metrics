@extends('layouts.core')

@section('title', 'Edit | Departments')
    
@section('content')
    @include('departments.partials.header')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Edit</h5>
            <div class="card-content p-2">
                {{ Form::model($department, ['route' => ['departments.update', $department], 'method' => 'PATCH', 'class' => 'form']) }}
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
