<?php

namespace App\DTOs\User;

class ProfileUserDTO
{
    public $id;
    public $first_name;
    public $last_name;
    public $email;
    public $phone;
    public $avatar;
    public $role_id;
    public $created_at;
    public $updated_at;
    public $dataPosts = [];
}
