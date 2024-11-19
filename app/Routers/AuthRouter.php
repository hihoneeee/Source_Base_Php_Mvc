<?php

namespace App\Routers;

use App\Core\Router;

class AuthRouter
{
    public static function register(Router $router)
    {
        $router->add('auth/login', [
            'controller' => 'AuthController',
            'action' => 'ViewLogin',
        ]);
        $router->add('auth/verifyAccount', [
            'controller' => 'AuthController',
            'action' => 'VerifyAccount',
        ]);
        $router->add('auth/logout', [
            'controller' => 'AuthController',
            'action' => 'Logout',
        ]);
    }
}
