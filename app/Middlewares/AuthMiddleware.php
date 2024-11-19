<?php

namespace App\Middlewares;

class AuthMiddleware
{
    public function handle()
    {
        $currentPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $excludedPaths = [
            '/auth/login',
            '/auth/verifyAccount',
        ];

        // First, check if the user is already logged in (has a token)
        $isLoggedIn = isset($_COOKIE['TestToken']) && !empty($_COOKIE['TestToken']);

        // If user is already logged in and tries to access login page, redirect to home
        if ($isLoggedIn && $currentPath === '/auth/login') {
            header("Location: /home");
            exit();
        }

        // If path is excluded, allow access
        if (in_array($currentPath, $excludedPaths)) {
            return;
        }

        // For all other paths, require authentication
        if (!$isLoggedIn) {
            header("Location: /auth/login");
            exit();
        }
    }
}
