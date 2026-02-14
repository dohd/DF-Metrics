@extends('layouts.core')
@section('title', 'Study Testimonials')

@section('content')
    @include('testimonials.header')
    <div class="card">
        <div class="card-body">
            <div class="card-content p-2">
                <div class="table-responsive">
                    <table class="table table-borderless datatable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Date</th>
                                <th>Full Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($testimonials as $i => $item)
                                <tr>
                                    <td style="height: {{ count($testimonials) == 1? '80px': '' }}">{{ $i+1 }}</td>
                                    <td>{{ dateFormat($item->date) }}</td>
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
