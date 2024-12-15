<?php

namespace App\Routers\Admin;

use App\Core\Router;

class ReportRouter
{
    public static function register(Router $router)
    {
        $router->add('admin/report', [
            'controller' => 'ReportController',
            'action' => 'index',
            'roles' => ['Admin'],
        ]);
        $router->add('admin/report/search', [
            'controller' => 'ReportController',
            'action' => 'search',
            'roles' => ['Admin'],
        ]);
        $router->add('admin/report/generator', [
            'controller' => 'ReportController',
            'action' => 'report',
            'roles' => ['Admin'],
        ]);
        $router->add('admin/report/time', [
            'controller' => 'ReportController',
            'action' => 'reportTime',
            'roles' => ['Admin'],
        ]);
        $router->add('admin/report/time/search', [
            'controller' => 'ReportController',
            'action' => 'reportTimeSearch',
            'roles' => ['Admin'],
        ]);
    }
}
