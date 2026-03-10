@extends('fashion.layout')

@section('title', 'Leaderboard')

@section('content')
@php use Illuminate\Support\Facades\Storage; @endphp
<section id="leaderboard" class="leaderboard-page">
    <div class="leaderboard-container">
        <h2 class="section-title">Leaderboard</h2>

        @if(!$isWinnerAnnounced)
            <div class="winner-announcement">
                <div class="trophy-emoji">🏆</div>
                <h3 class="winner-soon-title">Winners Will Be Announced Soon!</h3>
                <p class="winner-soon-text">Check back later to see who won the Fashion Week competition.</p>
            </div>
        @else
            <div class="winner-announcement">
                <h3>🏆 Winner Announcement 🏆</h3>
                
                @if($photos->isNotEmpty())
                    @php $winner = $photos->first(); @endphp
                    <div class="winner-card">
                        <div class="trophy">👑</div>
                        <h4>{{ $winner->student_name }}</h4>
                        <p>❤️ {{ $winner->likes_count }} likes</p>
                    </div>
                @endif
            </div>
        @endif

        <div class="all-submissions">
            <h3>All Submissions</h3>
            
            @if($photos->isEmpty())
                <p class="no-submissions">No submissions yet.</p>
            @else
                <div class="submissions-list">
                    @foreach($photos as $index => $photo)
                        <div class="submission-item">
                            <span class="submission-rank">
                                @if($index === 0) 👑 @else #{{ $index + 1 }} @endif
                            </span>
                            @if($photo->image)
                            <img src="{{ Storage::url($photo->image) }}" alt="{{ $photo->student_name }}" class="submission-image">
                            @endif
                            <div class="submission-info">
                                <h4>{{ $photo->student_name }}</h4>
                                <p>{{ $photo->year_level }}</p>
                            </div>
                            <span class="submission-likes">❤️ {{ $photo->likes_count }}</span>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
</section>
@endsection
