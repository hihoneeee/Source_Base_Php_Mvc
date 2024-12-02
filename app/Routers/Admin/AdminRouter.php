<?php

namespace App\Routers\Admin;

use App\Core\Router;

class AdminRouter
{
    public static function register(Router $router)
    {
        $router->add('admin', [
            'controller' => 'AdminController',
            'action' => 'index',
        ]);

        $router->add('admin/404', [
            'controller' => 'AdminController',
            'action' => 'notFound',
        ]);
    }
}