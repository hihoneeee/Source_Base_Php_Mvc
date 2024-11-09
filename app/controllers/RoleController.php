<?php
require_once './app/core/Controller.php';

class RoleController extends Controller {
    private $_roleService;

    public function __construct(RoleService $roleService) {
        $this->_roleService = $roleService;
    }
    public function index() {
        $response = $this->_roleService->getAllRoles();
        $this->render('Role/index', ['roles' => $response->data]);
    }
    public function create() {
        $this->render('Role/form');
    }
    public function store() {
        // Retrieve form data
        $value = $_POST['value'] ?? null;
    
        if ($value) {
            $createRoleDTO = new CreateRoleDTO($value);
            $response = $this->_roleService->createRole($createRoleDTO);
            
            if ($response->success) {
                $this->render('Role/index', ['roles' => $response->data]);        
            } else {
                $this->render('Role/error', ['message' => $response->message]);
            }
        } else {
            $this->render('Role/error', ['message' => 'Value is required']);
        }
    }
    
}