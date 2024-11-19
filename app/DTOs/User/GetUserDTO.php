<?php

namespace App\DTOs\User;

class GetUserDTO
{
    public $username;
    public $email;
    public $firstName;
    public $lastName;
    public $id;
    public $dataRole;
    public function __construct($id, $username, $email, $firstName, $lastName, $dataRole)
    {
        $this->id = $id;
        $this->username = $username;
        $this->email = $email;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->dataRole = $dataRole;
    }
}
