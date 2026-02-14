<style>
    .richtext {
        height: 25vh;
    }
</style>
<div class="row mb-3">
    <div class="col-md-2 col-12">
        <label for="date">Date<span class="text-danger">*</span></label>
        {{ Form::date('date', null, ['class' => 'form-control datepicker', 'id' => 'date', 'required' => 'required']) }}
    </div>
    <div class="col-md-8 col-12">
        <label for="title">Title<span class="text-danger">*</span></label>
        {{ Form::text('title', null, ['class' => 'form-control', 'placeholder' => 'Title', 'required' => 'required']) }}
    </div>
</div>
<div class="row mb-3">
    <div class="col-md-10 col-12">
        <label for="introduction">Introduction</label>
        {{ Form::hidden('introduction', null, ['id' => 'introduction']) }}
        <div class="richtext" id="introduction_text">{!! @$narrative->introduction !!}</div>
    </div>
</div>
<div class="row mb-3">
    <div class="col-md-10 col-12">
        <label for="objectives">Objectives</label>
        {{ Form::hidden('objectives', null, ['id' => 'objectives']) }}
        <div class="richtext" id="objectives_text">{!! @$narrative->objectives !!}</div>
    </div>
</div>
<div class="row mb-3">
    <div class="col-md-10 col-12">
        <label for="activities">Activities</label>
        {{ Form::hidden('activities', null, ['id' => 'activities']) }}
        <div class="richtext" id="activities_text">{!! @$narrative->activities !!}</div>
    </div>
</div>
<div class="row mb-3">
    <div class="col-md-10 col-12">
        <label for="challenges">Challenges</label>
        {{ Form::hidden('challenges', null, ['id' => 'challenges']) }}
        <div class="richtext" id="challenges_text">{!! @$narrative->challenges !!}</div>
    </div>
</div>
<div class="row mb-3">
    <div class="col-md-10 col-12">
        <label for="outcomes">Outcomes</label>
        {{ Form::hidden('outcomes', null, ['id' => 'outcomes']) }}
        <div class="richtext" id="outcomes_text">{!! @$narrative->outcomes !!}</div>
    </div>
</div>
<div class="row mb-3">
    <div class="col-md-10 col-12">
        <label for="reflections">Reflections</label>
        {{ Form::hidden('reflections', null, ['id' => 'reflections']) }}
        <div class="richtext" id="reflections_text">{!! @$narrative->reflections !!}</div>
    </div>
</div>
<div class="row mb-3">
    <div class="col-md-10 col-12">
        <label for="conclusion">Conclusion</label>
        {{ Form::hidden('conclusion', null, ['id' => 'conclusion']) }}
        <div class="richtext" id="conclusion_text">{!! @$narrative->conclusion !!}</div>
    </div>
</div>

@section('script')
<script>
    // highlight required fields
    $('input,select,textarea').on('keyup focusout', function() {
        $('label.error').addClass('text-danger');
    });

    // form submit
    $(".form").validate({
        submitHandler: function (form) {
            event.preventDefault();
            const formData = new FormData(form);
            $.ajax({
                url: $(form).attr('action'),
                type: 'POST',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
            }).done((data) => flashMessage(data))
            .catch((data) => flashMessage(data));
        },
    });
</script>
@stop