<div class="row mb-3">
    <div class="col-md-2 col-12">
        <label for="date">Date<span class="text-danger">*</span></label>
        {{ Form::date('date', null, ['class' => 'form-control datepicker', 'id' => 'date', 'required']) }}
    </div>
    <div class="col-md-6 col-12">
        <label for="full_name">Full Name<span class="text-danger">*</span> (Testifier)</label>
        {{ Form::text('full_name', null, ['class' => 'form-control', 'placeholder' => 'Full Name', 'required' => 'required']) }}
    </div>
</div>
<div class="row mb-3">
    <div class="col-md-12 col-12">
        <label for="situation">Introduction<span class="text-danger">*</span></label>
        {{ Form::hidden('situation', null, ['id' => 'situation']) }}
        <div class="richtext" id="situation_text">{!! @$testimonial->situation !!}</div>
    </div>
</div>
<div class="row mb-3">
    <div class="col-md-12 col-12">
        <label for="intervention">Experience During The Study<span class="text-danger">*</span></label>
        {{ Form::hidden('intervention', null, ['id' => 'intervention']) }}
        <div class="richtext" id="intervention_text">{!! @$testimonial->intervention !!}</div>
    </div>
</div>
<div class="row mb-3">
    <div class="col-md-12 col-12">
        <label for="impact">Personal Transformation<span class="text-danger">*</span></label>
        {{ Form::hidden('impact', null, ['id' => 'impact']) }}
        <div class="richtext" id="impact_text">{!! @$testimonial->impact !!}</div>
    </div>
</div>
<div class="row mb-3">
    <div class="col-md-4 col-12">
        <label class="form-label" for="file">Image 1</label>
        {{ Form::file('image1', ['class' => 'form-control', 'id' => 'image1', 'accept' => '.png, .jpg, .jpeg' ]) }}
        {{ Form::text('caption1', null, ['class' => 'form-control mt-1', 'placeholder' => 'Image 1 Caption']) }}
    </div>
    <div class="col-md-4 col-12">
        <label class="form-label" for="file">Image 2</label>
        {{ Form::file('image2', ['class' => 'form-control', 'id' => 'image2', 'accept' => '.png, .jpg, .jpeg' ]) }}
        {{ Form::text('caption2', null, ['class' => 'form-control mt-1', 'placeholder' => 'Image 2 Caption']) }}
    </div>
    <div class="col-md-4 col-12">
        <label class="form-label" for="file">Image 3</label>
        {{ Form::file('image3', ['class' => 'form-control', 'id' => 'image3', 'accept' => '.png, .jpg, .jpeg' ]) }}
        {{ Form::text('caption3', null, ['class' => 'form-control mt-1', 'placeholder' => 'Image 3 Caption']) }}
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