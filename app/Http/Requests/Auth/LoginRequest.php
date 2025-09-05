<?php

namespace App\Http\Requests\Auth;

use App\Models\User;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'email'    => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:8'],
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => app()->getLocale() === 'en' 
                ? 'Email address is required.' 
                : 'Vui lòng nhập địa chỉ email.',
            'email.email' => app()->getLocale() === 'en' 
                ? 'Please enter a valid email address (e.g., user@example.com).' 
                : 'Vui lòng nhập địa chỉ email hợp lệ (ví dụ: user@example.com).',
            'email.max' => app()->getLocale() === 'en' 
                ? 'Email address cannot exceed 255 characters.' 
                : 'Địa chỉ email không được vượt quá 255 ký tự.',
            'password.required' => app()->getLocale() === 'en' 
                ? 'Password is required.' 
                : 'Vui lòng nhập mật khẩu.',
            'password.min' => app()->getLocale() === 'en' 
                ? 'Password must be at least 8 characters long.' 
                : 'Mật khẩu phải có ít nhất 8 ký tự.',
        ];
    }

    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        // Kiểm tra xem email có tồn tại không
        $user = User::where('email', $this->email)->first();
        
        if (!$user) {
            RateLimiter::hit($this->throttleKey());
            throw ValidationException::withMessages([
                'email' => trans('auth.email_not_found'),
            ]);
        }

        // Kiểm tra mật khẩu
        if (!Auth::attempt($this->only('email','password'), $this->boolean('remember'))) {
            RateLimiter::hit($this->throttleKey());
            throw ValidationException::withMessages([
                'password' => trans('auth.password_incorrect'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());
    }

    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) return;

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    public function throttleKey(): string
    {
        return Str::lower($this->input('email')).'|'.$this->ip();
    }
}
