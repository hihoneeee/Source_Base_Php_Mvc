<?php
require_once './app/core/Controller.php';

class UserController extends Controller {
    protected $_userService;

    public function __construct(UserService $userService) {
        $this->_userService = $userService;
    }

    public function index() {
        $response = $this->_userService->getAllUsers();
        $this->render('User/index', ['users' => $response->data]);

    }

    public function delete($id) {
        $response = $this->_userService->deleteUser($id);
        if ($response->success) {
            $this->redirectToAction('user', 'index');
        } else {
            $this->render('User/error', ['message' => $response->message]);
        }
    }
    
    
    public function show($id) {
        $user = $this->_userService->getUserById($id);
         $this->render('User/show', ['user' => $user]);
    }

    public function create() {
        $this->render('User/form');
    }

    public function store() {
    }
}