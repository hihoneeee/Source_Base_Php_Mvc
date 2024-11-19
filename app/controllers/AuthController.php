<?php

namespace App\controllers;

use App\core\Controller;
use App\DTOs\Auth\AuthLoginDTO;
use App\Services\AuthService;

class AuthController extends Controller
{

    private $_authService;
    public function __construct(AuthService $authService)
    {
        $this->_authService = $authService;
    }
    public function ViewLogin()
    {
        $this->renderForLogin('Admin/login');
    }


    public function VerifyAccount()
    {
        $LoginDto = new AuthLoginDTO($_POST['email'], $_POST['password']);
        if (!$LoginDto->isValid()) {
            $this->renderForLogin('Auth/login', ['dto' => $LoginDto, 'errors' => $LoginDto->errors]);
            return;
        }
        $response = $this->_authService->login($LoginDto);
        $_SESSION['toastMessage'] = $response->message;
        $_SESSION['toastSuccess'] = $response->success;
        if ($response->success) {
            $this->redirectToAction('home', 'index');
        } else {
            $this->redirectToAction('auth', 'login');
        }
    }

    public function Logout()
    {
        $response = $this->_authService->Logout();
        $_SESSION['toastMessage'] = $response->message;
        $_SESSION['toastSuccess'] = $response->success;
        $this->redirectToAction('auth', 'login');
    }
}
