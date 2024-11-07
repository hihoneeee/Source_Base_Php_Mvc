<?php
require_once './app/Helpers/ServiceResponse.php';
require_once './app/Helpers/ServiceResponseExtensions.php';
require_once './app/mappers/User.php';

class UserService  {
    protected $_userRepo;

    public function __construct(UserRepository $userRepo) {
        $this->_userRepo = $userRepo;
    }
    
    public function getAllUsers() {
        $response = new ServiceResponse();
        try {
            $users = $this->_userRepo->getAllUsers();
            $response->data = $users;
            ServiceResponseExtensions::setSuccess($response, "Users retrieved successfully");
        } catch (Exception $ex) {
            ServiceResponseExtensions::setError($response, $ex->getMessage());
        }
        return $response;
    }

    public function deleteUser($id) {
        $response = new ServiceResponse();
        try {
            $this->_userRepo->deleteUserById($id);
            ServiceResponseExtensions::setSuccess($response, "User deleted successfully!");
        } catch (Exception $ex) {
            ServiceResponseExtensions::setError($response, $ex->getMessage());
        }
        return $response;
    }

    public function getUserById($id) {
        return $this->_userRepo->getUserById($id);
    }

    public function createUser(UserDTO $userDTO) {
        $response = new ServiceResponse();

        try {
            // Kiểm tra nếu người dùng đã tồn tại
            $existingUser = $this->_userRepo->getUserByUsername($userDTO->username);
            if ($existingUser) {
                ServiceResponseExtensions::setExisting($response, "User");
                return $response;
            }

            // Tạo UserModel từ UserDTO
            $newUser = new User(
                $userDTO->username,
                '',  // Tên mặc định
                '',  // Họ mặc định
                $userDTO->email
            );

            // Thêm người dùng vào DB
            $addedUser = $this->_userRepo->addUser($newUser);
            $response->data = new UserDTO($addedUser->username, $addedUser->email);
            ServiceResponseExtensions::setSuccess($response, "User created successfully");
        } catch (Exception $ex) {
            ServiceResponseExtensions::setError($response, $ex->getMessage());
        }

        return $response;
    }
}