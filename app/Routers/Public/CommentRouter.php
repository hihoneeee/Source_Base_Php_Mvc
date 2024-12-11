<?php

namespace App\Routers\Public;

use App\Core\Router;

class CommentRouter
{
    public static function register(Router $router)
    {
        $router->add('comment/create', [
            'controller' => 'CommentController',
            'action' => 'Create',
        ]);
        $router->add('comment/delete/{id}', [
            'controller' => 'CommentController',
            'action' => 'Delete',
        ]);
    }
}
