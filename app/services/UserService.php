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
}