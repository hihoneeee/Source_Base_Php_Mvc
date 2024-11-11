<?php
require_once './app/core/Controller.php';

class RoleController extends Controller
{
    private $_roleService;

    public function __construct(RoleService $roleService)
    {
        $this->_roleService = $roleService;
    }
    public function index()
    {
        $response = $this->_roleService->getAllRoles();
        $this->render('Role/index', ['roles' => $response->data]);
    }
    public function create()
    {
        $this->render('Role/form');
    }
    public function store()
    {
        $createRoleDTO = new CreateRoleDTO($_POST['value']);
        if (!$createRoleDTO->isValid()) {
            $this->render('Role/form', ['dto' => $createRoleDTO, 'errors' => $createRoleDTO->errors]);
            return;
        }
        $response = $this->_roleService->createRole($createRoleDTO);
        $_SESSION['toastMessage'] = $response->message;
        $_SESSION['toastSuccess'] = $response->success;
        if ($response->success) {
            $this->redirectToAction('role', 'index');
        } else {
            $this->redirectToAction('role', 'create');
        }
    }

    public function edit($id)
    {
        $response = $this->_roleService->getRoleById($id);
        if ($response->success) {
            $role = $response->data;
            // var_dump($role); dùng để log data ra
            $this->render('Role/form', ['role' => $role]);
        } else {
            $this->render('Home/error', ['message' => 'Role not found']);
        }
    }

    public function update($id)
    {
        $createRoleDTO = new CreateRoleDTO($_POST['value']);

        if (!$createRoleDTO->isValid()) {
            $this->render('Role/form', ['dto' => $createRoleDTO, 'errors' => $createRoleDTO->errors]);
            return;
        }

        $response = $this->_roleService->updateRole($id, $createRoleDTO);
        $_SESSION['toastMessage'] = $response->message;
        $_SESSION['toastSuccess'] = $response->success;

        if ($response->success) {
            $this->redirectToAction('role', 'index');
        } else {
            $this->redirectToAction('role', 'edit', ['id' => $id]);
        }
    }

    public function delete($id)
    {
        $response = $this->_roleService->deleteRole($id);
        $_SESSION['toastMessage'] = $response->message;
        $_SESSION['toastSuccess'] = $response->success;
        if ($response->success) {
            $this->redirectToAction('role', 'index');
        } else {
            $this->redirectToAction('home', '404');
        }
    }
}