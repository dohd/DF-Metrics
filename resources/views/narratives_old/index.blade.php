@extends('layouts.core')

@section('title', 'Study Materials')
    
@section('content')
    @include('narratives.header')    
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
                            @foreach ($narratives as $i => $narrative)
                                <tr>
                                    <th style="height: {{ count($narratives) == 1? '80px': '' }}">{{ $i+1 }}</th>
                                    <td>{{ dateFormat($narrative->date) }}</td>
                                    <td>{{ $narrative->subject }}</td>
                                    <td>
                                        @if ($narrative->doc_file )
                                        <a href="{{ route('storage.file_download', 'narrative,' . $narrative->doc_file) }}" target="_blank">{{ $narrative->doc_file }}<i class="bi bi-download h5 ms-2"></i></a>
                                        @endif
                                    </td>
                                    <td>{!! $narrative->action_buttons !!}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop
