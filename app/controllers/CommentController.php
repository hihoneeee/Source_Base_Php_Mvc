<?php

namespace App\controllers;

use App\core\Controller;
use App\DTOs\Comment;
use App\Services\CommentService;

class CommentController extends Controller
{
    private $_commentService;

    public function __construct(CommentService $commentService)
    {
        $this->_commentService = $commentService;
    }
    public function Create()
    {
        $formCommentDTO = new Comment\FormCommentDTO($_SESSION['user_info']->id, $_POST['postDetail_id'], $_POST['content']);
        if (!$formCommentDTO->isValid()) {
            $this->render('Public', 'Post/detail', ['errors' => $formCommentDTO->errors]);
            return;
        }
        $response = $this->_commentService->createComment($formCommentDTO);
        if ($response->success) {
            $this->redirectToAction('public', 'tin-tuc', $response->data->post_id);
        } else {
            $this->redirectToAction('public', 'tin-tuc', $response->data->post_id);
        }
    }

    public function Delete($id)
    {
        $response = $this->_commentService->deleteComment($id);
        if ($response->success) {
            $this->redirectToAction('public', 'tin-tuc', $response->data->post_id);
        } else {
            $this->redirectToAction('public', 'tin-tuc', $response->data->post_id);
        }
    }
}
