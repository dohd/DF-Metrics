@extends('layouts.core')
@section('title', 'Narratives')
    
@section('content')
    @include('narratives.header')
    <div class="card">
        <div class="card-body">
            <h6 class="card-title">Narrative Report</h6>
            <div class="card-content p-2">
                <p>Date: <b>{{ dateFormat($narrative->date, 'd-M-Y') }}</b></p>
                <h4 class="text-center text-primary mt-2 mb-2 fw-bold">{{ $narrative->title }}</h4>
                <div class="mb-3">
                    <h5><u>Introduction</u></h5>
                    <div>{!! @$narrative->introduction !!}</div>
                </div>
                <div class="mb-3">
                    <h5><u>Objectives</u></h5>
                    <div>{!! @$narrative->objectives !!}</div>
                </div>
                <div class="mb-3">
                    <h5><u>Activities</u></h5>
                    <div>{!! @$narrative->activities !!}</div>
                </div>
                <div class="mb-3">
                    <h5><u>Challenges</u></h5>
                    <div>{!! @$narrative->challenges !!}</div>
                </div>
                <div class="mb-3">
                    <h5><u>Outcomes</u></h5>
                    <div>{!! @$narrative->outcomes !!}</div>
                </div>
                <div class="mb-3">
                    <h5><u>Reflections</u></h5>
                    <div>{!! @$narrative->reflections !!}</div>
                </div>
                <div class="mb-3">
                    <h5><u>Conclusion</u></h5>
                    <div>{!! @$narrative->conclusion !!}</div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('script')
<script>
    $(document).on('click', '.del', function() {
        const field = $(this).attr('name');
        const case_study_id = @json($narrative->id);
        const url = '#'
        if (confirm('Are you sure?')) {
            $.post(url, {case_study_id, field})
            .done((data) => flashMessage(data))
            .catch((data) => flashMessage(data));
        }
    });
</script>
@endsection

