<?php

namespace App\Routers\Admin;

use App\Core\Router;

class CategoryRouter
{
    public static function register(Router $router)
    {
        $router->add('admin/category', [
            'controller' => 'CategoryController',
            'action' => 'index',
            'roles' => ['Admin'],
        ]);
        $router->add('admin/category/create', [
            'controller' => 'CategoryController',
            'action' => 'create',
            'roles' => ['Admin'],
        ]);
        $router->add('admin/category/store', [
            'controller' => 'CategoryController',
            'action' => 'store',
            'roles' => ['Admin'],
        ]);
        $router->add('admin/category/delete/{id}', [
            'controller' => 'CategoryController',
            'action' => 'delete',
            'roles' => ['Admin'],
        ]);
        $router->add('admin/category/edit/{id}', [
            'controller' => 'CategoryController',
            'action' => 'edit',
            'roles' => ['Admin'],
        ]);
        $router->add('admin/category/update/{id}', [
            'controller' => 'CategoryController',
            'action' => 'update',
            'roles' => ['Admin'],
        ]);
        $router->add('admin/category/detail/{id}', [
            'controller' => 'CategoryController',
            'action' => 'detail',
            'roles' => ['Admin'],
        ]);
    }
}
