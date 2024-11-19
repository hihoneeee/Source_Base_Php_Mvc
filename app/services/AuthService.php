<?php

namespace App\Services;

use App\Repositories\UserRepository;
use App\Core\Mapper;
use App\Helpers\ServiceResponse;
use App\Helpers\ServiceResponseExtensions;
use App\DTOs\Auth\AuthLoginDTO;
use App\Helpers\HashPassword;
use App\Helpers\JwtToken;
use App\Repositories\RoleRepository;
use Exception;

class AuthService
{
    private $_userRepo;
    private $_jwtToken;
    private $_roleRepo;

    public function __construct(UserRepository $userRepo, JwtToken $jwtToken, RoleRepository $roleRepo)
    {
        $this->_userRepo = $userRepo;
        $this->_jwtToken = $jwtToken;
        $this->_roleRepo = $roleRepo;
    }

    public function login(AuthLoginDTO $loginDTO)
    {
        $response = new ServiceResponse();
        try {
            $existingEmail = $this->_userRepo->getUserByEmail($loginDTO->email);
            if ($existingEmail == null) {
                ServiceResponseExtensions::setNotFound($response, "Nguời dùng");
                return $response;
            }

            if (!HashPassword::VerifyPassword($loginDTO->password, $existingEmail->password)) {
                ServiceResponseExtensions::setUnauthorized($response, "Mật khẩu không đúng!");
                return $response;
            }
            $checkRole = $this->_roleRepo->getRoleById($existingEmail->role_id);
            if ($checkRole->value === 'User') {
                ServiceResponseExtensions::setUnauthorized($response, "Bạn không có quyền hạn này!");
                return $response;
            }

            $expireTime = time() + (30 * 24 * 60 * 60);

            $accessToken = $this->_jwtToken->generateJWTToken(
                $existingEmail->id,
                $existingEmail->first_name,
                $existingEmail->last_name,
                $existingEmail->email,
                $existingEmail->role_id,
                $expireTime
            );

            setcookie('TestToken', $accessToken, [
                'expires' => $expireTime,
                'path' => '/',
                'httponly' => true,
                'secure' => true,
            ]);

            ServiceResponseExtensions::setSuccess($response, "Login successfully!");
        } catch (Exception $ex) {
            ServiceResponseExtensions::setError($response, $ex->getMessage());
        }
        return $response;
    }

    public function Logout()
    {
        $response = new ServiceResponse();
        try {
            setcookie('TestToken', '', time() - 3600, '/', '', true, true);
            session_destroy();

            ServiceResponseExtensions::setSuccess($response, "Đăng xuất thành công");
        } catch (Exception $ex) {
            ServiceResponseExtensions::setError($response, $ex->getMessage());
        }
        return $response;
    }
}
