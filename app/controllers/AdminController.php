<?php

namespace App\controllers;

use App\core\Controller;
use App\Services\RoleService;
use App\Services\UserService;

class AdminController extends Controller
{
    private $_roleService;
    private $_userService;

    public function __construct(RoleService $roleService, UserService $userService)
    {
        $this->_roleService = $roleService;
        $this->_userService = $userService;
    }
    public function index()
    {
        $roles = $this->_roleService->getAllRoles($limit = 0, $page = 1, $name = null);
        $users = $this->_userService->getAllUsers($limit = 0, $page = 1, $name = null);
        $this->render('Admin', 'Home/index', [
            'totalRoles' => $roles->total,
            'totalUsers' => $users->total,
        ]);
    }

    public function notFound()
    {
        $this->render('Admin', 'Home/notFound');
    }
}
