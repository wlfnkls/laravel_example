<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();


        if (Auth::user()->role_id == '1') {
            return redirect()->intended(RouteServiceProvider::USERS);
        }

        if (Auth::user()->role_id == '2' || Auth::user()->role == '3') {
            return redirect()->intended(RouteServiceProvider::HOME);
        }

        if (Auth::user()->role_id == '3') {
            return redirect()->intended(RouteServiceProvider::FORM);
        }

        if (Auth::user()->role_id == '4') {
            return redirect()->intended(RouteServiceProvider::FORM);
        }

        $request->session()->regenerate();
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
