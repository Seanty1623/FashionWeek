<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use App\Models\PhotoLike;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FashionController extends Controller
{
    /**
     * Display the gallery page.
     */
    public function gallery()
    {
        $photos = Photo::withCount('likes')->orderBy('likes_count', 'desc')->get();
        
        // Get liked photo IDs - use user_id for authenticated users, session_id for guests
        $likedIds = [];
        
        if (Auth::check()) {
            // Authenticated user - check user_id
            $likedPhotos = PhotoLike::where('user_id', Auth::id())->pluck('photo_id')->toArray();
            $likedIds = $likedPhotos;
        } else {
            // Guest - check session_id
            $sessionId = session()->getId();
            $likedPhotos = PhotoLike::where('session_id', $sessionId)->pluck('photo_id')->toArray();
            $likedIds = $likedPhotos;
        }
        
        return view('fashion.gallery', compact('photos', 'likedIds'));
    }

    /**
     * Display the leaderboard page.
     */
    public function leaderboard()
    {
        $photos = Photo::withCount('likes')
            ->orderBy('likes_count', 'desc')
            ->get();
        
        // Check if winner has been announced
        $isWinnerAnnounced = false;
        try {
            $isWinnerAnnounced = Setting::get('is_winner_announced', 'false') === 'true';
        } catch (\Exception $e) {
            // Table doesn't exist yet
        }
        
        return view('fashion.leaderboard', compact('photos', 'isWinnerAnnounced'));
    }

    /**
     * Display the upload page - requires authentication.
     */
    public function upload()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('message', 'Please login to upload your fashion!');
        }
        
        // Get approved photos for the randomizer (all photos for now, can filter by approved status later)
        $photos = Photo::whereNotNull('image')->get(['id', 'student_name', 'year_level', 'image', 'clothing_type', 'clothing_subtype']);
        
        return view('fashion.upload', compact('photos'));
    }

    /**
     * Display the outfit selector/randomizer page.
     */
    public function selector()
    {
        return view('fashion.selector');
    }

    /**
     * Store a newly uploaded photo - requires authentication.
     */
    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('message', 'Please login to upload your fashion!');
        }
        
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $path = $request->file('photo')->store('photos', 'public');

        // Use the authenticated user's name
        $studentName = Auth::user()->name;
        
        Photo::create([
            'user_id' => Auth::id(),
            'student_name' => $studentName,
            'year_level' => 'Fashion',
            'description' => $request->description,
            'image' => $path,
            'likes_count' => 0,
            'is_outfit' => false,
            'clothing_type' => $request->clothing_type ?? null,
            'clothing_subtype' => $request->clothing_subtype ?? null,
        ]);

        return redirect()->route('fashion.gallery')->with('success', 'Photo uploaded successfully!');
    }

    /**
     * Store an outfit photo - requires authentication.
     */
    public function storeOutfit(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('message', 'Please login to upload your fashion!');
        }
        
        $request->validate([
            'outfit' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $path = $request->file('outfit')->store('photos', 'public');

        Photo::create([
            'user_id' => Auth::id(),
            'student_name' => Auth::user()->name,
            'year_level' => $request->clothing_category ?: 'Fashion',
            'description' => $request->description,
            'image' => $path,
            'likes_count' => 0,
            'is_outfit' => true,
            'clothing_type' => $request->clothing_type,
        ]);

        return redirect()->route('fashion.gallery')->with('success', 'Outfit uploaded successfully!');
    }

    /**
     * Like a photo - requires authentication.
     */
    public function like(Request $request, Photo $photo)
    {
        // Require authentication
        if (!Auth::check()) {
            return response()->json([
                'error' => 'Please login to like photos',
                'requires_login' => true,
            ], 401);
        }

        $userId = Auth::id();
        
        $existingLike = PhotoLike::where('photo_id', $photo->id)
            ->where('user_id', $userId)
            ->first();

        if ($existingLike) {
            $existingLike->delete();
            $photo->decrement('likes_count');
            $liked = false;
        } else {
            PhotoLike::create([
                'user_id' => $userId,
                'photo_id' => $photo->id,
                'session_id' => session()->getId(),
            ]);
            $photo->increment('likes_count');
            $liked = true;
        }

        $photo->refresh();

        return response()->json([
            'liked' => $liked,
            'likes_count' => $photo->likes_count,
        ]);
    }
}
