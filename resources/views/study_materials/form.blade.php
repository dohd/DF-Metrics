<div class="row g-0 mb-3">
    <div class="col-md-2 col-12"><label for="date">Date<span class="text-danger">*</span></label></div>
    <div class="col-md-8 col-12">
        {{ Form::date('date', null, ['class' => 'form-control', 'required']) }}
    </div>
</div>
<div class="row g-0 mb-3">
    <div class="col-md-2 col-12"><label for="subject">Subject<span class="text-danger">*</span></label></div>
    <div class="col-md-8 col-12">
        {{ Form::text('subject', null, ['class' => 'form-control', 'required']) }}
    </div>
</div>
<div class="row g-0 mb-3">
    <div class="col-md-2 col-12"><label for="doc_file">Material</label></div>
    <div class="col-md-8 col-12">
        {{ Form::file('doc_file', ['class' => 'form-control', 'id' => 'doc_file', 'accept' => '.csv, .pdf, .xls, .xlsx, .doc, .docx' ]) }}
    </div>
</div>
<br>

@section('script')
<script>    
</script>
@stop