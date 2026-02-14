@extends('layouts.core')

@section('title', 'Family Member List')
    
@section('content')
    @include('memberlists.partials.header')
    <div class="card">
        <div class="card-body">
            <div class="card-content p-2">
                <div class="overflow-auto">
                    <table class="table table-borderless datatable">
                        <thead>
                            <tr>
                                <th>#No</th>
                                <th>Date</th>
                                <th>DF Name</th>
                                <th>Members</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($memberlists as $i => $row)
                                <tr>
                                    <th scope="row" style="height: {{ count($memberlists) == 1? '80px': '' }}">{{ $i+1 }}</th>
                                    <td>{{ dateFormat($row->date) }}</td>
                                    <td>{{ @$row->dfname->name }}</td>
                                    <td>{{ $row->items->count() }}</td>
                                    <td>{!! $row->action_buttons !!}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop
