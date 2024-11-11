<?php
$router->add('role', ['controller' => 'RoleController', 'action' => 'index']);
$router->add('role/create', ['controller' => 'RoleController', 'action' => 'create']);
$router->add('role/store', ['controller' => 'RoleController', 'action' => 'store']);
$router->add('role/delete/{id}', ['controller' => 'RoleController', 'action' => 'delete']);
$router->add('role/edit/{id}', ['controller' => 'RoleController', 'action' => 'edit']);
$router->add('role/update/{id}', ['controller' => 'RoleController', 'action' => 'update']);
