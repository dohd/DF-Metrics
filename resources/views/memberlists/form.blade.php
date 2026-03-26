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

<!-- Members section -->
<div class="row mb-2" data-repeater-list="memberlist_items">
    @foreach ($memberlist->items ?? [] as $row)
        <div class="col-md-12 col-12 my-1 stat-group" data-repeater-item>
            <fieldset class="border rounded-3 p-3">
                <div class="row mb-2">
                    <div class="col-md-2 col-12">
                        <label for="member_name">Member Name <span class="text-danger">*</span></label>
                        {{ Form::text('member_name', $row->member_name, ['class' => 'form-control', 'placeholder' => 'Member Name', 'required' => 'required']) }}
                        {{ Form::hidden('memberlist_item_id', $row->id, ['class' => 'item-id']) }}
                    </div>
                    <div class="col-md-2 col-12">
                        <label for="residence">Residence</label>
                        {{ Form::text('residence', $row->residence, ['class' => 'form-control', 'placeholder' => 'Residence']) }}
                    </div>
                    <div class="col-md-2 col-12">
                        <label for="phone_no">Phone No.</label>
                        {{ Form::text('phone_no', $row->phone_no, ['class' => 'form-control', 'placeholder' => 'Phone No.']) }}
                    </div>
                    <div class="col-md-2 col-12">
                        <label for="gender">Gender <span class="text-danger">*</span></label>
                        <select name="gender" id="gender" class="form-select" required>
                            <option value="">-- Select Gender --</option>
                            @foreach (['Male', 'Female'] as $gender)
                                <option value="{{ $gender }}" {{ $row->gender == $gender? 'selected' : '' }}>
                                    {{ $gender }}
                                </option>
                            @endforeach
                        </select>
                    </div> 
                    <div class="col-md-2 col-12">
                        <label for="age_group">Age Group <span class="text-danger">*</span></label>
                        <select name="age_group_id" id="age-group" class="form-select" data-placeholder="Choose Age-group" required>
                            <option value="">-- Select Age Group--</option>
                            @foreach ($age_groups as $agegroup)
                                <option value="{{ $agegroup->id }}" {{ $agegroup->id == $row->age_group_id? 'selected' : '' }}>{{ $agegroup->bracket }}</option>
                            @endforeach
                        </select>
                    </div>                        
                </div>
                <div class="row mb-2">
                    <div class="col-md-2 col-12">
                        <label for="category">Member Category <span class="text-danger">*</span></label>
                        <select name="category" id="category" class="form-select" data-placeholder="Choose category" required>
                            <option value="">-- Select Category --</option>
                            @foreach (['local', 'diaspora', 'new'] as $category)
                                <option value="{{ $category }}" {{ $category === $row->category? 'selected' : '' }}>{{ ucfirst($category) }}</option>
                            @endforeach
                        </select>
                    </div> 
                    <div class="col-md-2 col-12">
                        <label for="department">Department <span class="text-danger">*</span></label>
                        <select name="department_id" id="department" class="form-select" data-placeholder="Choose Department" required>
                            <option value="">-- Select Department --</option>
                            @foreach ($departments as $department)
                                <option value="{{ $department->id }}" {{ $department->id === $row->department_id? 'selected' : '' }}>{{ $department->name }}</option>
                            @endforeach
                        </select>
                    </div>  
                    <div class="col-md-4 col-12">
                        <label for="ministry">Ministry <span class="text-danger">*</span></label>
                        <select name="ministry_id" class="form-select ministry" data-placeholder="Choose Ministry" multiple required>
                            <option value="">-- Select Ministry --</option>
                            @foreach ($ministries as $ministry)
                                <option value="{{ $ministry->id }}" 
                                    {{ in_array($ministry->id, $row->memberMinistries->pluck('ministry_id')->toArray())? 'selected' : '' }}
                                >
                                    {{ $ministry->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>                     
                    <div class="col-md-2 pt-4">
                        <button type="button" class="btn btn-danger" data-repeater-delete>Delete</button>
                    </div>
                </div>
            </fieldset>
        </div>
    @endforeach
    <div class="col-md-12 col-12 my-1 stat-group" data-repeater-item>
        <fieldset class="border rounded-3 p-3">
            <div class="row mb-2">
                <div class="col-md-2 col-12">
                    <label for="member_name">Member Name</label>
                    {{ Form::text('member_name', null, ['class' => 'form-control', 'placeholder' => 'Member Name', 'required' => 'required']) }}
                    {{ Form::hidden('memberlist_item_id', null) }}
                </div>
                <div class="col-md-2 col-12">
                    <label for="residence">Residence</label>
                    {{ Form::text('residence', null, ['class' => 'form-control', 'placeholder' => 'Residence']) }}
                </div>
                <div class="col-md-2 col-12">
                    <label for="phone_no">Phone No.</label>
                    {{ Form::text('phone_no', null, ['class' => 'form-control', 'placeholder' => 'Phone No.']) }}
                </div>
                <div class="col-md-2 col-12">
                    <label for="gender">Gender <span class="text-danger">*</span></label>
                    <select name="gender" id="gender" class="form-select" required>
                        <option value="">-- Select Gender --</option>
                        @foreach (['Male', 'Female'] as $gender)
                            <option value="{{ $gender }}">
                                {{ $gender }}
                            </option>
                        @endforeach
                    </select>
                </div> 
                <div class="col-md-2 col-12">
                    <label for="age_group">Age Group <span class="text-danger">*</span></label>
                    <select name="age_group_id" id="age-group" class="form-select" data-placeholder="Choose Age-group" required>
                        <option value="">-- Select Age Group --</option>
                        @foreach ($age_groups as $row)
                            <option value="{{ $row->id }}">{{ $row->bracket }}</option>
                        @endforeach
                    </select>
                </div>                        
            </div>
            <div class="row mb-2">
                <div class="col-md-2 col-12">
                    <label for="category">Member Category <span class="text-danger">*</span></label>
                    <select name="category" id="category" class="form-select" data-placeholder="Choose category" required>
                        <option value="">-- Select Category --</option>
                        @foreach (['local', 'diaspora', 'new'] as $category)
                            <option value="{{ $category }}" {{ $category === $row->category? 'selected' : '' }}>{{ ucfirst($category) }}</option>
                        @endforeach
                    </select>
                </div> 
                <div class="col-md-2 col-12">
                    <label for="department">Department <span class="text-danger">*</span></label>
                    <select name="department_id" id="department" class="form-select" data-placeholder="Choose Department" required>
                        <option value="">-- Select Department --</option>
                        @foreach ($departments as $row)
                            <option value="{{ $row->id }}">{{ $row->name }}</option>
                        @endforeach
                    </select>
                </div> 
                <div class="col-md-4 col-12">
                    <label for="ministry">Ministry <span class="text-danger">*</span></label>
                    <select name="ministry_id" class="form-select ministry" data-placeholder="Choose Ministry" multiple required>
                        <option value=""></option>
                        @foreach ($ministries as $row)
                            <option value="{{ $row->id }}">{{ $row->name }}</option>
                        @endforeach
                    </select>
                </div> 
                <div class="col-md-2 pt-4">
                    <button type="button" class="btn btn-danger" data-repeater-delete>Delete</button>
                </div>                  
            </div>
        </fieldset>
    </div>
</div>
<div class="row mb-3">
    <div class="col-md-12 col-12">
        <span class="badge bg-success text-white add-row" role="button" data-repeater-create>
            <i class="bi bi-plus-lg"></i> Add Member
        </span>
    </div>
</div>
<!-- End Members section -->

@section('script')
<script>
    // init select2
    function attachSelect2(el) {
        if (el.length) return el.select2({allowClear: true});        
    }

    // init form repeater
    $('form').repeater({
        isFirstItemUndeletable: false,
        show: function () {
            $(this).slideDown();
            attachSelect2($(this).find('.ministry'));
        },
    });

    const memberlist = @json(@$memberlist);
    if (memberlist?.id) {
        $('div[data-repeater-item]:last').remove();
        $('div[data-repeater-item]').each(function() {
            if ($(this).find('.item-id').val()) {
                attachSelect2($(this).find('.ministry'));
            }
        });
    } else {
        attachSelect2($('.ministry:first'));        
    }
</script>
@stop
