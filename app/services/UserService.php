<?php

namespace App\Services;

use App\Repositories\UserRepository;
use App\Core\Mapper;
use App\Helpers\ServiceResponse;
use App\Helpers\ServiceResponseExtensions;
use App\Data\Models\User;
use App\DTOs\User as UserDTO;


use Exception;

class UserService
{
    private $_userRepo;
    private $_mapper;

    public function __construct(UserRepository $userRepo,  Mapper $mapper)
    {
        $this->_userRepo = $userRepo;
        $this->_mapper = $mapper;
    }

    public function getAllUsers($limit, $page, $name)
    {
        $response = new ServiceResponse();
        try {
            $data = $this->_userRepo->getAllUsers($limit, $page, $name);
            $response->data = $data['users'];
            $response->total = $data['total'];
            $response->limit = $limit;
            $response->page = $page;
            ServiceResponseExtensions::setSuccess($response, "Lấy danh sách người dùng thành công!");
        } catch (Exception $ex) {
            ServiceResponseExtensions::setError($response, $ex->getMessage());
        }
        return $response;
    }

    public function deleteUser($id)
    {
        $response = new ServiceResponse();
        try {
            $checkUser = $this->_userRepo->getUserById($id);
            if ($checkUser == null) {
                ServiceResponseExtensions::setNotFound($response, "người dùng");
                return $response;
            }
            $this->_userRepo->deleteUserById($id);
            ServiceResponseExtensions::setSuccess($response, "Xóa người dùng thành công!");
        } catch (Exception $ex) {
            ServiceResponseExtensions::setError($response, $ex->getMessage());
        }
        return $response;
    }

    public function getUserById($id)
    {
        $response = new ServiceResponse();
        try {
            $user = $this->_userRepo->getUserById($id);
            if ($user == null) {
                ServiceResponseExtensions::setNotFound($response, "Người dùng");
                return $response;
            }
            $response->data = $user;
            ServiceResponseExtensions::setSuccess($response, "Lấy thông tin thành công!");
        } catch (Exception $ex) {
            ServiceResponseExtensions::setError($response, $ex->getMessage());
        }
        return $response;
    }

    public function createUser(UserDTO\CreateUserDTO $createUserDTO)
    {
        $response = new ServiceResponse();

        try {
            $checkEmail = $this->_userRepo->getUserByEmail($createUserDTO->email);
            if ($checkEmail) {
                ServiceResponseExtensions::setExisting($response, "Người dùng");
                return $response;
            }
            $user = new User();
            $newUser = $this->_mapper->map($createUserDTO, $user);
            $this->_userRepo->createUser($newUser);
            ServiceResponseExtensions::setSuccess($response, "Thêm mới người dùng thành công!");
        } catch (Exception $ex) {
            ServiceResponseExtensions::setError($response, $ex->getMessage());
        }
        return $response;
    }
    public function updateUser($id, UserDTO\CreateUserDTO $createUserDTO)
    {
        $response = new ServiceResponse();

        try {
            $checkUser = $this->_userRepo->getUserById($id);
            if ($checkUser === null) {
                ServiceResponseExtensions::setNotFound($response, "Người dùng");
                return $response;
            }
            if ($checkUser->email === $createUserDTO->email) {
                $checkUser->email === $checkUser->email;
            } else {
                $existingEmail = $this->_userRepo->getUserByEmail($createUserDTO->email);
                if ($existingEmail) {
                    ServiceResponseExtensions::setExisting($response, "Người dùng");
                    return $response;
                }
                $checkUser->email = $createUserDTO->email;
            }
            $checkUser->first_name = $createUserDTO->first_name;
            $checkUser->last_name = $createUserDTO->last_name;
            $checkUser->role_id = $createUserDTO->role_id;
            $checkUser->updated_at = date('Y-m-d H:i:s');
            $user = new User();
            $mapper = $this->_mapper->map($checkUser, $user);
            $this->_userRepo->updateUser($id, $mapper);
            ServiceResponseExtensions::setSuccess($response, "Chỉnh sửa người dùng thành công!");
        } catch (Exception $ex) {
            ServiceResponseExtensions::setError($response, $ex->getMessage());
        }
        return $response;
    }
}
