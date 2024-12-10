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
            'roles' => ['Admin'],
        ]);
        $router->add('admin/user/create', [
            'controller' => 'UserController',
            'action' => 'create',
            'roles' => ['Admin'],
        ]);
        $router->add('admin/user/store', [
            'controller' => 'UserController',
            'action' => 'store',
            'roles' => ['Admin'],
        ]);
        $router->add('admin/user/delete/{id}', [
            'controller' => 'UserController',
            'action' => 'delete',
            'roles' => ['Admin'],
        ]);
        $router->add('admin/user/edit/{id}', [
            'controller' => 'UserController',
            'action' => 'edit',
            'roles' => ['Admin'],
        ]);
        $router->add('admin/user/update/{id}', [
            'controller' => 'UserController',
            'action' => 'update',
            'roles' => ['Admin'],
        ]);
        $router->add('admin/user/profile/{id}', [
            'controller' => 'UserController',
            'action' => 'profileUserSystem',
            'roles' => ['Admin', 'Writer'],
        ]);
        $router->add('admin/user/update-profile/{id}', [
            'controller' => 'UserController',
            'action' => 'updateProfileUserSystem',
            'roles' => ['Admin', 'Writer'],
        ]);
    }
}
