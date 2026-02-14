@extends('layouts.core')

@section('title', 'Edit | Family Zones')
    
@section('content')
   @include('dfzones.partials.header')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Edit</h5>
            <div class="card-content p-2">
                {{ Form::model($dfzone, ['route' => ['dfzones.update', $dfzone], 'method' => 'PATCH', 'class' => 'form']) }}
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
