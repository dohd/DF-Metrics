@extends('layouts.core')

@section('title', 'Edit | Ministries')
    
@section('content')
    @include('ministries.partials.header')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Edit</h5>
            <div class="card-content p-2">
                {{ Form::model($ministry, ['route' => ['ministries.update', $ministry], 'method' => 'PATCH', 'class' => 'form']) }}
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
