<?php

namespace App\Helpers;

class HashPassword
{
    public static function GenerateHash(string $password): string
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    public static function VerifyPassword(string $password, string $hashedPassword): bool
    {
        return password_verify($password, $hashedPassword);
    }
}