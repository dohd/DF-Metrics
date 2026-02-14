@extends('layouts.core')
@section('title', 'Study Testimonials')
    
@section('content')
    @include('testimonials.header')
    <div class="card">
        <div class="card-body">
            <h6 class="card-title">Testimonials</h6>
            <div class="card-content p-2">
                <p>Date: <b>{{ dateFormat($testimonial->date, 'd-M-Y') }}</b></p>
                <h4 class="text-center text-primary mt-2 mb-2 fw-bold">{{ $testimonial->title }}</h4>
                <div class="mb-3">
                    <h5><u>Situation (Before intervention)</u></h5>
                    <div>{!! @$testimonial->situation !!}</div>
                </div>
                <div class="mb-3">
                    <h5><u>Project Intervention</u></h5>
                    <div>{!! @$testimonial->intervention !!}</div>
                </div>
                <div class="mb-3">
                    <h5><u>Impact (Intervention Results)</u></h5>
                    <div>{!! @$testimonial->impact !!}</div>
                </div>
                <div class="row">
                    @php
                        $images = [$testimonial->image1, $testimonial->image2, $testimonial->image3];
                    @endphp
                    @if (array_filter($images))
                        <h5><u>Images</u></h5>
                    @endif
                    
                    @if (isset($images[0]))
                        <div class="col-md-4">
                            <div style="width: 300px; height: 250px;">
                                <img src="{{ route('storage.file_render', 'images,testimonials,' . $images[0]) }}" alt="image1" style="width: 100%; height: 100%; border-radius: 8px;">
                            </div>
                            <div>
                                {{ $testimonial->caption1 }}
                                <span class="float-end del" style="cursor: pointer;" name="image1">
                                    <i class="bi bi-trash text-danger icon-xs"></i>
                                </span>
                            </div>
                        </div>
                    @endif
                    @if (isset($images[1]))
                        <div class="col-md-4">
                            <div style="width: 300px; height: 250px;">
                                <img src="{{ route('storage.file_render', 'images,testimonials,' . $images[1]) }}" alt="image1" style="width: 100%; height: 100%; border-radius: 8px;">
                            </div>
                            <div>
                                {{ $testimonial->caption2 }}
                                <span class="float-end del" style="cursor: pointer;" name="image2">
                                    <i class="bi bi-trash text-danger icon-xs"></i>
                                </span>
                            </div>
                        </div>
                    @endif
                    @if (isset($images[2]))
                        <div class="col-md-4">
                            <div style="width: 300px; height: 250px;">
                                <img src="{{ route('storage.file_render', 'images,testimonials,' . $images[2]) }}" alt="image1" style="width: 100%; height: 100%; border-radius: 8px;">
                            </div>
                            <div>
                                {{ $testimonial->caption3 }}
                                <span class="float-end del" style="cursor: pointer;" name="image3">
                                    <i class="bi bi-trash text-danger icon-xs"></i>
                                </span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@stop

@section('script')
<script>
    $(document).on('click', '.del', function() {
        const field = $(this).attr('name');
        const testimonial_id = @json($testimonial->id);
        const url = @json(route('testimonials.delete_image'));
        if (confirm('Are you sure?')) {
            $.post(url, {testimonial_id, field})
            .done((data) => flashMessage(data))
            .catch((data) => flashMessage(data));
        }
    });
</script>
@endsection

