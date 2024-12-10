<?php

namespace App\Services;

use App\Repositories\UserRepository;
use App\Core\Mapper;
use App\Helpers\ServiceResponse;
use App\Helpers\ServiceResponseExtensions;
use App\Data\Models\User;
use App\DTOs\User as UserDTO;
use App\DTOs\User\UpdateProfileUserDTO;
use App\Helpers\HandleFileUpload;
use App\Helpers\HashPassword;
use App\Helpers\JwtToken;
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
                ServiceResponseExtensions::setExisting($response, "Email");
                return $response;
            }
            $createUserDTO->password = HashPassword::GenerateHash($createUserDTO->password);
            $user = new User();
            $newUser = $this->_mapper->map($createUserDTO, $user);
            $this->_userRepo->createUser($newUser);
            ServiceResponseExtensions::setSuccess($response, "Thêm mới người dùng thành công!");
        } catch (Exception $ex) {
            ServiceResponseExtensions::setError($response, $ex->getMessage());
        }
        return $response;
    }
    public function updateUser($id, UserDTO\UpdateUserDTO $updateUserDTO)
    {
        $response = new ServiceResponse();

        try {
            $checkUser = $this->_userRepo->getUserById($id);
            if ($checkUser === null) {
                ServiceResponseExtensions::setNotFound($response, "Người dùng");
                return $response;
            }
            if ($checkUser->email === $updateUserDTO->email) {
                $checkUser->email === $checkUser->email;
            } else {
                $existingEmail = $this->_userRepo->getUserByEmail($updateUserDTO->email);
                if ($existingEmail) {
                    ServiceResponseExtensions::setExisting($response, "Người dùng");
                    return $response;
                }
                $checkUser->email = $updateUserDTO->email;
            }
            $checkUser->first_name = $updateUserDTO->first_name;
            $checkUser->last_name = $updateUserDTO->last_name;
            $checkUser->role_id = $updateUserDTO->role_id;
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

    public function updateProfileUserSystem($id, UpdateProfileUserDTO $updateUserDTO)
    {
        $response = new ServiceResponse();
        try {
            $checkUser = $this->_userRepo->getUserById($id);
            if ($checkUser === null) {
                ServiceResponseExtensions::setNotFound($response, "Người dùng");
                return $response;
            }
            if ($checkUser->id != $_SESSION['user_info']->id) {
                ServiceResponseExtensions::setUnauthorized($response, "Người dùng không hợp lệ!");
                return $response;
            }
            if ($checkUser->email === $updateUserDTO->email) {
                $checkUser->email === $checkUser->email;
            } else {
                $existingEmail = $this->_userRepo->getUserByEmail($updateUserDTO->email);
                if ($existingEmail) {
                    ServiceResponseExtensions::setExisting($response, "Người dùng");
                    return $response;
                }
                $checkUser->email = $updateUserDTO->email;
            }
            $newImageName = null;
            if ($updateUserDTO->avatar && $updateUserDTO->avatar['error'] === UPLOAD_ERR_OK) {
                if (!empty($checkUser->avatar)) {
                    HandleFileUpload::deleteFile($checkUser->avatar, 'User');
                }
                $newImageName = HandleFileUpload::handleImageUpload($updateUserDTO->avatar, 'User');
                $checkUser->avatar = $newImageName;
            }
            if (empty($newImageName)) {
                $newImageName = $checkUser->avatar;
            }
            $checkUser->first_name = $updateUserDTO->first_name;
            $checkUser->last_name = $updateUserDTO->last_name;
            $checkUser->phone = $updateUserDTO->phone;
            $user = new User();
            $mapper = $this->_mapper->map($checkUser, $user);
            $this->_userRepo->updateUser($id, $mapper);
            $response->data = $mapper;
            ServiceResponseExtensions::setSuccess($response, "Chỉnh sửa thông tin thành công!");
        } catch (Exception $ex) {
            ServiceResponseExtensions::setError($response, $ex->getMessage());
        }
        return $response;
    }
}