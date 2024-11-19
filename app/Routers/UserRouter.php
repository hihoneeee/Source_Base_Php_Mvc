<?php

namespace App\Routers;

use App\Core\Router;

class UserRouter
{
    public static function register(Router $router)
    {
        $router->add('user', ['controller' => 'UserController', 'action' => 'index']);
        $router->add('user/create', ['controller' => 'UserController', 'action' => 'create']);
        $router->add('user/store', ['controller' => 'UserController', 'action' => 'store']);
        $router->add('user/delete/{id}', ['controller' => 'UserController', 'action' => 'delete']);
        $router->add('user/edit/{id}', ['controller' => 'UserController', 'action' => 'edit']);
        $router->add('user/update/{id}', ['controller' => 'UserController', 'action' => 'update']);
        $router->add('user/detail/{id}', ['controller' => 'UserController', 'action' => 'detail']);
    }
}
