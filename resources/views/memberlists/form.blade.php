<div class="row mb-3">
    <div class="col-md-2 col-12">
        <label for="date">Date <span class="text-danger">*</span></label>
        {{ Form::date('date', $memberlist->date ?? date('Y-m-d'), ['class' => 'form-control', 'required' => 'required']) }}
    </div>
    <div class="col-md-2 col-12">
        <label for="dfname">DF Name <span class="text-danger">*</span></label>
        <select name="dfname_id" id="dfname" class="form-select" required>
            <option value="">-- Select DF Name --</option>
            @foreach ($dfnames as $row)
                <option value="{{ $row->id }}" {{ @$memberlist->dfname_id == $row->id? 'selected' : '' }}>
                    {{ $row->name }}
                </option>
            @endforeach
        </select>
    </div> 
</div>

<!-- Statistics section -->
@include('memberlists.partials.stats_section')
<!-- End Statistics section -->

@section('script')
<script>
    // init form repeater
    $('form').repeater({
        {{-- isFirstItemUndeletable: true, --}}
    });

    const memberlist = @json(@$memberlist);
    if (memberlist?.id) {
        $('div[data-repeater-item]:last').remove();
    }
</script>
@stop
