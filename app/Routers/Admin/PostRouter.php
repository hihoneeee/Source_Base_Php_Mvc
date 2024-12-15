<?php

namespace App\Routers\Admin;

use App\Core\Router;

class PostRouter
{
    public static function register(Router $router)
    {
        $router->add('admin/post', [
            'controller' => 'PostController',
            'action' => 'index',
        ]);
        $router->add('admin/post/create', [
            'controller' => 'PostController',
            'action' => 'create',
        ]);
        $router->add('admin/post/store', [
            'controller' => 'PostController',
            'action' => 'store',
        ]);
        $router->add('admin/post/delete/{id}', [
            'controller' => 'PostController',
            'action' => 'delete',
        ]);
        $router->add('admin/post/edit/{id}', [
            'controller' => 'PostController',
            'action' => 'edit',
        ]);
        $router->add('admin/post/update/{id}', [
            'controller' => 'PostController',
            'action' => 'update',
        ]);
    }
}
