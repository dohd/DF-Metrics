@extends('layouts.core')

@section('title', 'Ministries')
    
@section('content')
    @include('ministries.partials.header')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Create</h5>
            <div class="card-content p-2">
                {{ Form::open(['route' => 'ministries.store', 'method' => 'POST', 'class' => 'form']) }}
                    @include('ministries.form')
                    <div class="text-center">
                        <a href="{{ route('ministries.index') }}" class="btn btn-secondary">Cancel</a>
                        {{ Form::submit('Submit', ['class' => 'btn btn-primary']) }}
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
@stop
