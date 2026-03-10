@extends('fashion.layout')

@section('title', 'Admin Dashboard')

@section('content')
@php use Illuminate\Support\Facades\Storage; @endphp
<section id="admin-dashboard" style="padding: 100px 0;">
    <div class="upload-container" style="max-width: 1200px;">
        <h2 class="section-title">Admin <span>Dashboard</span></h2>

        @if(session('success'))
            <div style="background: #00c853; color: #fff; padding: 10px 20px; border-radius: 5px; margin-bottom: 20px;">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div style="background: #ff5252; color: #fff; padding: 10px 20px; border-radius: 5px; margin-bottom: 20px;">
                {{ session('error') }}
            </div>
        @endif

        <!-- Photos Section -->
        <div style="background: #1a1a1a; padding: 30px; border-radius: 10px; margin-top: 30px;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h3 style="color: #fff; margin: 0;">Photos</h3>
                <form method="GET" action="{{ route('dashboard') }}" style="display: flex; align-items: center; gap: 10px;">
                    <label style="color: #888; font-size: 0.9rem;">Sort by:</label>
                    <select name="photo_sort" onchange="this.form.submit()" style="background: #333; color: #fff; border: 1px solid #555; padding: 5px 10px; border-radius: 5px;">
                        <option value="newest" {{ $photoSort == 'newest' ? 'selected' : '' }}>Newest First</option>
                        <option value="oldest" {{ $photoSort == 'oldest' ? 'selected' : '' }}>Oldest First</option>
                        <option value="most_likes" {{ $photoSort == 'most_likes' ? 'selected' : '' }}>Most Likes</option>
                        <option value="least_likes" {{ $photoSort == 'least_likes' ? 'selected' : '' }}>Least Likes</option>
                    </select>
                    @if($userSort)
                    <input type="hidden" name="user_sort" value="{{ $userSort }}">
                    @endif
                </form>
            </div>
            
            <p style="color: #888; margin-bottom: 20px;">Total Photos: {{ $photos->count() }}</p>

            @if($photos->isEmpty())
                <p style="color: #888;">No photos yet.</p>
            @else
                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 15px;">
                    @foreach($photos as $photo)
                        <div style="position: relative; border-radius: 8px; overflow: hidden; background: #333;">
                            <img src="{{ Storage::url($photo->image) }}" alt="{{ $photo->student_name }}" style="width: 100%; height: 200px; object-fit: cover;">
                            <div style="padding: 10px;">
                                <p style="color: #fff; margin: 0 0 5px 0; font-size: 0.9rem;">{{ $photo->student_name }}</p>
                                <p style="color: #ff6f00; margin: 0; font-size: 0.8rem;">❤️ {{ $photo->likes_count }}</p>
                            </div>
                            <form method="POST" action="{{ route('admin.photos.destroy', $photo) }}" onsubmit="return confirm('Are you sure you want to delete this photo?');" style="position: absolute; top: 10px; right: 10px;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="background: #ff5252; color: #fff; border: none; padding: 5px 10px; border-radius: 5px; cursor: pointer; font-size: 0.8rem;">Delete</button>
                            </form>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Users Section -->
        <div style="background: #1a1a1a; padding: 30px; border-radius: 10px; margin-top: 30px;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h3 style="color: #fff; margin: 0;">Users</h3>
                <form method="GET" action="{{ route('dashboard') }}" style="display: flex; align-items: center; gap: 10px;">
                    <label style="color: #888; font-size: 0.9rem;">Sort by:</label>
                    <select name="user_sort" onchange="this.form.submit()" style="background: #333; color: #fff; border: 1px solid #555; padding: 5px 10px; border-radius: 5px;">
                        <option value="newest" {{ $userSort == 'newest' ? 'selected' : '' }}>Newest First</option>
                        <option value="oldest" {{ $userSort == 'oldest' ? 'selected' : '' }}>Oldest First</option>
                        <option value="name_az" {{ $userSort == 'name_az' ? 'selected' : '' }}>Name A-Z</option>
                        <option value="name_za" {{ $userSort == 'name_za' ? 'selected' : '' }}>Name Z-A</option>
                    </select>
                    @if($photoSort)
                    <input type="hidden" name="photo_sort" value="{{ $photoSort }}">
                    @endif
                </form>
            </div>
            
            <p style="color: #888; margin-bottom: 20px;">Total Users: {{ $users->count() }}</p>

            @if($users->isEmpty())
                <p style="color: #888;">No users yet.</p>
            @else
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="border-bottom: 1px solid #333;">
                            <th style="text-align: left; padding: 10px; color: #888;">ID</th>
                            <th style="text-align: left; padding: 10px; color: #888;">Name</th>
                            <th style="text-align: left; padding: 10px; color: #888;">Email</th>
                            <th style="text-align: left; padding: 10px; color: #888;">Joined</th>
                            <th style="text-align: left; padding: 10px; color: #888;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr style="border-bottom: 1px solid #333;">
                                <td style="padding: 10px; color: #fff;">{{ $user->id }}</td>
                                <td style="padding: 10px; color: #fff;">{{ $user->name }}</td>
                                <td style="padding: 10px; color: #fff;">{{ $user->email }}</td>
                                <td style="padding: 10px; color: #888;">{{ $user->created_at->format('M j, Y') }}</td>
                                <td style="padding: 10px;">
                                    @if(auth()->id() !== $user->id)
                                        <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('Are you sure you want to delete this user and all their posts?');" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" style="background: #ff5252; color: #fff; border: none; padding: 5px 10px; border-radius: 5px; cursor: pointer; font-size: 0.8rem;">Delete User</button>
                                        </form>
                                    @else
                                        <span style="color: #888; font-size: 0.8rem;">(You)</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>

        <!-- Settings Section -->
        <div style="background: #1a1a1a; padding: 30px; border-radius: 10px; margin-top: 30px;">
            <h3 style="color: #fff; margin: 0 0 20px 0;">Settings</h3>
            
            <form method="POST" action="{{ route('admin.settings') }}">
                @csrf
                
                <div style="margin-bottom: 20px;">
                    <label style="color: #888; display: block; margin-bottom: 8px;">Announcement Date</label>
                    <input type="date" name="announcement_date" value="{{ $announcementDate }}" style="background: #333; color: #fff; border: 1px solid #555; padding: 10px; border-radius: 5px; width: 100%; max-width: 300px;">
                </div>
                    
                <div style="margin-bottom: 20px;">
                    <label style="color: #888; display: block; margin-bottom: 8px;">Announce Winner</label>
                    <div style="display: flex; align-items: center; gap: 15px;">
                        <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                            <input type="checkbox" name="announce_winner" value="1" {{ $isWinnerAnnounced ? 'checked' : '' }}
                                style="width: 20px; height: 20px;">
                            <span style="color: #fff;">Yes, announce the winner now!</span>
                        </label>
                    </div>
                
                <button type="submit" class="btn btn-primary">Save Settings</button>
            </form>
            
            @if(session('settings_success'))
                <div style="background: #00c853; color: #fff; padding: 10px 20px; border-radius: 5px; margin-top: 15px;">
                    {{ session('settings_success') }}
                </div>
            @endif
        </div>
</section>
@endsection
