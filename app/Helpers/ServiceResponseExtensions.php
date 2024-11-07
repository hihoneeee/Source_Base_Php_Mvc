<?php
require_once './app/Helpers/ServiceResponse.php';

class ServiceResponseExtensions {

    public static function setNotFound(ServiceResponse $response, $message) {
        $response->success = false;
        $response->message = "$message not found!";
        $response->statusCode = EHttpType::NotFound;
    }

    public static function setUnauthorized(ServiceResponse $response, $message) {
        $response->success = false;
        $response->message = $message;
        $response->statusCode = EHttpType::Unauthorized;
    }

    public static function setBadRequest(ServiceResponse $response, $message) {
        $response->success = false;
        $response->message = $message;
        $response->statusCode = EHttpType::BadRequest;
    }

    public static function setExisting(ServiceResponse $response, $message) {
        $response->success = false;
        $response->message = "$message already exists!";
        $response->statusCode = EHttpType::Conflict;
    }

    public static function setSuccess(ServiceResponse $response, $message) {
        $response->success = true;
        $response->message = $message;
        $response->statusCode = EHttpType::Success;
    }

    public static function setError(ServiceResponse $response, $message, $statusCode = EHttpType::InternalError) {
        $response->success = false;
        $response->message = "An unexpected error occurred: $message";
        $response->statusCode = $statusCode;
    }
}