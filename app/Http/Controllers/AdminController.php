<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use App\Models\User;
use App\Models\Setting;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index(Request $request)
    {
        // Always include likes count to get accurate numbers
        $photos = Photo::query()->withCount('likes');
        
        // Sorting for photos
        $photoSort = $request->get('photo_sort', 'newest');
        
        switch ($photoSort) {
            case 'oldest':
                $photos = $photos->orderBy('created_at', 'asc');
                break;
            case 'most_likes':
                $photos = $photos->orderBy('likes_count', 'desc');
                break;
            case 'least_likes':
                $photos = $photos->orderBy('likes_count', 'asc');
                break;
            case 'newest':
            default:
                $photos = $photos->orderBy('created_at', 'desc');
                break;
        }
        $photos = $photos->get();

        // Sorting for users
        $userSort = $request->get('user_sort', 'newest');
        $users = User::query();
        
        switch ($userSort) {
            case 'oldest':
                $users = $users->orderBy('created_at', 'asc');
                break;
            case 'name_az':
                $users = $users->orderBy('name', 'asc');
                break;
            case 'name_za':
                $users = $users->orderBy('name', 'desc');
                break;
            case 'newest':
            default:
                $users = $users->orderBy('created_at', 'desc');
                break;
        }
        $users = $users->get();
        
        // Get settings
        $announcementDate = Setting::get('announcement_date');
        $isWinnerAnnounced = Setting::get('is_winner_announced', 'false') === 'true';
        
        return view('admin.index', compact('photos', 'users', 'announcementDate', 'isWinnerAnnounced', 'photoSort', 'userSort'));
    }

    /**
     * Save admin settings.
     */
    public function settings(Request $request)
    {
        try {
            Setting::set('announcement_date', $request->announcement_date);
            Setting::set('is_winner_announced', $request->has('announce_winner') ? 'true' : 'false');
            
            return redirect()->route('dashboard')->with('settings_success', 'Settings saved successfully!');
        } catch (\Exception $e) {
            return redirect()->route('dashboard')->with('error', 'Could not save settings. Please run migrations.');
        }
    }

    /**
     * Delete a photo.
     */
    public function destroyPhoto(Photo $photo)
    {
        $photo->delete();
        return redirect()->route('dashboard')->with('success', 'Photo deleted successfully!');
    }

    /**
     * Delete a user.
     */
    public function destroyUser(User $user)
    {
        // Don't allow deleting yourself
        if (auth()->id() === $user->id) {
            return redirect()->route('dashboard')->with('error', 'You cannot delete your own account!');
        }
        
        // Delete user's photos too
        Photo::where('user_id', $user->id)->delete();
        
        $user->delete();
        return redirect()->route('dashboard')->with('success', 'User and their posts deleted successfully!');
    }
}
