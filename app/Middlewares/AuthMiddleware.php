<?php

namespace App\Middlewares;

use App\Helpers\JwtToken;

class AuthMiddleware
{
    public function handle()
    {
        $currentPath = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

        $excludedPaths = [
            'admin/auth/login',
            'admin/auth/verifyAccount',
        ];

        // Kiểm tra token trong cookie
        $isLoggedIn = isset($_COOKIE['TestToken']) && !empty($_COOKIE['TestToken']);
        $userRole = null;

        if ($isLoggedIn) {
            try {
                // Giải mã JWT từ cookie
                $decodedToken = JwtToken::decodeJWTToken($_COOKIE['TestToken']);
                $userRole = $decodedToken->role ?? null;

                // Nếu userRole là "user" và đang cố truy cập admin
                if (strpos($currentPath, 'admin') === 0 && $userRole === 'user') {
                    header("Location: /");
                    exit();
                }
            } catch (\Exception $e) {
                // Nếu token không hợp lệ hoặc lỗi giải mã
                header("Location: /");
                exit();
            }
        }

        // Định tuyến các URL ngoại lệ
        if (in_array($currentPath, $excludedPaths)) {
            return;
        }

        // Nếu chưa đăng nhập và đang cố truy cập vào admin
        if (!$isLoggedIn && strpos($currentPath, 'admin') === 0) {
            header("Location: /admin/auth/login");
            exit();
        }
    }
}
