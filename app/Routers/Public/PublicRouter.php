<?php

namespace App\Routers\Public;

use App\Core\Router;

class PublicRouter
{
    public static function register(Router $router)
    {
        $router->add('', [
            'controller' => 'PublicController',
            'action' => 'Index',
        ]);
        $router->add('404', [
            'controller' => 'PublicController',
            'action' => 'NotFound',
        ]);
        $router->add('danh-muc/{id}', [
            'controller' => 'PublicController',
            'action' => 'Category',
        ]);
        $router->add('tin-tuc/{id}', [
            'controller' => 'PublicController',
            'action' => 'Post',
        ]);
        $router->add('dang-ky', [
            'controller' => 'PublicController',
            'action' => 'Register',
        ]);
        $router->add('verify-register', [
            'controller' => 'PublicController',
            'action' => 'VerifyRegister',
        ]);
        $router->add('dang-nhap', [
            'controller' => 'PublicController',
            'action' => 'Login',
        ]);
        $router->add('verify-account', [
            'controller' => 'PublicController',
            'action' => 'VerifyAccount',
        ]);
        $router->add('dang-xuat', [
            'controller' => 'PublicController',
            'action' => 'Logout',
        ]);
        $router->add('tim-kiem', [
            'controller' => 'PublicController',
            'action' => 'Search',
        ]);
        $router->add('trang-ca-nhan/{id}', [
            'controller' => 'PublicController',
            'action' => 'Profile',
        ]);
        $router->add('quen-mat-khau', [
            'controller' => 'PublicController',
            'action' => 'ForgotPassword',
        ]);
    }
}
