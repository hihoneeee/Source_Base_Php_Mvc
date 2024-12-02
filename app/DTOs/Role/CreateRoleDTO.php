<?php

namespace App\DTOs\Role;

class CreateRoleDTO
{
    public $value;
    public $errors = [];

    public function __construct($value)
    {
        $this->value = $value;
    }

    public function isValid()
    {
        $this->errors = []; // Reset errors

        if (empty($this->value)) {
            $this->errors['value'] = 'Tên vai trò không bỏ trống';
        } elseif (strlen($this->value) < 3) {
            $this->errors['value'] = 'Tên vai trò phải có ít nhất 3 ký tự!';
        }

        return empty($this->errors); // Return true if there are no errors
    }
}
