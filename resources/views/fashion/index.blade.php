@extends('fashion.layout')

@section('content')
    <!-- Hero Section -->
    <section class="hero" id="home">
        <div class="hero-content">
            <h1>Fashion Week Lyceum of Subic Bay</h1>
            <p>Showcase your style, vote for your favorites, and crown the Fashion Week Champion at Lyceum of Subic Bay!</p>
            <div class="hero-buttons">
                <a href="{{ route('fashion.upload') }}" class="btn btn-primary">Submit Your Look</a>
                <a href="{{ route('fashion.gallery') }}" class="btn btn-secondary">View Gallery</a>
            </div>
        </div>
    </section>

    @push('scripts')
<script src="{{ asset('js/fashion.js') }}"></script>
@endpush
