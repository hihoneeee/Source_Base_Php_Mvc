<?php

namespace App\DTOs\Auth;

class AuthLoginDTO
{
    public $email;
    public $password;
    public $errors = [];

    public function __construct($email, $password)
    {

        $this->email = $email;
        $this->password = $password;
    }

    public function isValid()
    {
        $this->errors = [];
        if (empty($this->email)) {
            $this->errors['email'] = 'Email không được bỏ trống.';
        } elseif (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $this->errors['email'] = 'Định dạng email không hợp lệ.';
        }

        if (empty($this->password)) {
            $this->errors['password'] = 'Mật khẩu không được bỏ trống.';
        } elseif (strlen($this->password) < 8) {
            $this->errors['password'] = 'Mật khẩu cần lớn hơn 8 ký tự.';
        }

        return empty($this->errors);
    }
}
