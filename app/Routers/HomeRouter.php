<?php

namespace App\Routers;

use App\Core\Router;

class HomeRouter
{
    public static function register(Router $router)
    {
        $router->add('', ['controller' => 'HomeController', 'action' => 'index']);
        $router->add('home', ['controller' => 'HomeController', 'action' => 'index']);
        $router->add('404', ['controller' => 'HomeController', 'action' => 'notFound']);
    }
}
