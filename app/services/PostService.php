<?php

namespace App\Services;

use App\Repositories\PostRepository;
use App\Core\Mapper;
use App\Helpers\ServiceResponse;
use App\Helpers\ServiceResponseExtensions;
use App\Data\Models\Post;
use App\DTOs\Post as PostDTO;
use App\Repositories\CategoryRepository;
use Exception;

class PostService
{
    private $_postRepo;
    private $_mapper;
    private $_categoryRepo;
    private $_postDetailService;
    public function __construct(PostRepository $postRepo, Mapper $mapper, CategoryRepository $categoryRepo, PostDetailService $postDetailService)
    {
        $this->_postRepo = $postRepo;
        $this->_mapper = $mapper;
        $this->_categoryRepo = $categoryRepo;
        $this->_postDetailService = $postDetailService;
    }

    public function getAllPostsByAdmin($limit, $page, $name)
    {
        $response = new ServiceResponse();
        try {

            $data = $this->_postRepo->getAllPostsByAdmin($limit, $page, $name);
            $response->data = $data['posts'];
            $response->total = $data['total'];
            $response->limit = $limit;
            $response->page = $page;
            ServiceResponseExtensions::setSuccess($response, "Lấy danh sách bài viết thành công!");
        } catch (Exception $ex) {
            ServiceResponseExtensions::setError($response, $ex->getMessage());
        }
        return $response;
    }

    public function getPostsByUser($id, $limit, $page, $name)
    {
        $response = new ServiceResponse();
        try {
            $data = $this->_postRepo->getPostsByUser($id, $limit, $page, $name);
            $response->data = $data['posts'];
            $response->total = $data['total'];
            $response->limit = $limit;
            $response->page = $page;
            ServiceResponseExtensions::setSuccess($response, "Lấy danh sách bài viết thành công!");
        } catch (Exception $ex) {
            ServiceResponseExtensions::setError($response, $ex->getMessage());
        }
        return $response;
    }

    public function getPostById($id)
    {
        $response = new ServiceResponse();
        try {
            $post = $this->_postRepo->getPostById($id);
            if ($post == null) {
                ServiceResponseExtensions::setNotFound($response, "Bài viết");
                return $response;
            }
            if ($_SESSION['user_info']->role != 'Admin' && $post->user_id != $_SESSION['user_info']->id) {
                ServiceResponseExtensions::setUnauthorized($response, "Người viết không hợp lệ!");
                return $response;
            }

            if ($_SESSION['user_info']->role != 'Admin' && $post->status != 'pending') {
                ServiceResponseExtensions::setUnauthorized($response, "Bài viết đã hoàn thành rồi!");
                return $response;
            }
            $response->data = $post;
            ServiceResponseExtensions::setSuccess($response, "Lấy bài viết thành công!");
        } catch (Exception $ex) {
            ServiceResponseExtensions::setError($response, $ex->getMessage());
        }
        return $response;
    }

    public function getPostDetail($id)
    {
        $response = new ServiceResponse();
        try {
            $data = $this->_postRepo->getPostDetail($id);
            if ($data['post'] == false) {
                ServiceResponseExtensions::setNotFound($response, "Bài viết");
                return $response;
            }

            // Map Post
            $postDTO = $this->_mapper->map($data['post'], new PostDTO\GetPostDTO());
            $postDTO->dataCategory = ['id' => $data['post']->categoryId, 'title' => $data['post']->categoryTitle];
            $postDTO->dataDetail = [
                'id' => $data['post']->postDetailId,
                'title' => $data['post']->title,
                'meta' => $data['post']->meta,
                'content' => $data['post']->content,
                'avatar' => $data['post']->avatar
            ];
            // Map User
            $postDTO->dataUser = [
                'userId' => $data['user']->userId,
                'fullName' => $data['user']->fullName,
                'email' => $data['user']->email,
                'phone' => $data['user']->phone,
                'avatar' => $data['user']->avatar,
            ];

            $response->data = $postDTO;
            ServiceResponseExtensions::setSuccess($response, "Lấy bài viết thành công!");
        } catch (Exception $ex) {
            ServiceResponseExtensions::setError($response, $ex->getMessage());
        }
        return $response;
    }


