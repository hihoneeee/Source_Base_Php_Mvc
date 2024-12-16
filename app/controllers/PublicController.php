<?php

namespace App\controllers;

use App\core\Controller;
use App\DTOs\Auth\AuthLoginDTO;
use App\DTOs\Common\PaginationDTO;
use App\DTOs\User\CreateUserDTO;
use App\Services\AuthService;
use App\Services\CategoryService;
use App\Services\CommentService;
use App\Services\PostService;
use App\Services\RoleService;
use App\Services\UserService;

class PublicController extends Controller
{
    private $_categoryService;
    private $_postService;
    private $_authService;
    private $_userService;
    private $_commentService;
    private $_roleService;
    public function __construct(CategoryService $categoryService, RoleService $roleService, PostService $postService, AuthService $authService, UserService $userService, CommentService $commentService)
    {
        $this->_categoryService = $categoryService;
        $this->_postService = $postService;
        $this->_authService = $authService;
        $this->_userService = $userService;
        $this->_commentService = $commentService;
        $this->_roleService = $roleService;
    }
    public function Index()
    {
        $categories = $this->_categoryService->getListCategories();
        $this->render('Public', 'Home/index', ['categories' => $categories->data]);
    }

    public function NotFound()
    {
        $categories = $this->_categoryService->getListCategories();

        $this->render('Public', 'Home/notFound', ['categories' => $categories->data]);
    }

    public function Category($id)
    {
        $limit = LIMIT;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $response = $this->_categoryService->getCategoryDetailsById($id, $limit, $page);
        if ($response->success) {
            $totalPages = ceil($response->total / $limit);
            $paginationDTO = new PaginationDTO($page, $totalPages, "danh-muc/{$id}");
            $categories = $this->_categoryService->getListCategories();
            $postRandom = $this->_postService->getRandomPosts();
            $this->render('Public', 'Category/index', ['category' => $response->data, 'paginationDTO' => $paginationDTO, 'categories' => $categories->data, 'postRandom' => $postRandom->data]);
        } else {
            $this->redirectToAction('public', '404');
        }
    }

    public function Post($id)
    {
        $response = $this->_postService->getPostDetail($id);
        if ($response->success) {

            $limit = LIMIT;
            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            $commentList = $this->_commentService->getListCommentsByPostId($response->data->dataDetail['id'], $limit, $page);
            $totalPages = ceil($commentList->total / $limit);
            $paginationDTO = new PaginationDTO($page, $totalPages, "danh-muc/{$id}");

            $categories = $this->_categoryService->getListCategories();
            $getPostByCategory = $this->_postService->getPostsByCategoryId($response->data->dataCategory['id']);

            $this->render('Public', 'Post/detail', [
                'postDetail' => $response->data,
                'categories' => $categories->data,
                'getPostByCategory' => $getPostByCategory->data,
                'commentList' => $commentList->data,
                'totalComments' => $commentList->total,
                'paginationDTO' => $paginationDTO,
            ]);
        } else {
            $this->redirectToAction('public', '404');
        }
    }

    public function Register()
    {
        $categories = $this->_categoryService->getListCategories();

        $this->render('Public', 'User/Register', ['categories' => $categories->data]);
    }

    public function VerifyRegister()
    {
        $getRole = $this->_roleService->getRoleByValue('User');
        $createUserDTO = new CreateUserDTO($_POST['first_name'], $_POST['last_name'], $_POST['email'], $_POST['password'], $getRole->data->id);
        if (!$createUserDTO->isValid()) {
            $this->render('Admin', 'User/form', ['errors' => $createUserDTO->errors]);
            return;
        }
        $response = $this->_userService->createUser($createUserDTO);
        $_SESSION['toastSuccess'] = $response->success;
        if ($response->success) {
            $response->message = 'Đăng ký thành công!';
            $_SESSION['toastMessage'] = $response->message;
            $this->redirectToAction('public', 'dang-nhap');
        } else {
            $_SESSION['toastMessage'] = $response->message;
            $this->redirectToAction('public', 'dang-ky');
        }
    }

    public function ForgotPassword()
    {
        $categories = $this->_categoryService->getListCategories();

        $this->render('Public', 'User/forgotPassword', ['categories' => $categories->data]);
    }

    public function Login()
    {
        $categories = $this->_categoryService->getListCategories();

        $this->render('Public', 'User/Login', ['categories' => $categories->data]);
    }

    public function VerifyAccount()
    {
        $LoginDto = new AuthLoginDTO($_POST['email'], $_POST['password']);
        if (!$LoginDto->isValid()) {
            $this->render('Public', 'User/Login', ['dto' => $LoginDto, 'errors' => $LoginDto->errors]);
            return;
        }
        $response = $this->_authService->login($LoginDto);
        $_SESSION['toastMessage'] = $response->message;
        $_SESSION['toastSuccess'] = $response->success;
        if ($response->success) {
            setcookie('TestToken', $response->accessToken, [
                'expires' => $response->expireTime,
                'path' => '/',
                'httponly' => true,
                'secure' => true,
            ]);
            $this->redirectToAction('public', '', 'index');
        } else {
            $this->redirectToAction('public', 'dang-nhap');
        }
    }

    public function Logout()
    {
        $response = $this->_authService->Logout();
        $_SESSION['toastMessage'] = $response->message;
        $_SESSION['toastSuccess'] = $response->success;
        $this->redirectToAction('public', '', 'index');
    }

    public function Profile($id)
    {
        $categories = $this->_categoryService->getListCategories();
        $response = $this->_userService->getProfileById($id);
        if ($response->success) {
            $this->render('Public', 'User/profile', ['categories' => $categories->data, 'user' => $response->data, 'totalPost' => $response->total]);
        } else {
            $this->redirectToAction('public', '404');
        }
    }
}
