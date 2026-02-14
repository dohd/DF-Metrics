<div class="row mb-3">
    <div class="col-md-2 col-12">
        <label for="date">Date</label>
        {{ Form::date('date', null, ['class' => 'form-control', 'required' => 'required']) }}
    </div>
    <div class="col-md-6 col-12">
        <label for="dfname">DF Name</label>
        <select name="dfname_id" id="dfname" class="form-select">
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
        isFirstItemUndeletable: true,
    });

    // config select2 on default stat-group
    {{-- ['region', 'cohort', 'age-group', 'disability'].forEach(function(v) {
        $('#' + v).css('width', '100%').select2({allowClear: true});
    }); --}}

    // on add row config select2
    $('.add-row').click(function() {
        $('.stat-group').each(function(i) {
            if (i == 0) return;
            $(this).find('select').each(function() {
                let id = $(this).attr('id');
                $(this).attr('id', id + i);
                $(this).css('width', '100%').select2({allowClear: true});
                let el = $(this);
                if (id.includes('region')) {
                    let regions = activityData.regions || [];
                    regions.forEach(v => el.append(`<option value="${v.id}">${v.name}</option>`));
                }
                if (id.includes('cohort')) {
                    let cohorts = activityData.cohorts || [];
                    cohorts.forEach(v => el.append(`<option value="${v.id}">${v.name}</option>`));
                }
            });
        });
    });
</script>
@stop
