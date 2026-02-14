@if (isset($memberlist))
    <!-- Edit Template -->
    <div class="row mb-2" data-repeater-list="memberlist_items">
        @foreach ($memberlist->items as $row)
            <div class="col-md-12 col-12 my-1 stat-group" data-repeater-item>
                <fieldset class="border rounded-3 p-3">
                    <div class="row mb-2">
                        <div class="col-md-3 col-12">
                            <label for="member_name">Member Name</label>
                            {{ Form::text('member_name', $row->member_name, ['class' => 'form-control', 'placeholder' => 'Member Name']) }}
                        </div>
                        <div class="col-md-3 col-12">
                            <label for="residence">Residence</label>
                            {{ Form::text('residence', $row->residence, ['class' => 'form-control', 'placeholder' => 'Residence']) }}
                        </div>
                        <div class="col-md-3 col-12">
                            <label for="phone_no">Phone No.</label>
                            {{ Form::text('phone_no', $row->phone_no, ['class' => 'form-control', 'placeholder' => 'Phone No.']) }}
                        </div>
                        <div class="col-md-3 col-12">
                            <label for="gender">Gender</label>
                            <select name="gender" id="gender" class="form-select">
                                <option value="">-- Select Gender --</option>
                                @foreach (['Male', 'Female'] as $gender)
                                    <option value="{{ $gender }}" {{ $row->gender == $gender? 'selected' : '' }}>
                                        {{ $gender }}
                                    </option>
                                @endforeach
                            </select>
                        </div>                        
                    </div>

                    <div class="row mb-2">
                        <div class="col-md-3 col-12">
                            <label for="age_group">Age Group</label>
                            <select name="age_group_id" id="age-group" class="form-select" data-placeholder="Choose Age-group">
                                <option value=""></option>
                                @foreach ($age_groups as $agegroup)
                                    <option value="{{ $agegroup->id }}" {{ $agegroup->id == $row->age_group_id? 'selected' : '' }}>{{ $agegroup->bracket }}</option>
                                @endforeach
                            </select>
                        </div>  
                        <div class="col-md-3 col-12">
                            <label for="ministry">Ministry</label>
                            <select name="ministry_id" id="ministry" class="form-select" data-placeholder="Choose Ministry">
                                <option value="">-- Select Ministry --</option>
                                @foreach ($ministries as $ministry)
                                    <option value="{{ $ministry->id }}" {{ $ministry->id == $row->ministry_id? 'selected' : '' }}>{{ $ministry->name }}</option>
                                @endforeach
                            </select>
                        </div> 
                        <div class="col-md-3 col-12">
                            <label for="department">Department</label>
                            <select name="department_id" id="department" class="form-select" data-placeholder="Choose Department">
                                <option value="">-- Select Department --</option>
                                @foreach ($departments as $department)
                                    <option value="{{ $department->id }}" {{ $department->id == $row->department_id? 'selected' : '' }}>{{ $department->name }}</option>
                                @endforeach
                            </select>
                        </div>                       
                        
                        <div class="col-md-3 pt-4">
                            <button type="button" class="btn btn-danger float-end" data-repeater-delete>Delete</button>
                        </div>
                    </div>
                </fieldset>
            </div>
        @endforeach
    </div>
@else
    <!-- Create Template -->
    <div class="row mb-2" data-repeater-list="memberlist_items">
        <div class="col-md-12 col-12 my-1 stat-group" data-repeater-item>
            <fieldset class="border rounded-3 p-3">
                <div class="row mb-2">
                    <div class="col-md-3 col-12">
                        <label for="member_name">Member Name</label>
                        {{ Form::text('member_name', null, ['class' => 'form-control', 'placeholder' => 'Member Name']) }}
                    </div>
                    <div class="col-md-3 col-12">
                        <label for="residence">Residence</label>
                        {{ Form::text('residence', null, ['class' => 'form-control', 'placeholder' => 'Residence']) }}
                    </div>
                    <div class="col-md-3 col-12">
                        <label for="phone_no">Phone No.</label>
                        {{ Form::text('phone_no', null, ['class' => 'form-control', 'placeholder' => 'Phone No.']) }}
                    </div>
                    <div class="col-md-3 col-12">
                        <label for="gender">Gender</label>
                        <select name="gender" id="gender" class="form-select">
                            <option value="">-- Select Gender --</option>
                            @foreach (['Male', 'Female'] as $gender)
                                <option value="{{ $gender }}">
                                    {{ $gender }}
                                </option>
                            @endforeach
                        </select>
                    </div>                        
                </div>

                <div class="row mb-2">
                    <div class="col-md-3 col-12">
                        <label for="age_group">Age Group</label>
                        <select name="age_group_id" id="age-group" class="form-select" data-placeholder="Choose Age-group">
                            <option value="">-- Select Age Group --</option>
                            @foreach ($age_groups as $row)
                                <option value="{{ $row->id }}">{{ $row->bracket }}</option>
                            @endforeach
                        </select>
                    </div> 
                    <div class="col-md-3 col-12">
                        <label for="ministry">Ministry</label>
                        <select name="ministry_id" id="ministry" class="form-select" data-placeholder="Choose Ministry">
                            <option value="">-- Select Ministry --</option>
                            @foreach ($ministries as $row)
                                <option value="{{ $row->id }}">{{ $row->name }}</option>
                            @endforeach
                        </select>
                    </div> 
                    <div class="col-md-3 col-12">
                        <label for="department">Department</label>
                        <select name="department_id" id="department" class="form-select" data-placeholder="Choose Department">
                            <option value="">-- Select Department --</option>
                            @foreach ($departments as $row)
                                <option value="{{ $row->id }}">{{ $row->name }}</option>
                            @endforeach
                        </select>
                    </div> 
                    
                    <div class="col-md-3 pt-4">
                        <button type="button" class="btn btn-danger float-end" data-repeater-delete>Delete</button>
                    </div>                   
                </div>
            </fieldset>
        </div>
    </div>
@endif

<div class="row mb-3">
    <div class="col-md-12 col-12">
        <span class="badge bg-success text-white add-row" role="button" data-repeater-create>
            <i class="bi bi-plus-lg"></i> Row
        </span>
    </div>
</div>
