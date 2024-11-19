<?php
namespace App\DTOs\User;

class CreateUserDTO
{
    public $first_name;
    public $last_name;
    public $email;
    public $role_id;
    public $errors = [];

    public function __construct($first_name, $last_name, $email, $role_id)
    {
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->email = $email;
        $this->role_id = $role_id;
    }

    public function isValid()
    {
        $this->errors = [];

        // Validate first_name
        if (empty($this->first_name)) {
            $this->errors['first_name'] = 'Họ đệm không được bỏ trống.';
        } elseif (strlen($this->first_name) > 20) {
            $this->errors['first_name'] = 'Họ đệm cần bé hơn 20 ký tự!';
        }

        // Validate last_name
        if (empty($this->last_name)) {
            $this->errors['last_name'] = 'Tên không được bỏ trống.';
        } elseif (strlen($this->last_name) > 10) {
            $this->errors['last_name'] = 'Tên cần bé hơn 10 ký tự!';
        }

        // Validate email
        if (empty($this->email)) {
            $this->errors['email'] = 'Email không được bỏ trống.';
        } elseif (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $this->errors['email'] = 'Định dạng email không hợp lệ.';
        }

        // Validate role_id
        if (empty($this->role_id)) {
            $this->errors['role_id'] = 'Vai trò không được bỏ trống.';
        } elseif (!is_numeric($this->role_id)) {
            $this->errors['role_id'] = 'Vai trò phải là một số hợp lệ.';
        }

        return empty($this->errors);
    }
}