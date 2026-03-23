<div class="row mb-3">
    <div class="col-md-6 col-12">
        <label for="name">Family Zone</label>
        {{ Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Name of the family zone', 'required' => 'required']) }}
    </div>
</div>
<div class="row mb-3">
    <div class="col-md-6 col-12">
        <label for="name">Leader</label>
        {{ Form::text('leader', null, ['class' => 'form-control', 'placeholder' => 'Name of the leader']) }}
    </div>    
</div>
<div class="row mb-3"> 
    <div class="col-md-6 col-12">
        <label for="name">Assistant Leader</label>
        {{ Form::text('assistant_leader', null, ['class' => 'form-control', 'placeholder' => 'Name of the assistant leader']) }}
    </div>    
</div>
<br><br>