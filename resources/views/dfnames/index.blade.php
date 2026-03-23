@extends('layouts.core')

@section('title', 'DF Names')
    
@section('content')
    @include('dfnames.partials.header')
    <div class="card">
        <div class="card-body">
            <div class="card-content p-2">
                <div class="table-responsive">
                    <table class="table table-borderless datatable">
                        <thead>
                          <tr>
                            <th>#No</th>
                            <th>DF Name</th>
                            <th>DF Zone</th>
                            <th>Leader</th>
                            <th>Asst. leader</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                            @foreach ($dfnames as $i => $row)
                                <tr>
                                    <td class="fw-bold">{{ $i+1 }}</td>
                                    <td>{{ $row->name }}</td>
                                    <td>{{ @$row->dfzone->name }}</td>
                                    <td>{{ $row->leader }}</td>
                                    <td>{{ $row->assistant_leader }}</td>
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
