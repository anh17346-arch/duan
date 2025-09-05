<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class PasswordStrength implements ValidationRule
{
    /**
     * Run the validation rule.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $password = $value;
        
        // Kiểm tra độ dài tối thiểu
        if (strlen($password) < 8) {
            $fail('Mật khẩu phải có ít nhất 8 ký tự.');
            return;
        }
        
        // Kiểm tra có chữ cái không
        if (!preg_match('/[a-zA-Z]/', $password)) {
            $fail('Mật khẩu cần có ít nhất 1 chữ cái.');
            return;
        }
        
        // Kiểm tra có số không
        if (!preg_match('/[0-9]/', $password)) {
            $fail('Mật khẩu cần có ít nhất 1 số.');
            return;
        }
        
        // Kiểm tra có ký hiệu đặc biệt không
        if (!preg_match('/[!@#$%^&*()_+\-=\[\]{};\':"\\|,.<>\/?]/', $password)) {
            $fail('Mật khẩu cần có ít nhất 1 ký hiệu đặc biệt (!@#$%^&*...).');
            return;
        }
        
        // Kiểm tra có cả chữ hoa và chữ thường không
        if (!preg_match('/[a-z]/', $password) || !preg_match('/[A-Z]/', $password)) {
            $fail('Mật khẩu cần có cả chữ hoa và chữ thường.');
            return;
        }
        
        // Kiểm tra mật khẩu có quá yếu không (có thể mở rộng thêm)
        $weakPasswords = [
            'password', '123456', '12345678', 'qwerty', 'abc123', 'password123',
            'admin', 'letmein', 'welcome', 'monkey', 'dragon', 'master'
        ];
        
        if (in_array(strtolower($password), $weakPasswords)) {
            $fail('Mật khẩu quá yếu, hãy chọn mật khẩu mạnh hơn.');
            return;
        }
    }
}
