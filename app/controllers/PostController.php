<?php

namespace App\controllers;

use App\core\Controller;
use App\DTOs\Common\PaginationDTO;
use App\DTOs\Post;
use App\DTOs\Post\SearchCondition;
use App\Repositories\CategoryRepository;
use App\Repositories\UserRepository;
use App\Services\CategoryService;
use App\Services\PostService;
use App\Services\UserService;

class PostController extends Controller
{
    private $_postService;
    private $_userService;
    private $_categoryService;
    private $_categoryRepo;
    private $_userRepo;

    public function __construct(PostService $postService, UserService $userService, CategoryService $categoryService, CategoryRepository $categoryRepo, UserRepository $userRepo)
    {
        $this->_postService = $postService;
        $this->_categoryService = $categoryService;
        $this->_userService = $userService;
        $this->_categoryRepo = $categoryRepo;
        $this->_userRepo = $userRepo;
    }
    public function index()
    {
        $limit = LIMIT;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $name = isset($_GET['name']) ? $_GET['name'] : '';

        if ($_SESSION['user_info']->role === 'Admin') {
            $response = $this->_postService->getAllPostsByAdmin($limit, $page, $name);
        } elseif ($_SESSION['user_info']->role === 'Writer') {
            $userId = $_SESSION['user_info']->id;
            $response = $this->_postService->getPostsByUser($userId, $limit, $page, $name);
        }

        $totalPages = ceil($response->total / $limit);

        $paginationDTO = new PaginationDTO($page, $totalPages, 'post');

        $this->render('Admin', 'Post/index', [
            'posts' => $response->data,
            'paginationDTO' => $paginationDTO,
            'name' => $name
        ]);
    }
    public function create()
    {
        $dataCategory = $this->_categoryRepo->getListCategories();
        $getUser = $this->_userRepo->getUserById($_SESSION['user_info']->id);
        $userFullName = $getUser->first_name . ' ' . $getUser->last_name;
        $this->render('Admin', 'Post/form', ['categories' => $dataCategory, 'userFullName' => $userFullName]);
    }
    public function store()
    {
        $formPostDTO = new Post\FormPostDTO($_SESSION['user_info']->id, $_POST['category_id'], $_POST['status']);
        $formPostDetailDTO = new Post\FormPostDetailDTO($_POST['title'], $_POST['meta'], $_POST['content'], $_FILES['avatar']);

        if (!$formPostDTO->isValid()) {
            $this->render('Admin', 'Post/form', ['errors' => $formPostDTO->errors]);
            return;
        }
        if (!$formPostDetailDTO->isValid()) {
            $this->render('Admin', 'Post/form', ['errors' => $formPostDetailDTO->errors]);
            return;
        }

        $response = $this->_postService->createPost($formPostDTO, $formPostDetailDTO);
        $_SESSION['toastMessage'] = $response->message;
        $_SESSION['toastSuccess'] = $response->success;
        if ($response->success) {
            $this->redirectToAction('admin', 'post', 'index');
        } else {
            $this->redirectToAction('admin', 'post', 'create');
        }
    }
    public function edit($id)
    {

        $response = $this->_postService->getPostById($id);
        if ($response->success) {
            $dataCategory = $this->_categoryRepo->getListCategories();
            $getUser = $this->_userRepo->getUserById($response->data->user_id);
            $userFullName = $getUser->first_name . ' ' . $getUser->last_name;
            $this->render('Admin', 'Post/form', ['post' => $response->data, 'categories' => $dataCategory, 'userFullName' => $userFullName]);
        } else {
            $_SESSION['toastMessage'] = $response->message;
            $_SESSION['toastSuccess'] = $response->success;
            $this->redirectToAction('admin', 'post', 'index');
        }
    }
    public function update($id)
    {
        $formPostDTO = new Post\FormPostDTO($_SESSION['user_info']->id, $_POST['category_id'], $_POST['status']);
        $formPostDetailDTO = new Post\FormPostDetailDTO($_POST['title'], $_POST['meta'], $_POST['content'], $_FILES['avatar']);

        if (!$formPostDTO->isValid()) {
            $this->render('Admin', 'Post/form', ['errors' => $formPostDTO->errors]);
            return;
        }
        if (!$formPostDetailDTO->isValid()) {
            $this->render('Admin', 'Post/form', ['errors' => $formPostDetailDTO->errors]);
            return;
        }

        $response = $this->_postService->updatePost($id, $formPostDTO, $formPostDetailDTO);
        $_SESSION['toastMessage'] = $response->message;
        $_SESSION['toastSuccess'] = $response->success;

        if ($response->success) {
            $this->redirectToAction('admin', 'post', 'index');
        } else {
            $this->redirectToAction('admin', 'post', 'edit', $id);
        }
    }

    public function delete($id)
    {
        $response = $this->_postService->deletePost($id);
        $_SESSION['toastMessage'] = $response->message;
        $_SESSION['toastSuccess'] = $response->success;
        if ($response->success) {
            $this->redirectToAction('admin', 'post', 'index');
        } else {
            $this->redirectToAction('admin', 'post', 'index');
        }
    }

    public function report()
    {
        $categories = $this->_categoryService->getAll();
        $users = $this->_userService->getAll();

        $this->render('Admin', 'Post/report', [
            'categories' => $categories,
            'users' => $users,
        ]);
    }

    public function search()
    {
        $page = isset($_POST['page']) ? (int)$_POST['page'] : 1;
        $title = isset($_POST['title']) ? $_POST['title'] : '';
        $userId = isset($_POST['userId']) ? $_POST['userId'] : '';
        $categoryId = isset($_POST['categoryId']) ? $_POST['categoryId'] : '';

        $condition = new SearchCondition($title, $userId, $categoryId);
        $condition->setCurrentPage($page);
        $condition->setIsPagingUse(true);

        $categories = $this->_categoryService->getAll();
        $users = $this->_userService->getAll();
        $response = $this->_postService->getListPostsReport($condition);

        $this->render('Admin', 'Post/report', [
            'posts' => $response,
            'condition' => $condition,
            'categories' => $categories,
            'users' => $users,
        ]);
    }
}
