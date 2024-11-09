<?php
$router->add('role', ['controller' => 'RoleController', 'action' => 'index']);
$router->add('role/create', ['controller' => 'RoleController', 'action' => 'create']);
$router->add('role/store', ['controller' => 'RoleController', 'action' => 'store']);