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

    public static function generateRandomPassword(int $length): string
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $password = '';
        for ($i = 0; $i < $length; $i++) {
            $password .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $password;
    }
}
