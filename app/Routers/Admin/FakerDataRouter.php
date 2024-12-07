<?php

namespace App\Routers\Admin;

use App\Core\Router;

class FakerDataRouter
{
    public static function register(Router $router)
    {
        $router->add('generate-data', [
            'controller' => 'FakeDataController',
            'action' => 'generateAndInsertData',
        ]);
    }
}
