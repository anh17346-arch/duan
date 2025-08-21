<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\RegistrationLog;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


use Illuminate\View\View;                       // <-- View đúng
use Illuminate\Validation\Rule;                 // Rule cho in: [...]
use Illuminate\Validation\Rules\Password as Pwd; // Password rule


class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
{
    // TRIM trước
    $request->merge([
        'username' => trim((string)$request->username),
        'first_name' => trim((string)$request->first_name),
        'last_name' => trim((string)$request->last_name),
        'email' => trim((string)$request->email),
        'address' => trim((string)$request->address),
        'phone' => trim((string)$request->phone),
    ]);

    $validated = $request->validate(
    [
        // 4 & 5: định dạng + min/max
        'username'   => ['required','min:5','max:20','regex:/^[A-Za-z0-9]+$/','unique:users,username'],
        'first_name' => ['required','min:2','max:20','regex:/^[\pL\s]+$/u'],
        'last_name'  => ['required','min:2','max:20','regex:/^[\pL\s]+$/u'],
        'gender'     => ['required', Rule::in(['male','female','other'])],
        'address'    => ['required','min:5','max:150','regex:/^[\pL\pN\s,.\-\/#]+$/u'],
        'email'      => ['required','email','max:255','unique:users,email'],
        'phone'      => ['required','regex:/^\d{10,11}$/','unique:users,phone'],
        // 38: password khác username + 41: chặn copy (UI) + 37: show/hide (UI)
        'password'   => ['required','confirmed', Pwd::min(8), 'different:username'],
        // 15–16: điều khoản (checkbox chỉ bật khi đã đọc modal)
        'terms'      => ['accepted'],
    ],
    [
        'username.regex'    => 'Username chỉ chứa a-z, A-Z, 0-9.',
        'first_name.regex'  => 'Họ chỉ gồm chữ cái và khoảng trắng.',
        'last_name.regex'   => 'Tên chỉ gồm chữ cái và khoảng trắng.',
        'address.regex'     => 'Địa chỉ chỉ được chứa chữ/số, khoảng trắng và , . - / #.',
        'phone.regex'       => 'Số điện thoại chỉ gồm 10–11 chữ số.',
        'terms.accepted'    => 'Bạn cần đồng ý Điều khoản & Điều kiện.',
        'password.different'=> 'Mật khẩu không được trùng username.',

        'gender'   => ['required', Rule::in(['male','female','other'])],
'password' => ['required', 'confirmed', Pwd::min(8), 'different:username'],

    ]);

    try {
        $user = User::create([
            'username' => $validated['username'],
            'first_name' => $validated['first_name'],
            'last_name'  => $validated['last_name'],
            'name'       => $validated['first_name'].' '.$validated['last_name'], // để hiển thị
            'gender'     => $validated['gender'],
            'address'    => $validated['address'],
            'email'      => strtolower($validated['email']),
            'phone'      => $validated['phone'],
            'password'   => Hash::make($validated['password']), // 40: bcrypt
            'role'       => 'customer',
            'terms_accepted_at' => now(),
        ]);

        // 19–24: gửi email xác minh
        event(new Registered($user));

        // 39: log đăng ký
        RegistrationLog::create([
            'email' => $user->email,
            'ip' => $request->ip(),
            'user_agent' => (string) $request->userAgent(),
            'status' => 'success',
        ]);
    } catch (\Throwable $e) {
        RegistrationLog::create([
            'email' => (string) $request->email,
            'ip' => $request->ip(),
            'user_agent' => (string) $request->userAgent(),
            'status' => 'failed',
        ]);
        throw $e;
    }

    // Đăng nhập ngay sau khi đăng ký? => Tuân thủ case 25: chưa verify thì KO cho login
    return redirect()->route('verification.notice')
                     ->with('success', 'Đăng ký thành công. Vui lòng kiểm tra email để xác minh tài khoản trong vòng 24 giờ.');
}
}
