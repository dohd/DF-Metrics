@extends('layouts.core')

@section('title', 'View | Study Materials')
    
@section('content')
    @include('narratives.header')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Summary
                @can('approve-activity-narrative')
                    <span class="badge bg-secondary text-white float-end" role="button" data-bs-toggle="modal" data-bs-target="#status_modal">
                        <i class="bi bi-pencil-fill"></i> Status
                    </span>
                @endcan
            </h5>
            <div class="card-content p-2">
                <table class="table table-bordered">
                    @php
                        $details = [
                            'Date' => dateFormat($narrative->date, 'd-M-Y'),
                            'Subject' => $narrative->subject,
                            'Material' => $narrative->doc_file,
                            'Age Group' => @$narrative->age_group->bracket,
                        ];
                    @endphp
                    @foreach ($details as $key => $val)
                    <tr>
                        <th width="30%">{{ $key }}</th>
                        <td>
                            @if ($key == 'Material' && $val)
                                <a href="{{ route('storage.file_download', 'narrative,' . $narrative->doc_file) }}" target="_blank">{{ $val }}<i class="bi bi-download h5 ms-2"></i></a>
                                <span class="del ms-3" style="cursor: pointer;" name="doc_file"><i class="bi bi-trash text-danger icon-xs"></i></span>
                            @else
                                {{ $val }}
                            @endif
                        </td>
                    </tr>
                    @endforeach
                    @if ($narrative->status == 'review' && $narrative->status_note)
                        <tr>
                            <th width="30%">Review Remark</th>
                            <td>{{ $narrative->status_note }}</td>
                        </tr>
                    @endif
                </table>
            </div>
        </div>
    </div>
    @include('narratives.partial.narrative_status')
@stop

@section('script')
<script>
    $('#status').change(function() {
        if ($(this).val() == 'review') {
            $('#note').parents('.row').removeClass('d-none');
        } else {
            $('#note').parents('.row').addClass('d-none');
        }
    });
    $('#status').change();

    $(document).on('click', '.del', function() {
        const field = $(this).attr('name');
        const narrative_id = @json($narrative->id);
        const url = @json(route('narratives.delete_file'));
        if (confirm('Are you sure?')) {
            $.post(url, {narrative_id, field})
            .done((data) => flashMessage(data))
            .catch((data) => flashMessage(data));
        }
    });
</script>
@endsection
