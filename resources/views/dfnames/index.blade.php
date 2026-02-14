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
                            <th scope="col">#No</th>
                            <th scope="col">DF Name</th>
                            <th scope="col">DF Zone</th>
                            <th scope="col">Action</th>
                          </tr>
                        </thead>
                        <tbody>
                            @foreach ($dfnames as $i => $cohort)
                                <tr>
                                    <th scope="row">{{ $i+1 }}</th>
                                    <td>{{ $cohort->name }}</td>
                                    <td>{{ @$cohort->dfzone->name }}</td>
                                    <td>{!! $cohort->action_buttons !!}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop
