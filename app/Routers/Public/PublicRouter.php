<?php

namespace App\Routers\Public;

use App\Core\Router;

class PublicRouter
{
    public static function register(Router $router)
    {
        $router->add('', [
            'controller' => 'PublicController',
            'action' => 'index',
        ]);
    }
}
