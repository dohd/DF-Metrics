@extends('layouts.core')
@section('title', 'Study Testimonials')
    
@section('content')
    @include('testimonials.header')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Edit</h5>
            <div class="card-content p-2">
                {{ Form::model($testimonial, ['route' => ['testimonials.update', $testimonial], 'method' => 'PATCH', 'files' => true, 'class' => 'form']) }}
                    @include('testimonials.form')
                    <div class="text-center">
                        <a href="{{ route('testimonials.index') }}" class="btn btn-secondary">Cancel</a>
                        {{ Form::submit('Submit', ['class' => 'btn btn-primary']) }}
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
@stop
