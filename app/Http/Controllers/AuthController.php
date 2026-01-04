<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Lawyer;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory as ViewFactory;

class AuthController extends Controller
{
    /** @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View */
    public function login(): View|ViewFactory
    {
        return view('auth.login');
    }

    /** @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View */
    public function register(): View|ViewFactory
    {
        return view('auth.register');
    }

    // Handle registration form POST
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        /** @var array{name: string, email: string, password: string, role?: string} $data */
        $data = (array) $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'nullable|string|in:user,lawyer',
        ]);

        $role = isset($data['role']) && is_scalar($data['role']) ? strval($data['role']) : 'user';

        $user = User::create([
            'name' => strval($data['name']),
            'email' => strval($data['email']),
            'password' => Hash::make(strval($data['password'])),
            'role' => $role,
        ]);

        // If registering as a lawyer, create a minimal Lawyer record (pending verification)
        if ($role === 'lawyer') {
            Lawyer::create([
                'user_id' => $user->id,
                'verification_status' => 'pending',
            ]);
        }

        Auth::login($user);

        // After registering, redirect by role so lawyers land on their dashboard
        $user = Auth::user();
        if ($user && isset($user->role) && $user->role === 'lawyer') {
            return redirect()->route('lawyer.dashboard');
        }

        /** @var \Illuminate\Http\RedirectResponse $resp */
        $resp = redirect('/');
        return $resp;
    }

    // Handle login form POST
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function authenticate(Request $request): RedirectResponse
    {
        /** @var array{email: string, password: string} $credentials */
        $credentials = (array) $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $credentials['password'] = strval($credentials['password']);
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();

            // Redirect by role: admin -> admin dashboard, lawyer -> lawyer dashboard, else intended/home.
            if ($user && isset($user->role)) {
                if ($user->role === 'admin') {
                    return redirect()->route('admin.dashboard');
                }
                if ($user->role === 'lawyer') {
                    return redirect()->route('lawyer.dashboard');
                }
            }

            /** @var \Illuminate\Routing\Redirector $redirector */
            $redirector = redirect();
            return $redirector->intended('/');
        }

        return back()->withErrors(['email' => 'Invalid credentials'])->onlyInput('email');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request): RedirectResponse
    {
        \Illuminate\Support\Facades\Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        /** @var \Illuminate\Http\RedirectResponse $resp */
        $resp = redirect('/');
        return $resp;
    }
}
