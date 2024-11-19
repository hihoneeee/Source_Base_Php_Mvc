<?php

namespace App\Middlewares;

use App\Helpers\JwtToken;

class HandleMiddleware
{
    private $jwtToken;

    // Constructor nhận đối tượng JwtToken
    public function __construct(JwtToken $jwtToken)
    {
        $this->jwtToken = $jwtToken;
    }

    // Hàm xử lý middleware
    public function handle()
    {
        // Kiểm tra xem cookie 'TestToken' có tồn tại hay không
        if (isset($_COOKIE['TestToken']) && !empty($_COOKIE['TestToken'])) {
            try {
                // Giải mã token và lấy thông tin người dùng
                $user = $this->jwtToken::getUserInfoFromToken($_COOKIE['TestToken']);

                // Lưu thông tin người dùng vào session nếu hợp lệ
                if ($user) {
                    $_SESSION['user_info'] = $user;
                } else {
                    // Token không hợp lệ hoặc hết hạn, xóa session và cookie
                    unset($_SESSION['user_info']);
                    setcookie('TestToken', '', time() - 3600, '/');
                }
            } catch (\Exception $e) {
                // Nếu token không hợp lệ hoặc có lỗi, xóa session và cookie
                unset($_SESSION['user_info']);
                setcookie('TestToken', '', time() - 3600, '/');
            }
        } else {
            // Xóa session nếu không có cookie
            unset($_SESSION['user_info']);
        }
    }
}
