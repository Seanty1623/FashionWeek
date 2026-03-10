@extends('fashion.layout')

@section('title', 'Admin Login')

@section('content')
<section id="admin-login" style="padding: 100px 0;">
    <div class="upload-container" style="max-width: 400px;">
        <h2 class="section-title">Admin <span>Login</span></h2>

        <div style="background: #1a1a1a; padding: 30px; border-radius: 10px; margin-top: 30px;">
            <form method="POST" action="{{ route('admin.login.store') }}">
                @csrf

                <div style="margin-bottom: 20px;">
                    <label for="email" style="color: #fff; display: block; margin-bottom: 8px;">Email</label>
                    <input type="email" name="email" id="email" required style="width: 100%; padding: 12px; border-radius: 5px; border: 1px solid #333; background: #222; color: #fff;">
                    @error('email')
                        <p style="color: #ff4757; margin-top: 5px;">{{ $message }}</p>
                    @enderror
                </div>

                <div style="margin-bottom: 20px;">
                    <label for="password" style="color: #fff; display: block; margin-bottom: 8px;">Password</label>
                    <input type="password" name="password" id="password" required style="width: 100%; padding: 12px; border-radius: 5px; border: 1px solid #333; background: #222; color: #fff;">
                    @error('password')
                        <p style="color: #ff4757; margin-top: 5px;">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%;">Login</button>
            </form>

            <div style="margin-top: 20px; text-align: center;">
                <a href="{{ route('fashion.index') }}" style="color: #888;">← Back to Home</a>
            </div>
        </div>
    </div>
</section>
@endsection


