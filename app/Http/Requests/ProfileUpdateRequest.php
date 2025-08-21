<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // đã đăng nhập là ok (route đã có middleware auth)
    }

    public function rules(): array
    {
        $userId = $this->user()->id;

        return [
            'username'   => ['required','min:5','max:20','regex:/^[A-Za-z0-9]+$/','unique:users,username,'.$userId],
            'first_name' => ['required','min:2','max:20','regex:/^[\p{L}\s]+$/u'],
            'last_name'  => ['required','min:2','max:20','regex:/^[\p{L}\s]+$/u'],
            'gender'     => ['required', Rule::in(['male','female','other'])],
            'address'    => ['required','min:5','max:150','regex:/^[\p{L}\p{N}\s,\.\-\/#]+$/u'],
            'email'      => ['required','email','max:255','unique:users,email,'.$userId],
            'phone'      => ['required','regex:/^\d{10,11}$/','unique:users,phone,'.$userId],
            // mật khẩu cho phép bỏ trống; nếu nhập thì phải confirmed + min
            'password'   => ['nullable','min:8','confirmed','different:username'],
        ];
    }

    public function attributes(): array
    {
        return [
            'username'   => 'username',
            'first_name' => 'họ',
            'last_name'  => 'tên',
            'gender'     => 'giới tính',
            'address'    => 'địa chỉ',
            'email'      => 'email',
            'phone'      => 'số điện thoại',
            'password'   => 'mật khẩu',
        ];
    }
}
