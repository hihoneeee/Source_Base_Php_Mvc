<?php

namespace App\controllers;

use App\core\Controller;
use App\DTOs\Auth\AuthLoginDTO;
use App\DTOs\Common\PaginationDTO;
use App\DTOs\User\CreateUserDTO;
use App\Repositories\CategoryRepository;
use App\Repositories\PostRepository;
use App\Repositories\RoleRepository;
use App\Services\AuthService;
use App\Services\CategoryService;
use App\Services\CommentService;
use App\Services\PostService;
use App\Services\UserService;

class PublicController extends Controller
{
    private $_categoryRepo;
    private $_postRepo;
    private $_categoryService;
    private $_postService;
    private $_authService;
    private $_roleRepo;
    private $_userService;
    private $_commentService;

    public function __construct(CategoryRepository $_categoryRepo, CategoryService $categoryService, PostRepository $postRepo, PostService $postService, AuthService $authService, RoleRepository $roleRepo, UserService $userService, CommentService $commentService)
    {
        $this->_categoryRepo = $_categoryRepo;
        $this->_categoryService = $categoryService;
        $this->_postRepo = $postRepo;
        $this->_postService = $postService;
        $this->_authService = $authService;
        $this->_roleRepo = $roleRepo;
        $this->_userService = $userService;
        $this->_commentService = $commentService;
    }
    public function Index()
    {
        $categories = $this->_categoryRepo->getListCategories();
        $this->render('Public', 'Home/index', ['categories' => $categories]);
    }

    public function NotFound()
    {
        $categories = $this->_categoryRepo->getListCategories();

        $this->render('Public', 'Home/notFound', ['categories' => $categories]);
    }

    public function Category($id)
    {
        $limit = LIMIT;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $response = $this->_categoryService->getCategoryDetailsById($id, $limit, $page);
        if ($response->success) {
            $totalPages = ceil($response->total / $limit);
            $paginationDTO = new PaginationDTO($page, $totalPages, "danh-muc/{$id}");
            $categories = $this->_categoryRepo->getListCategories();
            $postRandom = $this->_postRepo->getRandomPosts();
            $this->render('Public', 'Category/index', ['category' => $response->data, 'paginationDTO' => $paginationDTO, 'categories' => $categories, 'postRandom' => $postRandom]);
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

            $categories = $this->_categoryRepo->getListCategories();
            $getPostByCategory = $this->_postRepo->getPostsByCategoryId($response->data->dataCategory['id']);

            $this->render('Public', 'Post/detail', [
                'postDetail' => $response->data,
                'categories' => $categories,
                'getPostByCategory' => $getPostByCategory,
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
        $categories = $this->_categoryRepo->getListCategories();

        $this->render('Public', 'User/Register', ['categories' => $categories]);
    }

    public function VerifyRegister()
    {
        $getRole = $this->_roleRepo->getRoleByValue('User');
        $createUserDTO = new CreateUserDTO($_POST['first_name'], $_POST['last_name'], $_POST['email'], $_POST['password'], $getRole->id);
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

    public function Login()
    {
        $categories = $this->_categoryRepo->getListCategories();

        $this->render('Public', 'User/Login', ['categories' => $categories]);
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
        $categories = $this->_categoryRepo->getListCategories();
        $response = $this->_userService->getProfileById($id);
        if ($response->success) {
            $this->render('Public', 'User/profile', ['categories' => $categories, 'user' => $response->data, 'totalPost' => $response->total]);
        } else {
            $this->redirectToAction('public', '404');
        }
    }
}
