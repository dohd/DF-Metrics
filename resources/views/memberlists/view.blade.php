@extends('layouts.core')
@section('title', 'View | Member-list Management')
    
@section('content')
    @include('memberlists.partials.header')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Member-list Details</h5>
            <div class="card-content p-2">
                <table class="table table-bordered">
                    @php
                        $details = [
                            'Date' => dateFormat($memberlist->date, 'd-M-Y'),
                            'DF Name' => @$memberlist->dfname->name,                            
                        ];
                    @endphp
                    @foreach ($details as $key => $val)
                        <tr>
                            <th width="30%">{{ $key }}</th>
                            <td>{{ $val}}</td>
                        </tr>
                    @endforeach
                </table>

                <!-- participants -->     
                <div class="table-responsive">
                    <table class="table table-cstm" id="participants_tbl">
                        <thead>
                            <tr class="table-primary">
                                <th>#</th>
                                <th>Member Name</th>
                                <th>Residence</th>
                                <th>Phone No.</th>
                                <th>Gender</th>
                                <th>Age Group</th>                                
                                <th>Ministry</th>
                                <th>Department</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($memberlist->items as $i => $item)
                                <tr>
                                    <td class="p-3 num">{{ $i+1 }}</td>
                                    <td>{{ $item->member_name }}</td>
                                    <td>{{ $item->residence }}</td>
                                    <td>{{ $item->phone_no }}</td>
                                    <td>{{ $item->gender }}</td>
                                    <td>{{ @$item->age_group->bracket }}</td>
                                    <td>{{ @$item->ministry->name }}</td>
                                    <td>{{ @$item->department->name }}</td>                          
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div> 
            </div>
        </div>
    </div>
@stop

@section('script')
<script>
    $(document).on('click', '.del', function() {
        const field = $(this).attr('name');
        const memberlist_id = @json($memberlist->id);
        if (confirm('Are you sure?')) {
            $.post(url, {memberlist_id, field})
            .done((data) => flashMessage(data))
            .catch((data) => flashMessage(data));
        }
    });
</script>
@endsection