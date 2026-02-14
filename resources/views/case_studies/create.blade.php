@extends('layouts.core')

@section('title', 'Study Testimonials')
    
@section('content')
    @include('case_studies.header')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Create</h5>
            <div class="card-content p-2">
                {{ Form::open(['route' => 'case_studies.store', 'method' => 'POST', 'files' => true, 'class' => 'form']) }}
                    @include('case_studies.form')
                    <div class="text-center">
                        <a href="{{ route('case_studies.index') }}" class="btn btn-secondary">Cancel</a>
                        {{ Form::submit('Submit', ['class' => 'btn btn-primary']) }}
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
@stop
