<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Hiển thị form đăng nhập.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Xử lý đăng nhập.
     * (Không yêu cầu email verified)
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $request->session()->regenerate();

        $user = Auth::user();
        $welcomeMessage = app()->getLocale() === 'en' 
            ? "Welcome back, {$user->first_name}! 👋" 
            : "Chào mừng bạn quay lại, {$user->first_name}! 👋";

        return redirect()->intended(route('home'))
            ->with('success', $welcomeMessage);
    }

    public function destroy(Request $request): RedirectResponse
    {
        $user = Auth::user();
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        $logoutMessage = app()->getLocale() === 'en' 
            ? "You have been successfully logged out." 
            : "Bạn đã đăng xuất thành công.";

        return redirect()->route('home')
            ->with('success', $logoutMessage);
    }
}
