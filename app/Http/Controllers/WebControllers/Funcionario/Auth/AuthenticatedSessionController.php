<?php

namespace App\Http\Controllers\WebControllers\Funcionario\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\Funcionario\LoginRequest;
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
        return view('funcionario.auth.login');
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

        $request->session()->regenerate();

        //return redirect()->route('funcionario.home');
        return redirect()->intended(RouteServiceProvider::FUNCIONARIO);
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */

    public function destroy(Request $request)
    {
        Auth::guard('funcionario')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('funcionario.login');
    }
}