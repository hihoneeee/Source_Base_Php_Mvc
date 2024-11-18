<?php

class User
{
    public $id;
    public $first_name;
    public $last_name;
    public $email;
    public $phone;
    public $avatar;
    public $password;
    public $role_id;
    public $created_at;
    public $updated_at;

    public function __construct()
    {
        $this->created_at = date('Y-m-d H:i:s');
        $this->updated_at = date('Y-m-d H:i:s');
    }
}
