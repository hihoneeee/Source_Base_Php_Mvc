<?php

namespace App\Services;

use App\Core\Mapper;
use App\Helpers\ServiceResponse;
use App\Helpers\ServiceResponseExtensions;
use App\Data\Models\Comment;
use App\DTOs\Comment as CommentDTO;
use App\Repositories\CommentRepository;
use App\Repositories\PostDetailRepository;
use App\Repositories\PostRepository;
use Exception;

class CommentService
{
    private $_commentRepo;
    private $_mapper;
    private $_postDetailRepo;

    public function __construct(CommentRepository $commentRepo, Mapper $mapper, PostDetailRepository $postDetailRepo)
    {
        $this->_commentRepo = $commentRepo;
        $this->_mapper = $mapper;
        $this->_postDetailRepo = $postDetailRepo;
    }

    public function getListCommentsByPostId($postDetailId, $limit, $page)
    {
        $response = new ServiceResponse();
        try {
            $data = $this->_commentRepo->getListCommentsByPostId($postDetailId, $limit, $page);

            $response->data = $data['comments'];
            $response->total = $data['total'];
            $response->limit = $limit;
            $response->page = $page;
            ServiceResponseExtensions::setSuccess($response, "Lấy bình luận thành công!");
        } catch (Exception $ex) {
            ServiceResponseExtensions::setError($response, $ex->getMessage());
        }
        return $response;
    }
    public function getCommentById($id)
    {
        $response = new ServiceResponse();
        try {
            $comment = $this->_commentRepo->getCommentById($id);
            if ($comment == null) {
                ServiceResponseExtensions::setNotFound($response, "Bình luận");
                return $response;
            }
            $response->data = $comment;
            ServiceResponseExtensions::setSuccess($response, "Lấy bình luận thành công!");
        } catch (Exception $ex) {
            ServiceResponseExtensions::setError($response, $ex->getMessage());
        }
        return $response;
    }
    public function createcomment(CommentDTO\FormCommentDTO $formCommentDTO)
    {
        $response = new ServiceResponse();
        try {
            $comment = new comment();
            $newcomment = $this->_mapper->map($formCommentDTO, $comment);
            $postDetail = $this->_postDetailRepo->getPostDetailById($newcomment->postDetail_id);
            $this->_commentRepo->createcomment($newcomment);
            $response->data = $postDetail;
            ServiceResponseExtensions::setSuccess($response, "Bình luận thành công!");
        } catch (Exception $ex) {
            ServiceResponseExtensions::setError($response, $ex->getMessage());
        }
        return $response;
    }
    public function updatecomment($id, commentDTO\FormCommentDTO $formCommentDTO)
    {
        $response = new ServiceResponse();

        try {
            $checkComment = $this->_commentRepo->getCommentById($id);
            if ($checkComment == null) {
                ServiceResponseExtensions::setNotFound($response, "Bình luận");
                return $response;
            }
            if ($checkComment->user_id != $_SESSION['user_info']->id) {
                ServiceResponseExtensions::setUnauthorized($response, "Người sửa không hợp lệ!");
                return $response;
            }
            $checkComment->content = $formCommentDTO->content;
            $checkComment->updated_at = date('Y-m-d H:i:s');
            $comment = new comment();
            $mapper = $this->_mapper->map($checkComment, $comment);
            $this->_commentRepo->updatecomment($id, $mapper);
            ServiceResponseExtensions::setSuccess($response, "Sửa bình luận thành công!");
        } catch (Exception $ex) {
            ServiceResponseExtensions::setError($response, $ex->getMessage());
        }
        return $response;
    }
    public function deletecomment($id)
    {
        $response = new ServiceResponse();
        try {
            $checkComment = $this->_commentRepo->getCommentById($id);

            if ($checkComment == null) {
                ServiceResponseExtensions::setNotFound($response, "Bình luận");
                return $response;
            }

            if ($checkComment->user_id != $_SESSION['user_info']->id) {
                ServiceResponseExtensions::setUnauthorized($response, "Người sửa không hợp lệ!");
                return $response;
            }

            $postDetail = $this->_postDetailRepo->getPostDetailById($checkComment->postDetail_id);

            $this->_commentRepo->deleteCommentById($id);
            $response->data = $postDetail;
            ServiceResponseExtensions::setSuccess($response, "Xóa bình luận thành công!");
        } catch (Exception $ex) {
            ServiceResponseExtensions::setError($response, $ex->getMessage());
        }
        return $response;
    }
}