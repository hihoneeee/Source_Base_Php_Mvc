<?php
$router->add('user', ['controller' => 'UserController', 'action' => 'index']);
$router->add('user/create', ['controller' => 'UserController', 'action' => 'create']);
$router->add('user/delete/{id}', ['controller' => 'UserController', 'action' => 'delete']);