@php use Illuminate\Support\Facades\Storage; @endphp
@if($photos->isEmpty())
    <div class="empty-gallery">
        <div class="empty-gallery-icon">📸</div>
        <h3>No submissions yet</h3>
        <p>Be the first to submit your look!</p>
    </div>
@else
    @foreach($photos as $photo)
        @php $isLiked = in_array($photo->id, $likedIds); @endphp
        <div class="photo-card">
            <img src="{{ Storage::url($photo->image) }}" alt="{{ $photo->student_name }}" class="photo-image">
            <div class="photo-info">
                <h3 class="photo-name">{{ $photo->student_name }}</h3>
                <p class="photo-level">{{ $photo->year_level }}</p>
                <p class="photo-description">{{ $photo->description ?: 'No description' }}</p>
                <div class="photo-actions">
                    <button type="button" class="like-btn {{ $isLiked ? 'liked' : '' }}" data-id="{{ $photo->id }}" data-url="{{ route('photos.like', $photo) }}">
                        <span class="heart">{{ $isLiked ? '❤️' : '🤍' }}</span>
                        <span class="like-count">{{ $photo->likes_count }}</span>
                    </button>
                    <span class="photo-time">{{ $photo->created_at->diffForHumans() }}</span>
                </div>
            </div>
        </div>
    @endforeach
@endif
