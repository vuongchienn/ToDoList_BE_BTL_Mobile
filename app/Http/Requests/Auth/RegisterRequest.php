<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\BaseFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends BaseFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|max:255|confirmed',
        ];
    }
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $password = $this->input('password');

            if (!preg_match('/[a-z|A-Z]/', $password)) {
                return $validator->errors()->add('password', 'Mật khẩu phải chứa ít nhất 1 kí tự.');
            }

            if (!preg_match('/\d/', $password)) {
                return $validator->errors()->add('password', 'Mật khẩu phải chứa ít nhất 1 chữ số.');
            }

            if (!preg_match('/[^a-zA-Z0-9]/', $password)) {
                return $validator->errors()->add('password', 'Mật khẩu phải chứa ít nhất 1 ký tự đặc biệt.');
            }
        });
    }
}
