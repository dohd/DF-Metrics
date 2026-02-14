@extends('layouts.core')

@section('title', 'Family Zones')
    
@section('content')
    @include('dfzones.partials.header')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Create</h5>
            <div class="card-content p-2">
                {{ Form::open(['route' => 'dfzones.store', 'method' => 'POST', 'class' => 'form']) }}
                    @include('dfzones.form')
                    <div class="text-center">
                        <a href="{{ route('dfzones.index') }}" class="btn btn-secondary">Cancel</a>
                        {{ Form::submit('Submit', ['class' => 'btn btn-primary']) }}
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
@stop
