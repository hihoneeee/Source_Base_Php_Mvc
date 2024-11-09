<?php

class CreateUserDTO {
    public $first_name;
    public $last_name;
    public $email;
    public $password;

    public function __construct($first_name, $last_name, $email, $phone, $password) {
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->email = $email;
        $this->password = $password;
    }
}