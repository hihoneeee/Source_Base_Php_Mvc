<?php

namespace App\controllers;

use App\core\Controller;
use App\DTOs\Common\PaginationDTO;
use App\DTOs\User\CreateUserDTO;
use App\DTOs\User\UpdateUserDTO;
use App\repositories\RoleRepository;
use App\Services\UserService;

class UserController extends Controller
{
    private $_userService;
    private $_roleRepo;
    public function __construct(UserService $userService, RoleRepository $roleRepo)
    {
        $this->_userService = $userService;
        $this->_roleRepo = $roleRepo;
    }

    public function index()
    {
        $limit = LIMIT;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $name = isset($_GET['name']) ? $_GET['name'] : '';

        $response = $this->_userService->getAllUsers($limit, $page, $name);
        $totalPages = ceil($response->total / $limit);

        $paginationDTO = new PaginationDTO($page, $totalPages, 'user');
        $this->render('Admin', 'User/index', [
            'users' => $response->data,
            'paginationDTO' => $paginationDTO,
            'name' => $name
        ]);
    }

    public function delete($id)
    {
        $response = $this->_userService->deleteUser($id);
        $_SESSION['toastMessage'] = $response->message;
        $_SESSION['toastSuccess'] = $response->success;
        if ($response->success) {
            $this->redirectToAction('user', 'index');
        } else {
            $this->redirectToAction('home', '404');
        }
    }

    public function show($id)
    {
        $user = $this->_userService->getUserById($id);
        $this->render('User/show', ['user' => $user]);
    }

    public function create()
    {
        $dataRole = $this->_roleRepo->getListRole();
        $this->render('User/form', ['roles' => $dataRole]);
    }

    public function store()
    {
        $createUserDTO = new CreateUserDTO($_POST['first_name'], $_POST['last_name'], $_POST['email'], $_POST['password'], $_POST['role_id']);
        if (!$createUserDTO->isValid()) {
            $this->render('User/form', ['dto' => $createUserDTO, 'errors' => $createUserDTO->errors]);
            return;
        }
        $response = $this->_userService->createUser($createUserDTO);
        $_SESSION['toastMessage'] = $response->message;
        $_SESSION['toastSuccess'] = $response->success;
        if ($response->success) {
            $this->redirectToAction('user', 'index');
        } else {
            $this->redirectToAction('user', 'create');
        }
    }
    public function edit($id)
    {
        $response = $this->_userService->getUserById($id);
        if ($response->success) {
            $dataRole = $this->_roleRepo->getListRole();
            $user = $response->data;
            $this->render('User/form', ['user' => $user, 'roles' => $dataRole]);
        } else {
            $this->render('Home/error', ['message' => $response->message]);
        }
    }

    public function update($id)
    {
        $updateUserDTO = new UpdateUserDTO($_POST['first_name'], $_POST['last_name'], $_POST['email'], $_POST['role_id']);
        if (!$updateUserDTO->isValid()) {
            $this->render('User/form', ['dto' => $updateUserDTO, 'errors' => $updateUserDTO->errors]);
            return;
        }
        $response = $this->_userService->updateUser($id, $updateUserDTO);
        $_SESSION['toastMessage'] = $response->message;
        $_SESSION['toastSuccess'] = $response->success;

        if ($response->success) {
            $this->redirectToAction('user', 'index');
        } else {
            $this->redirectToAction('user', 'edit', ['id' => $id]);
        }
    }
}
