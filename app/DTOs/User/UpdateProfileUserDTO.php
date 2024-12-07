<?php

namespace App\DTOs\User;

class UpdateProfileUserDTO
{
    public $first_name;
    public $last_name;
    public $email;
    public $phone;
    public $avatar;
    public $errors = [];

    public function __construct($first_name, $last_name, $email, $phone, $avatar)
    {
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->email = $email;
        $this->phone = $phone;
        $this->avatar = $avatar;
    }

    public function isValid()
    {
        $this->errors = [];

        if (empty($this->first_name)) {
            $this->errors['first_name'] = 'Họ đệm không được bỏ trống.';
        } elseif (strlen($this->first_name) > 50) {
            $this->errors['first_name'] = 'Họ đệm cần bé hơn 20 ký tự!';
        }

        if (empty($this->last_name)) {
            $this->errors['last_name'] = 'Tên không được bỏ trống.';
        } elseif (strlen($this->last_name) > 10) {
            $this->errors['last_name'] = 'Tên cần bé hơn 10 ký tự!';
        }

        if (empty($this->email)) {
            $this->errors['email'] = 'Email không được bỏ trống.';
        } elseif (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $this->errors['email'] = 'Định dạng email không hợp lệ.';
        }
        if (empty($this->phone)) {
            $this->errors['phone'] = 'Điện thoại không được bỏ trống.';
        } elseif (!ctype_digit($this->phone)) {
            $this->errors['phone'] = 'Số điện thoại chỉ được chứa chữ số.';
        } elseif (!preg_match('/^0\d{9}$/', $this->phone)) {
            $this->errors['phone'] = 'Số điện thoại phải bắt đầu bằng 0 và có đúng 10 chữ số.';
        }
        if ($this->avatar && $this->avatar['error'] === UPLOAD_ERR_OK) {
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
            $fileName = $this->avatar['name'];
            $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

            if (!in_array($fileExtension, $allowedExtensions)) {
                $this->errors['avatar'] = 'Avatar phải là định dạng jpg, jpeg, png hoặc gif!';
            }

            if ($this->avatar['size'] > 2 * 1024 * 1024) { // 2MB
                $this->errors['avatar'] = 'Avatar không được vượt quá 2MB!';
            }
        }
        return empty($this->errors);
    }
}
