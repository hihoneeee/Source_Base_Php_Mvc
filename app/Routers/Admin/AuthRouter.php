<?php

namespace App\Routers\Admin;

use App\Core\Router;

class AuthRouter
{
    public static function register(Router $router)
    {
        $router->add('admin/auth/login', [
            'controller' => 'AuthController',
            'action' => 'ViewLogin',
        ]);
        $router->add('admin/auth/verifyAccount', [
            'controller' => 'AuthController',
            'action' => 'VerifyAccount',
        ]);
        $router->add('admin/auth/logout', [
            'controller' => 'AuthController',
            'action' => 'Logout',
        ]);
    }
}
