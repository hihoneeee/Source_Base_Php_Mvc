<?php

namespace App\Routers\Admin;

use App\Core\Router;

class UserRouter
{
    public static function register(Router $router)
    {
        $router->add('admin/user', [
            'controller' => 'UserController',
            'action' => 'index',
        ]);
        $router->add('admin/user/create', [
            'controller' => 'UserController',
            'action' => 'create',
        ]);
        $router->add('admin/user/store', [
            'controller' => 'UserController',
            'action' => 'store',
        ]);
        $router->add('admin/user/delete/{id}', [
            'controller' => 'UserController',
            'action' => 'delete',
        ]);
        $router->add('admin/user/edit/{id}', [
            'controller' => 'UserController',
            'action' => 'edit',
        ]);
        $router->add('admin/user/update/{id}', [
            'controller' => 'UserController',
            'action' => 'update',
        ]);
        $router->add('admin/user/detail/{id}', [
            'controller' => 'UserController',
            'action' => 'detail',
        ]);
    }
}
