<?php

namespace App\Middlewares;

use App\Helpers\JwtToken;

class AuthMiddleware
{
    public function handle()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $currentPath = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

        $excludedPaths = [
            'admin/auth/login',
            'admin/auth/verifyAccount',
        ];

        $isLoggedIn = isset($_COOKIE['TestToken']) && !empty($_COOKIE['TestToken']);
        $userRole = null;

        if ($isLoggedIn) {
            try {
                $decodedToken = JwtToken::decodeJWTToken($_COOKIE['TestToken']);
                $userRole = strtolower($decodedToken->role ?? '');

                // Ngăn truy cập vào trang login nếu đã đăng nhập
                if ($currentPath === 'admin/auth/login' && $userRole === 'admin') {
                    header("Location: /admin");
                    exit();
                }

                // Ngăn role "user" truy cập vào admin
                if (strpos($currentPath, 'admin') === 0 && $userRole == 'user') {
                    $_SESSION['toastMessage'] = 'Bạn không có quyền truy cập!';
                    $this->redirectUnauthorized();
                }
            } catch (\Exception $e) {
                $_SESSION['toastMessage'] = 'Token không hợp lệ!';
                $this->redirectUnauthorized();
            }
        } else {
            if (strpos($currentPath, 'admin') === 0 && !in_array($currentPath, $excludedPaths)) {
                header("Location: /admin/auth/login");
                exit();
            }
        }
    }

    private function redirectUnauthorized()
    {
        header("Location: /");
        exit();
    }
}
