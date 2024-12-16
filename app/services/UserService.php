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
use App\Repositories\RoleRepository;
use Exception;

class UserService
{
    private $_userRepo;
    private $_mapper;
    private $_roleRepo;

    public function __construct(UserRepository $userRepo, RoleRepository $roleRepo, Mapper $mapper)
    {
        $this->_userRepo = $userRepo;
        $this->_mapper = $mapper;
        $this->_roleRepo = $roleRepo;
    }

    public function getAllUsers($limit, $page, $name)
    {
        $response = new ServiceResponse();
        try {
            $role = $this->_roleRepo->getRoleByValue('Admin');
            $data = $this->_userRepo->getAllUsers($limit, $page, $name, $role->id);
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
    public function getAll()
    {
        $role = $this->_roleRepo->getRoleByValue('User');
        return $this->_userRepo->getAll($role->id);
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

    public function getProfileById($id)
    {
        $response = new ServiceResponse();
        try {
            $data = $this->_userRepo->getProfileById($id);
            if ($data['user'] == null) {
                ServiceResponseExtensions::setNotFound($response, "Người viết không tồn tại!");
                return $response;
            }
            $userDTO = new UserDTO\ProfileUserDTO();
            $profileDTO = $this->_mapper->map($data['user'], $userDTO);
            $profileDTO->dataPosts = array_map(function ($post) {
                return (object) [
                    'id' => $post->id,
                    'user_id' => $post->user_id,
                    'category_id' => $post->category_id,
                    'created_at' => $post->created_at,
                    'status' => $post->status,
                    'title' => $post->title,
                    'content' => $post->content,
                    'meta' => $post->meta,
                    'avatar' => $post->avatar,
                    'categoryId' => $post->categoryId,
                    'categoryTitle' => $post->categoryTitle,
                ];
            }, $data['posts']);

            $response->data = $profileDTO;
            $response->total = $data['total'];
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
            $role = $this->_roleRepo->getRoleByValue('Admin');
            if ($checkUser->role_id == $role->id) {
                ServiceResponseExtensions::setUnauthorized($response, "Không thể chỉnh sửa người này!");
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
