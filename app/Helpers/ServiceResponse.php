<?php
require_once './app/Helpers/EHttpType.php';

class ServiceResponse {
    public $message;
    public $data;
    public $accessToken;
    public $refreshToken;
    public $statusCode;
    public $success;
    public $total;
    public $limit;
    public $page;

    public function __construct() {
        $this->success = false;
        $this->statusCode = EHttpType::InternalError;
    }

    public function getMessage() {
        return [
            'success' => $this->success,
            'message' => $this->message
        ];
    }

    public function getData() {
        return [
            'success' => $this->success,
            'message' => $this->message,
            'data' => $this->data
        ];
    }

    public function getDataTotal() {
        return [
            'success' => $this->success,
            'message' => $this->message,
            'total' => $this->total,
            'data' => $this->data
        ];
    }
}