    public function createPost(PostDTO\FormPostDTO $formPostDTO, PostDTO\FormPostDetailDTO $formPostDetailDTO)
    {
        $response = new ServiceResponse();

        try {
            if ($formPostDTO->user_id != $_SESSION['user_info']->id) {
                ServiceResponseExtensions::setUnauthorized($response, "Người viết không hợp lệ");
                return $response;
            }
            if ($formPostDTO->status != 'pending') {
                ServiceResponseExtensions::setUnauthorized($response, "Không phải nháp!");
                return $response;
            }
            $checkCategory = $this->_categoryRepo->getCategoryById($formPostDTO->category_id);
            if ($checkCategory == null) {
                ServiceResponseExtensions::setNotFound($response, "Danh mục");
                return $response;
            }
            $post = new Post();
            $map = $this->_mapper->map($formPostDTO, $post);
            $newPost = $this->_postRepo->createPost($map);
            $this->_postDetailService->createPostDetail($newPost->id, $formPostDetailDTO);
            ServiceResponseExtensions::setSuccess($response, "Tạo mới bài viết thành công!");
        } catch (Exception $ex) {
            ServiceResponseExtensions::setError($response, $ex->getMessage());
        }

        return $response;
    }

    public function updatePost($id, PostDTO\FormPostDTO $formPostDTO, PostDTO\FormPostDetailDTO $formPostDetailDTO)
    {
        $response = new ServiceResponse();
        try {
            $checkPost = $this->_postRepo->getPostById($id);
            if ($checkPost == null) {
                ServiceResponseExtensions::setNotFound($response, "Bài viết");
                return $response;
            }

            if ($_SESSION['user_info']->role != 'Admin' && $checkPost->user_id != $_SESSION['user_info']->id) {
                ServiceResponseExtensions::setUnauthorized($response, "Người viết không hợp lệ!");
                return $response;
            }

            if ($_SESSION['user_info']->role != 'Admin' && $checkPost->status != 'pending') {
                ServiceResponseExtensions::setUnauthorized($response, "Bài viết đã được duyệt hoặc ẩn đi");
                return $response;
            }

            $checkCategory = $this->_categoryRepo->getCategoryById($formPostDTO->category_id);
            if ($checkCategory == null) {
                ServiceResponseExtensions::setNotFound($response, "Danh mục");
                return $response;
            }
            $checkPost->category_id = $formPostDTO->category_id;
            $checkPost->status = $formPostDTO->status;
            $checkPost->updated_at = date('Y-m-d H:i:s');
            $post = new Post();
            $mapper = $this->_mapper->map($checkPost, $post);
            $this->_postRepo->updatePost($id, $mapper);
            $this->_postDetailService->updatepostDetail($checkPost->postDetailId, $formPostDetailDTO);
            ServiceResponseExtensions::setSuccess($response, "Chỉnh sửa bài viết thành công!");
        } catch (Exception $ex) {
            ServiceResponseExtensions::setError($response, $ex->getMessage());
        }
        return $response;
    }

    public function deletePost($id)
    {
        $response = new ServiceResponse();
        try {
            $checkPost = $this->_postRepo->getPostById($id);
            if ($checkPost == null) {
                ServiceResponseExtensions::setNotFound($response, "Bài viết");
                return $response;
            }
            if (trim($_SESSION['user_info']->role) != 'Admin' && $_SESSION['user_info']->id != $checkPost->user_id) {
                ServiceResponseExtensions::setUnauthorized($response, "Người viết không hợp lệ!");
                return $response;
            }

            if (trim($_SESSION['user_info']->role) != 'Admin' && $checkPost->status != 'pending') {
                ServiceResponseExtensions::setUnauthorized($response, "Bài viết đã được duyệt hoặc ẩn đi");
                return $response;
            }
            $this->_postRepo->deletePostById($id);
            $this->_postDetailService->deletepostDetail($checkPost->postDetailId);
            ServiceResponseExtensions::setSuccess($response, "Xóa bài viết thành công!");
        } catch (Exception $ex) {
            ServiceResponseExtensions::setError($response, $ex->getMessage());
        }
        return $response;
    }
}
