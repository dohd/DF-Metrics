@extends('layouts.core')

@section('title', 'Edit | Study Materials')
    
@section('content')
    @include('study_materials.header')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Edit</h5>
            <div class="card-content p-2">
                {{ Form::model($study_material, ['route' => ['study_materials.update', $study_material], 'method' => 'PATCH', 'files' => true, 'class' => 'form']) }}
                    @include('study_materials.form')
                    <div class="text-center">
                        <a href="{{ route('study_materials.index') }}" class="btn btn-secondary">Cancel</a>
                        {{ Form::submit('Submit', ['class' => 'btn btn-primary']) }}
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
@stop
