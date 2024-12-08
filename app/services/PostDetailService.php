<?php

namespace App\Services;

use App\Repositories\PostDetailRepository;
use App\Core\Mapper;
use App\Helpers\ServiceResponse;
use App\Helpers\ServiceResponseExtensions;
use App\Data\Models\postDetail;
use App\DTOs\Post;
use App\Helpers\HandleFileUpload;
use Exception;

class PostDetailService
{
    private $_postDetailRepo;
    private $_mapper;

    public function __construct(PostDetailRepository $postDetailRepo, Mapper $mapper)
    {
        $this->_postDetailRepo = $postDetailRepo;
        $this->_mapper = $mapper;
    }

    public function createPostDetail($postId, Post\FormPostDetailDTO $formPostDetailDTO)
    {
        $response = new ServiceResponse();
        try {
            $imageName = null;
            if ($formPostDetailDTO->avatar && $formPostDetailDTO->avatar['error'] === UPLOAD_ERR_OK) {
                $imageName = HandleFileUpload::handleImageUpload($formPostDetailDTO->avatar, 'Post');
            }
            $formPostDetailDTO->avatar = $imageName;
            $postDetail = new postDetail();
            $postDetail->post_id = $postId;
            $newpostDetail = $this->_mapper->map($formPostDetailDTO, $postDetail);
            $this->_postDetailRepo->createpostDetail($newpostDetail);
        } catch (Exception $ex) {
            ServiceResponseExtensions::setError($response, $ex->getMessage());
        }
        return $response;
    }

    public function updatepostDetail($id, Post\FormPostDetailDTO $formPostDetailDTO)
    {
        $response = new ServiceResponse();
        try {
            $checkPostDetail = $this->_postDetailRepo->getPostDetailById($id);
            if ($checkPostDetail === null) {
                ServiceResponseExtensions::setNotFound($response, "Chi tiết bài viết");
                return $response;
            }
            $newImageName = null;
            if ($formPostDetailDTO->avatar && $formPostDetailDTO->avatar['error'] === UPLOAD_ERR_OK) {
                if (!empty($checkPostDetail->avatar)) {
                    HandleFileUpload::deleteFile($checkPostDetail->avatar, 'Post');
                }
                $newImageName = HandleFileUpload::handleImageUpload($formPostDetailDTO->avatar, 'Post');
                $checkPostDetail->avatar = $newImageName;
            }
            if (empty($newImageName)) {
                $newImageName = $checkPostDetail->avatar;
            }
            $checkPostDetail->title = $formPostDetailDTO->title;
            $checkPostDetail->meta = $formPostDetailDTO->meta;
            $checkPostDetail->meta = $formPostDetailDTO->content;
            $postDetail = new postDetail();
            $mapper = $this->_mapper->map($checkPostDetail, $postDetail);
            $this->_postDetailRepo->updatePostDetail($id, $mapper);
        } catch (Exception $ex) {
            ServiceResponseExtensions::setError($response, $ex->getMessage());
        }

        return $response;
    }


    public function deletepostDetail($id)
    {
        $response = new ServiceResponse();
        try {
            $postDetail = $this->_postDetailRepo->getpostDetailById($id);
            if ($postDetail == null) {
                ServiceResponseExtensions::setNotFound($response, "Bài viết");
                return $response;
            }
            HandleFileUpload::deleteFile($postDetail->avatar, 'Post');
            $this->_postDetailRepo->deletepostDetailById($id);
        } catch (Exception $ex) {
            ServiceResponseExtensions::setError($response, $ex->getMessage());
        }
        return $response;
    }
}
