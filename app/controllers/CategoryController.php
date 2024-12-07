<?php

namespace App\Controllers;

use App\Core\Controller;
use App\DTOs\Common\PaginationDTO;
use App\DTOs\Category;
use App\Services\CategoryService;
use Exception;

class CategoryController extends Controller
{
    private $_categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->_categoryService = $categoryService;
    }

    public function index()
    {
        $limit = LIMIT;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $name = isset($_GET['name']) ? $_GET['name'] : '';

        $response = $this->_categoryService->getAllCategories($limit, $page, $name);
        $totalPages = ceil($response->total / $limit);

        $paginationDTO = new PaginationDTO($page, $totalPages, 'category');
        $this->render('Admin', 'Category/index', [
            'categories' => $response->data,
            'paginationDTO' => $paginationDTO,
            'name' => $name
        ]);
    }

    public function create()
    {
        $this->render('Admin', 'Category/form');
    }

    public function store()
    {
        $createCategoryDTO = new Category\FormCategoryDTO($_POST['title'], $_POST['description'], $_FILES['avatar']);
        if (!$createCategoryDTO->isValid()) {
            $this->render('Admin', 'Category/form', ['dto' => $createCategoryDTO, 'errors' => $createCategoryDTO->errors]);
            return;
        }
        $response = $this->_categoryService->createCategory($createCategoryDTO);
        $_SESSION['toastMessage'] = $response->message;
        $_SESSION['toastSuccess'] = $response->success;
        $this->redirectToAction('admin', 'category', 'index');
    }

    public function edit($id)
    {
        $response = $this->_categoryService->getCategoryById($id);
        if ($response->success) {
            $category = $response->data;
            $this->render('Admin', 'Category/form', ['category' => $category]);
        } else {
            $this->render('Admin', 'Home/error', ['message' => 'Category not found']);
        }
    }

    public function update($id)
    {
        $createCategoryDTO = new Category\FormCategoryDTO($_POST['title'], $_POST['description'], $_FILES['avatar']);
        if (!$createCategoryDTO->isValid(true)) {
            $this->render('Admin', 'Category/form', ['dto' => $createCategoryDTO, 'errors' => $createCategoryDTO->errors]);
            return;
        }


        $response = $this->_categoryService->updateCategory($id, $createCategoryDTO);
        $_SESSION['toastMessage'] = $response->message;
        $_SESSION['toastSuccess'] = $response->success;

        if ($response->success) {
            $this->redirectToAction('admin', 'category', 'index');
        } else {
            $this->redirectToAction('admin', 'category', 'edit', ['id' => $id]);
        }
    }

    public function delete($id)
    {
        $response = $this->_categoryService->deleteCategory($id);
        $_SESSION['toastMessage'] = $response->message;
        $_SESSION['toastSuccess'] = $response->success;
        if ($response->success) {
            $this->redirectToAction('admin', 'category', 'index');
        } else {
            $this->redirectToAction('admin', 'home', '404');
        }
    }
}