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
use App\Rules\PasswordStrength;


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
        'province' => trim((string)$request->province),
        'ward' => trim((string)$request->ward),
        'address' => trim((string)$request->address),
        'phone' => trim((string)$request->phone),
    ]);

    $validated = $request->validate(
    [
        // Username validation
        'username'   => ['required','string','min:4','max:30','regex:/^[a-zA-Z0-9]+$/','unique:users,username'],
        
        // Name validation
        'first_name' => ['required','string','min:2','max:50','regex:/^[\p{L}\s]+$/u'],
        'last_name'  => ['required','string','min:2','max:50','regex:/^[\p{L}\s]+$/u'],
        
        // Email validation
        'email'      => ['required','string','email:rfc,dns','max:255','unique:users,email'],
        
        // Phone validation
        'phone'      => ['required','string','digits_between:10,11','regex:/^(0|\+84)\d{9,10}$/','unique:users,phone'],
        
        // Address validation
        'province'   => ['required','string','regex:/^[\p{L}\s]+$/u'],
        'ward'       => ['required','string','regex:/^[\p{L}\s]+$/u'],
        'address'    => ['required','string','max:255','regex:/^[\p{L}\p{N}\s,.\-\/#]+$/u'],
        
        // Gender validation
        'gender'     => ['required', Rule::in(['male','female','other'])],
        
        // Password validation
        'password'   => ['required','string','max:64','confirmed','different:username', new PasswordStrength()],
        
        // Terms validation
        'terms'      => ['accepted'],
        
        // Honeypot field (nếu có)
        'website'    => ['present','size:0'],
    ],
    [
        // Username messages
        'username.required' => 'Username là bắt buộc.',
        'username.min'      => 'Username phải có ít nhất :min ký tự.',
        'username.max'      => 'Username không được vượt quá :max ký tự.',
        'username.regex'    => 'Username chỉ chứa chữ cái và số (a-z, A-Z, 0-9).',
        'username.unique'   => 'Username này đã được sử dụng.',
        
        // Name messages
        'first_name.required' => 'Họ là bắt buộc.',
        'first_name.min'      => 'Họ phải có ít nhất :min ký tự.',
        'first_name.max'      => 'Họ không được vượt quá :max ký tự.',
        'first_name.regex'    => 'Họ chỉ gồm chữ cái và khoảng trắng.',
        
        'last_name.required' => 'Tên là bắt buộc.',
        'last_name.min'      => 'Tên phải có ít nhất :min ký tự.',
        'last_name.max'      => 'Tên không được vượt quá :max ký tự.',
        'last_name.regex'    => 'Tên chỉ gồm chữ cái và khoảng trắng.',
        
        // Email messages
        'email.required' => 'Email là bắt buộc.',
        'email.email'   => 'Email không đúng định dạng.',
        'email.max'     => 'Email không được vượt quá :max ký tự.',
        'email.unique'  => 'Email này đã được đăng ký.',
        
        // Phone messages
        'phone.required'        => 'Số điện thoại là bắt buộc.',
        'phone.digits_between'  => 'Số điện thoại phải có :min đến :max chữ số.',
        'phone.regex'           => 'Số điện thoại phải bắt đầu bằng 0 hoặc +84.',
        'phone.unique'          => 'Số điện thoại này đã được đăng ký.',
        
        // Address messages
        'province.required' => 'Tỉnh/Thành phố là bắt buộc.',
        'province.regex'    => 'Tỉnh/Thành phố chỉ gồm chữ cái và khoảng trắng.',
        
        'ward.required' => 'Xã/Phường là bắt buộc.',
        'ward.regex'    => 'Xã/Phường chỉ gồm chữ cái và khoảng trắng.',
        
        'address.required' => 'Địa chỉ chi tiết là bắt buộc.',
        'address.max'     => 'Địa chỉ không được vượt quá :max ký tự.',
        'address.regex'   => 'Địa chỉ chỉ được chứa chữ/số, khoảng trắng và , . - / #.',
        
        // Gender messages
        'gender.required' => 'Giới tính là bắt buộc.',
        'gender.in'       => 'Giới tính không hợp lệ.',
        
        // Password messages
        'password.required'   => 'Mật khẩu là bắt buộc.',
        'password.max'        => 'Mật khẩu không được vượt quá :max ký tự.',
        'password.confirmed'  => 'Xác nhận mật khẩu không khớp.',
        'password.different'  => 'Mật khẩu không được trùng username.',
        'password.min'        => 'Mật khẩu phải có ít nhất :min ký tự.',
        'password.mixed'      => 'Mật khẩu cần có cả chữ hoa và chữ thường.',
        'password.letters'    => 'Mật khẩu cần có ít nhất 1 chữ cái.',
        'password.numbers'    => 'Mật khẩu cần có ít nhất 1 số.',
        'password.symbols'    => 'Mật khẩu cần có ít nhất 1 ký hiệu đặc biệt.',
        'password.uncompromised' => 'Mật khẩu quá yếu, hãy chọn mật khẩu mạnh hơn.',
        
        // Terms messages
        'terms.accepted' => 'Bạn cần đồng ý Điều khoản & Điều kiện.',
        
        // Honeypot messages
        'website.present' => 'Có lỗi xảy ra.',
        'website.size'    => 'Có lỗi xảy ra.',
    ]);

    try {
        // Tạo địa chỉ đầy đủ từ các thành phần
        $fullAddress = $validated['address'] . ', ' . $validated['ward'] . ', ' . $validated['province'];
        
        $user = User::create([
            'username' => $validated['username'],
            'first_name' => $validated['first_name'],
            'last_name'  => $validated['last_name'],
            'name'       => $validated['first_name'].' '.$validated['last_name'], // để hiển thị
            'gender'     => $validated['gender'],
            'address'    => $fullAddress,
            'email'      => strtolower($validated['email']),
            'phone'      => $validated['phone'],
            'password'   => Hash::make($validated['password']), // 40: bcrypt
            'role'       => 'customer',
            'terms_accepted_at' => now(),
        ]);

        // 19–24: gửi email xác minh
        event(new Registered($user));

        // Create notification for admin about new user registration
        $notificationService = new \App\Services\NotificationService();
        $notificationService->createNewUserNotification($user);

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
