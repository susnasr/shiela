<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Validation\ValidationException;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(Request $request): RedirectResponse
    {
        // Validate the request
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Attempt to authenticate the user
        if (Auth::attempt($request->only('email', 'password'), $request->filled('remember'))) {
            // Authentication successful, regenerate session
            $request->session()->regenerate();

            $user = Auth::user();

            // Redirect based on user role with success message
            if ($user->is_admin) {
                return redirect()->intended('/admin/dashboard')
                    ->with('success', 'Welcome ' . $user->name);
            }

            // Default redirect for buyers or others
            return redirect()->intended('/dashboard')
                ->with('success', 'Welcome ' . $user->name);
        }

        // Authentication failed, return with error
        throw ValidationException::withMessages([
            'email' => 'Invalid email or password.',
        ]);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
