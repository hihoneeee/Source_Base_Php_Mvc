<?php

class User {
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

    public function __construct($id, $first_name, $last_name, $email, $phone, $avatar, $password, $role_id, $created_at, $updated_at) {
        $this->id = $id;
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->email = $email;
        $this->phone = $phone;
        $this->avatar = $avatar;
        $this->password = $password;
        $this->role_id = $role_id;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }
}