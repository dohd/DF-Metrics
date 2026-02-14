@extends('layouts.core')

@section('title', 'Edit | Family Member List')
    
@section('content')
    @include('memberlists.partials.header')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Edit</h5>
            <div class="card-content p-2">
                {{ Form::model($memberlist, ['route' => ['memberlists.update', $memberlist], 'method' => 'PATCH', 'files' => true, 'class' => 'form']) }}
                    @include('memberlists.form')
                    <div class="text-center">
                        <a href="{{ route('memberlists.index') }}" class="btn btn-secondary">Cancel</a>
                        {{ Form::submit('Submit', ['class' => 'btn btn-primary']) }}
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
@stop
