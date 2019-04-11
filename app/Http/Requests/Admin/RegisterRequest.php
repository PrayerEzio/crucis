<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;

class RegisterRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|email|unique:admins,email',
            'password' => 'required|confirmed|between:8,32',
            'register_protocol' => 'accepted'
        ];
    }

    public function messages()
    {
        return [
            'email.required' => '请输入您的邮箱.',
            'email.email' => '您输入的邮箱地址不正确.',
            'email.unique' => '您输入的邮箱已经被注册.',
            'password.required' => '请输入您的密码.',
            'password.confirmed' => '两次输入的密码不一致.',
            'password.between' => '密码长度必须在8到32位之间.',
            'register_protocol.accepted' => '请同意我们的注册协议.'
        ];
    }
}
