@foreach ($teamMembers as $key => $row)
  @php
    $verifyMember = optional($row->verify_members->sortByDesc('id')->first());
    if (request('metric_id')) {
      $metricMember = optional($row->metricMembers->where('metric_id', request('metric_id'))->where('checked', 1)->first());
    } else {
      $metricMember = optional($row->metricMembers->where('checked', 1)->first());
    }
  @endphp
  <div class="col-12 col-md-6 col-lg-4">
    <div class="form-check border rounded px-3 py-2 h-100">
      <input name="team_member_id[]" id="member-{{ $row->id }}" class="form-check-input member-check" 
        type="checkbox" value="{{ $row->id }}" data-cat="{{ $verifyMember->category }}" {{ $isMetricEdit && $metricMember->checked? 'checked' : '' }}> 
                               
      <label class="form-check-label w-100" for="{{ $row->id }}">
        <div class="d-flex justify-content-between">
          <span>{{ $row->full_name }}</span>
          <input type="number" name="member_collected_amount[]" value="{{ +$metricMember->member_collected_amount }}" class="member-amount form-control form-control-sm w-50 d-none" min="0"> 
          <small class="text-muted text-uppercase">{{ $verifyMember->category }}</small>
        </div>
      </label>
    </div>
  </div>
@endforeach                

