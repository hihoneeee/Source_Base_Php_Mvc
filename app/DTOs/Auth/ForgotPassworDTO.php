<?php

namespace App\DTOs\Auth;

class ForgotPassworDTO
{
    public $email;
    public $errors = [];

    public function __construct($email)
    {
        $this->email = $email;
    }

    public function isValid()
    {
        $this->errors = [];
        if (empty($this->email)) {
            $this->errors['email'] = 'Email không được bỏ trống.';
        } elseif (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $this->errors['email'] = 'Định dạng email không hợp lệ.';
        }

        return empty($this->errors);
    }
}
