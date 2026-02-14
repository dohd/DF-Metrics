@extends('layouts.core')

@section('title', 'Age Group Management')
    
@section('content')
    @include('age_groups.header')
    <div class="card">
        <div class="card-body">
            <div class="card-content p-2">
                <div class="table-responsive">
                    <table class="table table-borderless datatable">
                        <thead>
                          <tr>
                            <th scope="col">#No</th>
                            <th scope="col">Age Bracket</th>
                            <th scope="col">Action</th>
                          </tr>
                        </thead>
                        <tbody>
                            @foreach ($age_groups as $i => $age_group)
                                <tr>
                                    <th scope="row">{{ $i+1 }}</th>
                                    <td>{{ $age_group->bracket }}</td>
                                    <td>{!! $age_group->action_buttons !!}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop
