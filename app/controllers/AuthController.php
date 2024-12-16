<?php

namespace App\controllers;

use App\core\Controller;
use App\DTOs\Auth\AuthLoginDTO;
use App\DTOs\Auth\ForgotPassworDTO;
use App\DTOs\Post\FormPostDTO;
use App\Services\AuthService;
use App\Services\SendMailService;

class AuthController extends Controller
{

    private $_authService;
    private $_sendMailService;

    public function __construct(AuthService $authService, SendMailService $sendMailService)
    {
        $this->_authService = $authService;
        $this->_sendMailService = $sendMailService;
    }
    public function ViewLogin()
    {
        $this->renderForLoginAdmin('Auth/login');
    }


    public function VerifyAccount()
    {
        $LoginDto = new AuthLoginDTO($_POST['email'], $_POST['password']);
        if (!$LoginDto->isValid()) {
            $this->renderForLoginAdmin('Auth/login', ['dto' => $LoginDto, 'errors' => $LoginDto->errors]);
            return;
        }
        $response = $this->_authService->login($LoginDto);
        $_SESSION['toastMessage'] = $response->message;
        $_SESSION['toastSuccess'] = $response->success;
        if ($response->success) {
            setcookie('TestToken', $response->accessToken, [
                'expires' => $response->expireTime,
                'path' => '/',
                'httponly' => true,
                'secure' => true,
            ]);
            $this->redirectToAction('admin', '', 'index');
        } else {
            $this->redirectToAction('admin', 'auth', 'login');
        }
    }

    public function Logout()
    {
        $response = $this->_authService->Logout();
        $_SESSION['toastMessage'] = $response->message;
        $_SESSION['toastSuccess'] = $response->success;
        $this->redirectToAction('admin', 'auth', 'login');
    }

    public function ForgotPassword()
    {
        $forgotPassworDTO = new ForgotPassworDTO($_POST['email']);
        if (!$forgotPassworDTO->isValid()) {
            $this->render('Public', 'User/forgotPassword', ['dto' => $forgotPassworDTO, 'errors' => $forgotPassworDTO->errors]);
            return;
        }
        $response = $this->_authService->forgotPassword($forgotPassworDTO->email);
        $_SESSION['toastMessage'] = $response->message;
        $_SESSION['toastSuccess'] = $response->success;
        if ($response->success) {
            $emailBody = "Đây là mật khẩu mới của bạn: " . "<p><strong>$response->data</strong></p>";
            $sendMail = $this->_sendMailService->sendEmail($forgotPassworDTO->email, 'Thay Đổi mật khẩu mới tại Blogy.com', $emailBody);
            $_SESSION['toastMessage'] = $sendMail->message;
            $_SESSION['toastSuccess'] = $sendMail->success;
            if ($response->success) {
                $this->redirectToAction('public', 'dang-nhap');
            } else {
                $this->redirectToAction('public', 'quen-mat-khau');
            }
        } else {
            $this->redirectToAction('public', 'quen-mat-khau');
        }
    }
}
