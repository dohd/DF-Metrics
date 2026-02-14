@extends('layouts.core')
@section('title', 'Study Materials')
    
@section('content')
    @include('study_materials.header')    
    <div class="card">
        <div class="card-body">
            <div class="card-content p-2">
                <div class="table-responsive">
                    <table class="table table-borderless datatable">
                        <thead>
                        <tr>
                            <th>#No</th>
                            <th>Date</th>
                            <th>Subject</th>
                            <th>Material</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($study_materials as $i => $study_material)
                                <tr>
                                    <td style="height: {{ count($study_materials) == 1? '80px': '' }}">{{ $i+1 }}</td>
                                    <td>{{ dateFormat($study_material->date) }}</td>
                                    <td>{{ $study_material->subject }}</td>
                                    <td>
                                        @if ($study_material->doc_file )
                                        <a href="{{ route('storage.file_download', "study_material,{$study_material->doc_file}") }}">
                                            {{ $study_material->doc_file }}<i class="bi bi-download h5 ms-2"></i>
                                        </a>
                                        @endif
                                    </td>
                                    <td>{!! $study_material->action_buttons !!}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop
