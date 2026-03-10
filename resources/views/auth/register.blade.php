@extends('fashion.layout')

@section('content')
<section id="register" style="padding: 100px 0;">
    <div class="upload-container" style="max-width: 500px;">
        <h2 class="section-title"><span>Reg</span>ister</h2>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div class="form-group">
                <label for="name">Name</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="Your Name">
                @error('name')
                    <span style="color: #ff4757; font-size: 0.875rem; margin-top: 5px;">{{ $message }}</span>
                @enderror
            </div>

            <!-- Email Address -->
            <div class="form-group">
                <label for="email">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" placeholder="your@email.com">
                @error('email')
                    <span style="color: #ff4757; font-size: 0.875rem; margin-top: 5px;">{{ $message }}</span>
                @enderror
            </div>

            <!-- Password -->
            <div class="form-group">
                <label for="password">Password</label>
                <input id="password" type="password" name="password" required autocomplete="new-password" placeholder="••••••••">
                @error('password')
                    <span style="color: #ff4757; font-size: 0.875rem; margin-top: 5px;">{{ $message }}</span>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div class="form-group">
                <label for="password_confirmation">Confirm Password</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="••••••••">
                @error('password_confirmation')
                    <span style="color: #ff4757; font-size: 0.875rem; margin-top: 5px;">{{ $message }}</span>
                @enderror
            </div>

            <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 1.5rem;">
                <a style="font-size: 0.875rem; color: #f0f0f0; text-decoration: none;" href="{{ route('login') }}">
                    Already registered?
                </a>

                <button type="submit" class="btn btn-primary">
                    Register
                </button>
            </div>
        </form>
    </div>
</section>
@endsection