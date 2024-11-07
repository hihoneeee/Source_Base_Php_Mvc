<?php

class User {
    public $id;
    public $username;
    public $firstName;
    public $lastName;
    public $email;

    public function __construct($username, $firstName, $lastName, $email, $id = null) {
        $this->id = $id;
        $this->username = $username;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
    }
}