<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAdminRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $adminId = $this->route('admin')->id;
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admin,email,' . $adminId,
            'password' => 'nullable|string|min:6',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Vui lòng nhập tên Admin.',
            'name.max' => 'Tên không được vượt quá 255 ký tự.',
            'email.required' => 'Vui lòng nhập địa chỉ email.',
            'email.email' => 'Email không đúng định dạng.',
            'email.unique' => 'Email này đã có người sử dụng rồi.',
            'password.min' => 'Mật khẩu mới phải có ít nhất 6 ký tự.',
        ];
    }
}
