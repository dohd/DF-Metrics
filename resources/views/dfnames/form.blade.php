<div class="row mb-3">
    <div class="col-md-4 col-12">
        <label for="zones">DF Zone</label>
        <select name="dfzone_id" id="dfzone" class="form-select">
            <option value="">-- Select DF Zone --</option>
            @foreach ($dfzones as $zone)
                <option value="{{ $zone->id }}" {{ @$dfname->zone_id == $zone->id? 'selected' : '' }}>
                    {{ $zone->name }}
                </option>
            @endforeach
        </select>
    </div> 
    <div class="col-md-6 col-12">
        <label for="name">DF Name</label>
        {{ Form::text('name', null, ['class' => 'form-control']) }}
    </div>    
</div>
<br><br>
