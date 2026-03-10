<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use App\Models\PhotoLike;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PhotoController extends Controller
{
    /**
     * Display the main page with all sections.
     */
    public function index()
    {
        $photos = Photo::orderBy('created_at', 'desc')->get();
        $leaderboard = Photo::orderBy('likes_count', 'desc')->get();
        $likedIds = $this->getLikedPhotoIds();

        return view('fashion.index', compact('photos', 'leaderboard', 'likedIds'));
    }

    /**
     * Store a newly uploaded photo.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'image' => ['required', 'image', 'mimes:jpeg,png,gif', 'max:5120'],
            'student_name' => ['required', 'string', 'max:255'],
            'year_level' => ['required', 'string', 'in:Grade 7,Grade 8,Grade 9,Grade 10,Grade 11,Grade 12'],
            'description' => ['nullable', 'string', 'max:1000'],
        ]);

        $path = $request->file('image')->store('photos', 'public');

        Photo::create([
            'image' => $path,
            'student_name' => $validated['student_name'],
            'year_level' => $validated['year_level'],
            'description' => $validated['description'] ?? null,
            'is_outfit' => false,
        ]);

        return redirect()->route('fashion.index')->with('success', 'Your look has been submitted successfully!');
    }

    /**
     * Toggle like on a photo - requires authentication.
     */
    public function like(Photo $photo)
    {
        // Require authentication
        if (!Auth::check()) {
            if (request()->wantsJson() || request()->ajax()) {
                return response()->json([
                    'error' => 'Please login to like photos',
                    'requires_login' => true,
                ], 401);
            }
            return redirect()->route('login')->with('message', 'Please login to like photos!');
        }

        $userId = Auth::id();

        $like = PhotoLike::where('photo_id', $photo->id)
            ->where('user_id', $userId)
            ->first();

        if ($like) {
            $like->delete();
            $photo->decrement('likes_count');
            $liked = false;
        } else {
            PhotoLike::create([
                'photo_id' => $photo->id,
                'user_id' => $userId,
                'session_id' => session()->getId(),
            ]);
            $photo->increment('likes_count');
            $liked = true;
        }

        $photo->refresh();

        if (request()->wantsJson() || request()->ajax()) {
            $leaderboard = Photo::orderBy('likes_count', 'desc')->take(10)->get()
                ->map(fn ($p) => [
                    'id' => $p->id,
                    'student_name' => $p->student_name,
                    'year_level' => $p->year_level,
                    'likes_count' => $p->likes_count,
                    'image' => $p->image,
                ]);
            return response()->json([
                'likes' => $photo->likes_count,
                'liked' => $liked,
                'leaderboard' => [
                    'winner' => $leaderboard->first(),
                    'rankings' => $leaderboard,
                ],
            ]);
        }

        return redirect()->back();
    }

    /**
     * Store outfit from clothes selector (canvas base64 image).
     */
    public function storeOutfit(Request $request)
    {
        $validated = $request->validate([
            'image' => ['required', 'string'],
            'student_name' => ['required', 'string', 'max:255'],
        ]);

        // Handle base64 image from canvas
        $imageData = $validated['image'];
        if (preg_match('/^data:image\/(\w+);base64,/', $imageData, $type)) {
            $imageData = substr($imageData, strpos($imageData, ',') + 1);
            $type = strtolower($type[1]);

            if (! in_array($type, ['jpg', 'jpeg', 'png', 'gif'])) {
                return redirect()->back()->with('error', 'Invalid image type.');
            }

            $imageData = base64_decode($imageData);
            if ($imageData === false) {
                return redirect()->back()->with('error', 'Failed to decode image.');
            }

            $filename = 'outfit_' . uniqid() . '.' . $type;
            $path = 'photos/' . $filename;
            Storage::disk('public')->put($path, $imageData);

            Photo::create([
                'image' => $path,
                'student_name' => $validated['student_name'] . ' (Outfit)',
                'year_level' => 'Selected',
                'description' => 'My Fashion Week Outfit',
                'is_outfit' => true,
            ]);

            return redirect()->route('fashion.index')->with('success', 'Outfit saved to gallery!');
        }

        return redirect()->back()->with('error', 'Invalid image data.');
    }

    private function getLikedPhotoIds(): array
    {
        if (Auth::check()) {
            // Authenticated user - check user_id
            return PhotoLike::where('user_id', Auth::id())
                ->pluck('photo_id')
                ->toArray();
        } else {
            // Guest - check session_id
            return PhotoLike::where('session_id', session()->getId())
                ->pluck('photo_id')
                ->toArray();
        }
    }
}
