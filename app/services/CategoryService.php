<?php

namespace App\Services;

use App\Repositories\CategoryRepository;
use App\Core\Mapper;
use App\Helpers\ServiceResponse;
use App\Helpers\ServiceResponseExtensions;
use App\Data\Models\Category;
use App\DTOs\Category as CategoryDTO;
use App\Helpers\HandleFileUpload;
use Exception;

class CategoryService
{
    private $_categoryRepo;
    private $_mapper;

    public function __construct(CategoryRepository $categoryRepo, Mapper $mapper)
    {
        $this->_categoryRepo = $categoryRepo;
        $this->_mapper = $mapper;
    }

    public function getAll()
    {
        return $this->_categoryRepo->getAll();
    }

    public function getAllCategories($limit, $page, $name)
    {
        $response = new ServiceResponse();
        try {
            $data = $this->_categoryRepo->getAllCategories($limit, $page, $name);
            $response->data = $data['categories'];
            $response->total = $data['total'];
            $response->limit = $limit;
            $response->page = $page;
            ServiceResponseExtensions::setSuccess($response, "Lấy danh sách danh mục thành công!");
        } catch (Exception $ex) {
            ServiceResponseExtensions::setError($response, $ex->getMessage());
        }
        return $response;
    }

    public function getCategoryDetailsById($id, $limit, $page)
    {
        $response = new ServiceResponse();
        try {
            $data = $this->_categoryRepo->getCategoryDetailsById($id, $limit, $page);
            if ($data == null) {
                ServiceResponseExtensions::setNotFound($response, "Danh mục");
                return $response;
            }
            $categoryDTO = new CategoryDTO\GetCategoryDTO();
            $getCategoryDTO = $this->_mapper->map($data['category'], $categoryDTO);
            $getCategoryDTO->dataPost = $data['posts'];
            $response->data = $getCategoryDTO;
            $response->total = $data['total'];
            $response->limit = $limit;
            $response->page = $page;
            ServiceResponseExtensions::setSuccess($response, "Lấy danh sách danh mục thành công!");
        } catch (Exception $ex) {
            ServiceResponseExtensions::setError($response, $ex->getMessage());
        }
        return $response;
    }

    public function getCategoryById($id)
    {
        $response = new ServiceResponse();
        try {
            $category = $this->_categoryRepo->getCategoryById($id);
            if ($category == null) {
                ServiceResponseExtensions::setNotFound($response, "Danh mục");
                return $response;
            }
            $response->data = $category;
            ServiceResponseExtensions::setSuccess($response, "Lấy danh mục thành công!");
        } catch (Exception $ex) {
            ServiceResponseExtensions::setError($response, $ex->getMessage());
        }
        return $response;
    }

    public function createCategory(CategoryDTO\FormCategoryDTO $formCategoryDTO)
    {
        $response = new ServiceResponse();

        try {
            $existingCategory = $this->_categoryRepo->getCategoryByTitle($formCategoryDTO->title);
            if ($existingCategory) {
                ServiceResponseExtensions::setExisting($response, "Danh mục");
                return $response;
            }
            $imageName = null;
            if ($formCategoryDTO->avatar && $formCategoryDTO->avatar['error'] === UPLOAD_ERR_OK) {
                $imageName = HandleFileUpload::handleImageUpload($formCategoryDTO->avatar, 'Category');
            }
            $formCategoryDTO->avatar = $imageName;
            $category = new Category();
            $newCategory = $this->_mapper->map($formCategoryDTO, $category);
            $this->_categoryRepo->createCategory($newCategory);
            ServiceResponseExtensions::setSuccess($response, "Tạo mới danh mục thành công!");
        } catch (Exception $ex) {
            ServiceResponseExtensions::setError($response, $ex->getMessage());
        }

        return $response;
    }

    public function updateCategory($id, CategoryDTO\FormCategoryDTO $formCategoryDTO)
    {
        $response = new ServiceResponse();
        try {
            $checkCategory = $this->_categoryRepo->getCategoryById($id);
            if ($checkCategory === null) {
                ServiceResponseExtensions::setNotFound($response, "Danh mục");
                return $response;
            }

            if ($checkCategory->title !== $formCategoryDTO->title) {
                $existingCategory = $this->_categoryRepo->getCategoryByTitle($formCategoryDTO->title);
                if ($existingCategory) {
                    ServiceResponseExtensions::setExisting($response, "Danh mục");
                    return $response;
                }
                $checkCategory->title = $formCategoryDTO->title;
            }

            $newImageName = null;
            if ($formCategoryDTO->avatar && $formCategoryDTO->avatar['error'] === UPLOAD_ERR_OK) {
                if (!empty($checkCategory->avatar)) {
                    HandleFileUpload::deleteFile($checkCategory->avatar, 'Category');
                }
                $newImageName = HandleFileUpload::handleImageUpload($formCategoryDTO->avatar, 'Category');
                $checkCategory->avatar = $newImageName;
            }
            if (empty($newImageName)) {
                $newImageName = $checkCategory->avatar;
            }

            $checkCategory->description = $formCategoryDTO->description;
            $checkCategory->avatar = $newImageName;
            $checkCategory->updated_at = date('Y-m-d H:i:s');

            $category = new Category();
            $mapper = $this->_mapper->map($checkCategory, $category);
            $this->_categoryRepo->updateCategory($id, $mapper);

            ServiceResponseExtensions::setSuccess($response, "Chỉnh sửa danh mục thành công!");
        } catch (Exception $ex) {
            ServiceResponseExtensions::setError($response, $ex->getMessage());
        }

        return $response;
    }


    public function deleteCategory($id)
    {
        $response = new ServiceResponse();
        try {
            $category = $this->_categoryRepo->getCategoryById($id);
            if ($category == null) {
                ServiceResponseExtensions::setNotFound($response, "Danh mục");
                return $response;
            }
            HandleFileUpload::deleteFile($category->avatar, 'Category');
            $this->_categoryRepo->deleteCategoryById($id);
            ServiceResponseExtensions::setSuccess($response, "Xóa danh mục thành công!");
        } catch (Exception $ex) {
            ServiceResponseExtensions::setError($response, $ex->getMessage());
        }
        return $response;
    }
}
