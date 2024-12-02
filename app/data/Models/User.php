<?php

namespace App\Data\Models;

class User
{
    public $id;
    public $first_name;
    public $last_name;
    public $email;
    public $phone;
    public $password;
    public $avatar;
    public $role_id;
    public $created_at;
    public $updated_at;

    public function __construct($data = [])
    {
        // Ensure required fields are set
        $this->first_name = $data['first_name'] ?? throw new \InvalidArgumentException("First name is required");
        $this->last_name = $data['last_name'] ?? throw new \InvalidArgumentException("Last name is required");
        $this->email = $data['email'] ?? throw new \InvalidArgumentException("Email is required");
        $this->phone = $data['phone'] ?? '';
        $this->password = $data['password'] ?? '';
        $this->avatar = $data['avatar'] ?? '';
        $this->role_id = $data['role_id'] ?? null;
        $this->created_at = date('Y-m-d H:i:s');
        $this->updated_at = date('Y-m-d H:i:s');
    }
}
