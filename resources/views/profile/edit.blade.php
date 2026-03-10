{{-- Extended from fashion layout --}}
@extends('fashion.layout')

@section('title', 'Edit Profile')

@section('content')
<section id="edit-profile" style="padding: 100px 0;">
    <div class="upload-container" style="max-width: 600px;">
        <h2 class="section-title">Edit <span>Profile</span></h2>

        <div style="background: #1a1a1a; padding: 30px; border-radius: 10px; margin-top: 30px;">
            <!-- Update Profile Information -->
            <div style="margin-bottom: 30px;">
                <h3 style="color: #fff; margin-bottom: 20px;">Update Profile Information</h3>
                
                <form method="POST" action="{{ route('profile.update') }}">
                    @csrf
                    @method('patch')

                    <div class="form-group">
                        <label for="name">Name</label>
                        <input id="name" type="text" name="name" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
                        @error('name')
                            <span style="color: #ff4757; font-size: 0.875rem; margin-top: 5px;">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}" required autocomplete="username">
                        @error('email')
                            <span style="color: #ff4757; font-size: 0.875rem; margin-top: 5px;">{{ $message }}</span>
                        @enderror
                    </div>

                    <div style="margin-top: 20px;">
                        <button type="submit" class="btn btn-primary">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>

            <!-- Delete Account -->
            <div style="border-top: 1px solid #333; padding-top: 30px;">
                <h3 style="color: #ff4757; margin-bottom: 20px;">Delete Account</h3>
                <p style="color: #888; margin-bottom: 20px;">Once your account is deleted, all of its resources and data will be permanently deleted.</p>
                
                <form method="POST" action="{{ route('profile.destroy') }}">
                    @csrf
                    @method('delete')
                    
                    <div class="form-group">
                        <label for="delete_password">Password</label>
                        <input id="delete_password" type="password" name="password" required>
                        @error('password', 'userDeletion')
                            <span style="color: #ff4757; font-size: 0.875rem; margin-top: 5px;">{{ $message }}</span>
                        @enderror
                    </div>

                    <div style="margin-top: 20px;">
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete your account?')">
                            Delete Account
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
