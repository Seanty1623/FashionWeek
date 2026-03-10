@extends('fashion.layout')

@section('content')
<section id="login" style="padding: 100px 0;">
    <div class="upload-container" style="max-width: 500px;">
        <h2 class="section-title">Log <span>In</span></h2>

        <!-- Session Status -->
        @if (session('status'))
            <div class="alert alert-success mb-4">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div class="form-group">
                <label for="email">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="your@email.com">
                @error('email')
                    <span style="color: #ff4757; font-size: 0.875rem; margin-top: 5px;">{{ $message }}</span>
                @enderror
            </div>

            <!-- Password -->
            <div class="form-group">
                <label for="password">Password</label>
                <input id="password" type="password" name="password" required autocomplete="current-password" placeholder="••••••••">
                 @error('password')
                    <span style="color: #ff4757; font-size: 0.875rem; margin-top: 5px;">{{ $message }}</span>
                @enderror
            </div>

            <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 1.5rem;">
                <a style="font-size: 0.875rem; color: #f0f0f0; text-decoration: none;" href="{{ route('register') }}">
                    Don't have an account?
                </a>

                <button type="submit" class="btn btn-primary">
                    Log in
                </button>
            </div>
        </form>
    </div>
</section>
@endsection