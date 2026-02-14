@extends('layouts.core')
@section('title', 'Narratives')

@section('content')
    @include('narratives.header')
    <div class="card">
        <div class="card-body">
            <div class="card-content p-2">
                <div class="table-responsive">
                    <table class="table table-borderless datatable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Date</th>
                                <th>Title</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($narratives as $i => $item)
                                <tr>
                                    <td scope="row" style="height: {{ count($narratives) == 1? '80px': '' }}">{{ $i+1 }}</td>
                                    <td>{{ dateFormat($item->date) }}</td>
                                    <td>{{ $item->title }}</td>
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
