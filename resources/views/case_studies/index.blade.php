@extends('layouts.core')
@section('title', 'Study Testimonials')

@section('content')
    @include('case_studies.header')
    <div class="card">
        <div class="card-body">
            <div class="card-content p-2">
                <div class="table-responsive">
                    <table class="table table-borderless datatable">
                        <thead>
                            <tr>
                                <th scope="col">#No</th>
                                <th scope="col">Date</th>
                                <th scope="col">Title</th>
                                <th scope="col">Full Name</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($case_studies as $i => $item)
                                <tr>
                                    <th scope="row" style="height: {{ count($case_studies) == 1? '80px': '' }}">{{ $i+1 }}</th>
                                    <td>{{ dateFormat($item->date) }}</td>
                                    <td>{{ $item->title }}</td>
                                    <td>{{ $item->full_name }}</td>
                                    <td>{!! $item->action_buttons !!}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop
