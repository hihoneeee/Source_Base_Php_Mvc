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

        // Các đường dẫn không yêu cầu đăng nhập
        $excludedAdminPaths = [
            'admin/auth/login',
            'admin/auth/verifyAccount',
        ];

        // Các đường dẫn chỉ dành cho public
        $publicPaths = [
            'dang-nhap',
            'dang-ky',
        ];

        // Các đường dẫn yêu cầu đã đăng nhập
        $authRequiredPaths = [
            'dang-xuat',
        ];

        $isLoggedIn = isset($_COOKIE['TestToken']) && !empty($_COOKIE['TestToken']);
        $userRole = null;

        if ($isLoggedIn) {
            try {
                $decodedToken = JwtToken::decodeJWTToken($_COOKIE['TestToken']);
                $userRole = strtolower($decodedToken->role ?? '');

                // Ngăn truy cập vào các route dành cho public khi đã đăng nhập
                if (in_array($currentPath, $publicPaths)) {
                    $_SESSION['toastMessage'] = 'Bạn đã đăng nhập!';
                    header("Location: /");
                    exit();
                }

                // Ngăn role "user" truy cập vào admin
                if (strpos($currentPath, 'admin') === 0 && $userRole === 'user') {
                    $_SESSION['toastMessage'] = 'Bạn không có quyền truy cập!';
                    $this->redirectUnauthorized();
                }

                // Ngăn admin vào trang login khi đã đăng nhập
                if ($currentPath === 'admin/auth/login' && $userRole === 'admin') {
                    header("Location: /admin");
                    exit();
                }
            } catch (\Exception $e) {
                $_SESSION['toastMessage'] = 'Token không hợp lệ!';
                $this->redirectUnauthorized();
            }
        } else {
            // Ngăn người dùng chưa đăng nhập truy cập vào các route yêu cầu xác thực
            if (in_array($currentPath, $authRequiredPaths)) {
                $_SESSION['toastMessage'] = 'Bạn cần đăng nhập để thực hiện thao tác này!';
                header("Location: /dang-nhap");
                exit();
            }

            // Ngăn người dùng chưa đăng nhập vào trang admin
            if (strpos($currentPath, 'admin') === 0 && !in_array($currentPath, $excludedAdminPaths)) {
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
