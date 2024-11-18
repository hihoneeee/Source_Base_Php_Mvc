<?php
require_once './app/core/Controller.php';
require_once './app/DTOs/Common/QueryParamsDTO.php';
require_once './app/DTOs/Common/PaginationDTO.php';
require_once './app/Helpers/PaginationHelper.php';
require_once './app/DTOs/Role/GetRoleDTO.php';

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

        $this->render('Role/index', [
            'roles' => $response->data,
            'paginationDTO' => $paginationDTO,
            'name' => $name
        ]);
    }
    public function detail($id)
    {
        $roleDTO = new GetRoleDTO();
        $response = $this->_roleService->getRoleDetail($id, $roleDTO);
        $this->render('Role/detail', ['role' => $response->data]);
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