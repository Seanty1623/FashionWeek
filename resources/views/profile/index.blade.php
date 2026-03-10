{{-- Extended from fashion layout --}}
@extends('fashion.layout')

@section('title', 'Your Profile')

@section('content')
@php use Illuminate\Support\Facades\Storage; @endphp
<section id="profile" style="padding: 100px 0;">
    <div class="upload-container" style="max-width: 800px;">
        <h2 class="section-title">Your <span>Profile</span></h2>

        <div style="background: #1a1a1a; padding: 30px; border-radius: 10px; margin-top: 30px;">
            <div style="margin-bottom: 20px;">
                <p style="color: #888; font-size: 0.9rem;">Name</p>
                <p style="color: #fff; font-size: 1.1rem; margin-top: 5px;">{{ auth()->user()->name }}</p>
            </div>
            
            <div style="margin-bottom: 20px;">
                <p style="color: #888; font-size: 0.9rem;">Email</p>
                <p style="color: #fff; font-size: 1.1rem; margin-top: 5px;">{{ auth()->user()->email }}</p>
            </div>

            <div style="margin-bottom: 20px;">
                <p style="color: #888; font-size: 0.9rem;">Joined</p>
                <p style="color: #fff; font-size: 1.1rem; margin-top: 5px;">{{ auth()->user()->created_at->format('F j, Y') }}</p>
            </div>

            <div style="display: flex; gap: 15px; margin-top: 30px;">
                <a href="{{ route('profile.edit') }}" class="btn btn-primary">
                    Edit Profile
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-secondary">
                        Log Out
                    </button>
                </form>
            </div>

        {{-- Instagram-style photo grid --}}
        <div style="margin-top: 50px;">
            <h3 class="section-title" style="font-size: 1.5rem;">Your <span>Posts</span></h3>
            
            @if($photos->isEmpty())
                <div style="background: #1a1a1a; padding: 40px; border-radius: 10px; margin-top: 20px; text-align: center;">
                    <p style="color: #888; font-size: 1rem;">You haven't uploaded any posts yet.</p>
                    <a href="{{ route('fashion.upload') }}" class="btn btn-primary" style="margin-top: 20px; display: inline-block;">
                        Upload Your First Post
                    </a>
                </div>
            @else
                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 15px; margin-top: 20px;">
                    @foreach($photos as $photo)
                        <div class="photo-card" style="position: relative; aspect-ratio: 1; overflow: hidden; border-radius: 8px; cursor: pointer;">
                            <img src="{{ Storage::url($photo->image) }}" alt="{{ $photo->student_name }}" style="width: 100%; height: 100%; object-fit: cover;">
                            <div class="photo-overlay" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.6); display: flex; align-items: center; justify-content: center; opacity: 0; transition: opacity 0.3s; gap: 20px;">
                                <span style="color: #fff; font-size: 1.2rem;">❤️ {{ $photo->likes_count }}</span>
                            </div>
                    @endforeach
                </div>
                
                <div style="margin-top: 20px; text-align: center;">
                    <p style="color: #888;">Total Posts: {{ $photos->count() }}</p>
                </div>
            @endif
        </div>
</section>

<style>
.photo-card:hover .photo-overlay {
    opacity: 1 !important;
}
</style>
@endsection
