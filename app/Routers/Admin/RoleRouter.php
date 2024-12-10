<?php

namespace App\Routers\Admin;

use App\Core\Router;

class RoleRouter
{
    public static function register(Router $router)
    {
        $router->add('admin/role', [
            'controller' => 'RoleController',
            'action' => 'index',
            'roles' => ['Admin'],
        ]);

        $router->add('admin/role/create', [
            'controller' => 'RoleController',
            'action' => 'create',
            'roles' => ['Admin'],
        ]);

        $router->add('admin/role/store', [
            'controller' => 'RoleController',
            'action' => 'store',
            'roles' => ['Admin'],
        ]);

        $router->add('admin/role/delete/{id}', [
            'controller' => 'RoleController',
            'action' => 'delete',
            'roles' => ['Admin'],
        ]);

        $router->add('admin/role/edit/{id}', [
            'controller' => 'RoleController',
            'action' => 'edit',
            'roles' => ['Admin'],
        ]);

        $router->add('admin/role/update/{id}', [
            'controller' => 'RoleController',
            'action' => 'update',
            'roles' => ['Admin'],
        ]);

        $router->add('admin/role/detail/{id}', [
            'controller' => 'RoleController',
            'action' => 'detail',
            'roles' => ['Admin'],
        ]);
    }
}