<?php

namespace App\Core;

class Router
{
    protected $routes = [];
    protected $controllers = [];

    public function __construct($controllers)
    {
        // Store controller instances
        $this->controllers = $controllers;
    }

    // Add route with controller and action
    public function add($route, $params)
    {
        $this->routes[$route] = $params;
    }

    // Dispatch method to determine route and call controller
    public function dispatch($url)
    {
        foreach ($this->routes as $route => $params) {
            $routePattern = preg_replace('/\{id\}/', '(\d+)', $route); // Convert {id} to digit sequence

            if (preg_match("#^$routePattern$#", $url, $matches)) {
                $controllerName = $params['controller'];
                $actionName = $params['action'];

                // Check if `id` is present
                $id = $matches[1] ?? null;

                if (isset($this->controllers[$controllerName]) && method_exists($this->controllers[$controllerName], $actionName)) {
                    $controller = $this->controllers[$controllerName];

                    // Call action with or without $id
                    $id ? $controller->$actionName($id) : $controller->$actionName();
                    return;
                } else {
                    echo "Controller or action does not exist.";
                    return;
                }
            }
        }
        echo "404 - Route not found";
    }
}