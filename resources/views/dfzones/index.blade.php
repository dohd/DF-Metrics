@extends('layouts.core')

@section('title', 'Family Zones')
    
@section('content')
    @include('dfzones.partials.header')
    <div class="card">
        <div class="card-body">
            <div class="card-content p-2">
                <div class="table-responsive">
                    <table class="table table-borderless datatable">
                        <thead>
                        <tr>
                            <th scope="col">#No.</th>
                            <th scope="col">Family Zone</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($dfzones as $i => $programme)
                                <tr>
                                    <th scope="row">{{ $i+1 }}</th>
                                    <td>{{ $programme->name }}</td>
                                    <td>{!! $programme->action_buttons !!}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop
