@extends('fashion.layout')

@section('content')
    <!-- Gallery Section -->
    <section id="gallery">
        <h2 class="section-title">Fashion <span>Gallery</span></h2>
        <div class="gallery-grid" id="galleryGrid">
            @include('fashion.partials.gallery')
        </div>
    </section>
@endsection

@push('scripts')
<script>
    const likeUrl = "{{ route('photos.like', ['photo' => ':id']) }}";
    const csrfToken = "{{ csrf_token() }}";
</script>
<script src="{{ asset('js/fashion.js') }}"></script>
@endpush
