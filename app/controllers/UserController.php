<?php

namespace App\controllers;

use App\core\Controller;
use App\DTOs\Common\PaginationDTO;
use App\DTOs\User\CreateUserDTO;
use App\DTOs\User\UpdateProfileUserDTO;
use App\DTOs\User\UpdateUserDTO;
use App\Helpers\JwtToken;
use App\Services\RoleService;
use App\Services\UserService;

class UserController extends Controller
{
    private $_userService;
    private $_roleService;
    public function __construct(UserService $userService, RoleService $roleService)
    {
        $this->_userService = $userService;
        $this->_roleService = $roleService;
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
            $this->redirectToAction('admin', 'user', 'index');
        } else {
            $this->redirectToAction('admin', 'home', '404');
        }
    }

    public function show($id)
    {
        $user = $this->_userService->getUserById($id);
        $this->render('Admin', 'User/show', ['user' => $user]);
    }

    public function create()
    {
        $dataRole = $this->_roleService->getAllRoles();
        $this->render('Admin', 'User/form', ['roles' => $dataRole]);
    }

    public function store()
    {
        $createUserDTO = new CreateUserDTO($_POST['first_name'], $_POST['last_name'], $_POST['email'], $_POST['password'], $_POST['role_id']);
        if (!$createUserDTO->isValid()) {
            $this->render('Admin', 'User/form', ['errors' => $createUserDTO->errors]);
            return;
        }
        $response = $this->_userService->createUser($createUserDTO);
        $_SESSION['toastMessage'] = $response->message;
        $_SESSION['toastSuccess'] = $response->success;
        if ($response->success) {
            $this->redirectToAction('admin', 'user', 'index');
        } else {
            $this->redirectToAction('user', 'create');
        }
    }
    public function edit($id)
    {
        $response = $this->_userService->getUserById($id);
        $role = $this->_roleService->getRoleByValue('Admin');
        if ($response->data->role_id == $role->data->id) {
            $_SESSION['toastMessage'] = 'Không thể truy cập';
            $_SESSION['toastSuccess'] = false;
            $this->redirectToAction('admin', 'user', 'index');
        }
        if ($response->success) {
            $dataRole = $this->_roleService->getAllRoles();
            $user = $response->data;
            $this->render('Admin', 'User/form', ['user' => $user, 'roles' => $dataRole->data]);
        } else {
            $this->render('Admin', 'Home/error', ['message' => $response->message]);
        }
    }

    public function update($id)
    {
        $updateUserDTO = new UpdateUserDTO($_POST['first_name'], $_POST['last_name'], $_POST['email'], $_POST['role_id']);
        if (!$updateUserDTO->isValid()) {
            $this->render('Admin', 'User/form', ['errors' => $updateUserDTO->errors]);
            return;
        }
        $response = $this->_userService->updateUser($id, $updateUserDTO);
        $_SESSION['toastMessage'] = $response->message;
        $_SESSION['toastSuccess'] = $response->success;

        if ($response->success) {
            $this->redirectToAction('admin', 'user', 'index');
        } else {
            $this->redirectToAction('admin', 'user', 'edit', $id);
        }
    }

    public function profileUserSystem($id)
    {
        $response = $this->_userService->getUserById($id);
        if ($response->data->id != $_SESSION['user_info']->id) {
            $response->message = 'Người dùng không hợp lệ!';
            $response->success = false;
            $_SESSION['toastMessage'] = $response->message;
            $_SESSION['toastSuccess'] = $response->success;
            $this->redirectToAction('admin', '', 'index');
        }
        if ($response->success) {
            $this->render('Admin', 'User/profile', ['user' => $response->data]);
        }
    }

    public function updateProfileUserSystem($id)
    {
        $updateUserDTO = new UpdateProfileUserDTO($_POST['first_name'], $_POST['last_name'], $_POST['email'], $_POST['phone'], $_FILES['avatar']);
        if (!$updateUserDTO->isValid()) {
            $this->render('Admin', 'User/profile', ['errors' => $updateUserDTO->errors]);
            return;
        }
        $response = $this->_userService->updateProfileUserSystem($id, $updateUserDTO);
        $_SESSION['toastMessage'] = $response->message;
        $_SESSION['toastSuccess'] = $response->success;

        if ($response->success) {
            $currentToken = $_COOKIE['TestToken'] ?? null;

            if ($currentToken) {
                try {
                    $updatedData = [
                        'firstName' => $response->data->first_name,
                        'lastName' => $response->data->last_name,
                        'email' => $response->data->email,
                        'phone' => $response->data->phone,
                        'avatar' => $response->data->avatar,
                    ];
                    $newToken = JwtToken::updateJWTToken($currentToken, $updatedData);
                    $decoded = JwtToken::decodeJWTToken($newToken);
                    $expireTime = $decoded->exp ?? time() + 3600;
                    setcookie('TestToken', $newToken, $expireTime, '/');
                } catch (\Exception $e) {
                    error_log("Failed to update token: " . $e->getMessage());
                }
            }

            $this->redirectToAction('admin', 'user', 'profile', $id);
        } else {
            $this->redirectToAction('admin', 'user', 'profile', $id);
        }
    }
}