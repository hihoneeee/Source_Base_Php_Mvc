<?php

namespace App\controllers;

use App\core\Controller;
use App\DTOs\Common\PaginationDTO;
use App\DTOs\Role;
use App\Services\RoleService;

class RoleController extends Controller
{
    private $_roleService;

    public function __construct(RoleService $roleService)
    {
        $this->_roleService = $roleService;
    }
    public function index()
    {
        $limit = LIMIT;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $name = isset($_GET['name']) ? $_GET['name'] : '';

        $response = $this->_roleService->getAllRoles($limit, $page, $name);
        $totalPages = ceil($response->total / $limit);

        $paginationDTO = new PaginationDTO($page, $totalPages, 'role');

        $this->render('Admin', 'Role/index', [
            'roles' => $response->data,
            'paginationDTO' => $paginationDTO,
            'name' => $name
        ]);
    }
    public function detail($id)
    {
        $roleDTO = new Role\GetRoleDTO();
        $response = $this->_roleService->getRoleDetail($id, $roleDTO);
        $this->render('Admin', 'Role/detail', ['role' => $response->data]);
    }
    public function create()
    {
        $this->render('Admin', 'Role/form');
    }
    public function store()
    {
        $createRoleDTO = new Role\CreateRoleDTO($_POST['value']);
        if (!$createRoleDTO->isValid()) {
            $this->render('Admin', 'Role/form', ['errors' => $createRoleDTO->errors]);
            return;
        }
        $response = $this->_roleService->createRole($createRoleDTO);
        $_SESSION['toastMessage'] = $response->message;
        $_SESSION['toastSuccess'] = $response->success;
        if ($response->success) {
            $this->redirectToAction('admin', 'role', 'index');
        } else {
            $this->redirectToAction('admin', 'role', 'create');
        }
    }

    public function edit($id)
    {
        $response = $this->_roleService->getRoleById($id);
        if ($response->success) {
            $role = $response->data;
            $this->render('Admin', 'Role/form', ['role' => $role]);
        } else {
            $this->render('Admin', 'Home/error', ['message' => 'Role not found']);
        }
    }

    public function update($id)
    {
        $createRoleDTO = new Role\CreateRoleDTO($_POST['value']);

        if (!$createRoleDTO->isValid()) {
            $this->render('Admin', 'Role/form', ['errors' => $createRoleDTO->errors]);
            return;
        }

        $response = $this->_roleService->updateRole($id, $createRoleDTO);
        $_SESSION['toastMessage'] = $response->message;
        $_SESSION['toastSuccess'] = $response->success;

        if ($response->success) {
            $this->redirectToAction('admin', 'role', 'index');
        } else {
            $this->redirectToAction('admin', 'role', 'edit', $id);
        }
    }

    public function delete($id)
    {
        $response = $this->_roleService->deleteRole($id);
        $_SESSION['toastMessage'] = $response->message;
        $_SESSION['toastSuccess'] = $response->success;
        if ($response->success) {
            $this->redirectToAction('admin', 'role', 'index');
        } else {
            $this->redirectToAction('admin', 'home', '404');
        }
    }
}
