@php use Illuminate\Support\Facades\Storage; @endphp
@if($photos->isEmpty())
    <div class="empty-leaderboard" style="text-align: center; padding: 4rem 2rem; color: #b0b0b0;">
        <div class="empty-gallery-icon" style="font-size: 4rem;">🏆</div>
        <h3 style="color: #fff; margin-bottom: 1rem;">No rankings yet</h3>
        <p>Be the first to submit your look!</p>
    </div>
@else
    @foreach($photos as $index => $photo)
        <div class="ranking-item" style="display: flex; align-items: center; gap: 1.5rem; padding: 1.5rem; background: #4a148c; border-radius: 15px; transition: all 0.3s ease;">
            <span style="font-size: 1.5rem; font-weight: 700; width: 40px; color: #ff6f00;">
                @if($index === 0) 👑 @else #{{ $index + 1 }} @endif
            </span>
            @if($photo->image)
            <img src="{{ Storage::url($photo->image) }}" alt="{{ $photo->student_name }}" style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px; background: #7b1fa2;">
            @endif
            <div style="flex: 1;">
                <h4 style="color: #fff; font-size: 1rem;">{{ $photo->student_name }}</h4>
                <p style="color: #b0b0b0; font-size: 0.8rem;">{{ $photo->year_level }}</p>
            </div>
            <span style="color: #ff6f00;">❤️ {{ $photo->likes_count }}</span>
        </div>
    @endforeach
@endif
