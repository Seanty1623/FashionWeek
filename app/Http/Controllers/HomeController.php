<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Redirect the user to the appropriate dashboard after login or registration.
     */
    public function __invoke(): RedirectResponse
    {
        if (Auth::user()?->is_admin) {
            return redirect()->route('dashboard');
        }

        return redirect()->route('profile.edit');
    }
}