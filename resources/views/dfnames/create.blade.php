@extends('layouts.core')

@section('title', 'DF Names')
    
@section('content')
    @include('dfnames.partials.header')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Create</h5>
            <div class="card-content p-2">
                {{ Form::open(['route' => 'dfnames.store', 'method' => 'POST', 'class' => 'form']) }}
                    @include('dfnames.form')
                    <div class="text-center">
                        <a href="{{ route('dfnames.index') }}" class="btn btn-secondary">Cancel</a>
                        {{ Form::submit('Submit', ['class' => 'btn btn-primary']) }}
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
@stop
