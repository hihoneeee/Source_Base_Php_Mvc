<?php

class GetUserDTO {
    public $username;
    public $email; 
    public $firstName;
    public $lastName;
    public $id;

    public function __construct($id, $username, $email, $firstName, $lastName) {
        $this->id = $id;
        $this->username = $username;
        $this->email = $email;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
    }
}   