<?php
namespace App\Helpers;

class EHttpType {
    const Success = 200;
    const BadRequest = 400;
    const Unauthorized = 401;
    const NotFound = 404;
    const Conflict = 409;
    const InternalError = 500;
}