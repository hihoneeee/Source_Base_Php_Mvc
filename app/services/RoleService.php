<?php
require_once './app/Helpers/ServiceResponse.php';
require_once './app/Helpers/ServiceResponseExtensions.php';

class RoleService  {
    private $_roleRepo;

    public function __construct(RoleRepository $roleRepo) {
        $this->_roleRepo = $roleRepo;
    }
    
    public function getAllRoles() {
        $response = new ServiceResponse();
        try {
            $roles = $this->_roleRepo->getAllRoles();
            $response->data = $roles;
            ServiceResponseExtensions::setSuccess($response, "Role retrieved successfully");
        } catch (Exception $ex) {
            ServiceResponseExtensions::setError($response, $ex->getMessage());
        }
        return $response;
    }

    public function createRole(CreateRoleDTO $createRoleDTO) {
        $response = new ServiceResponse();
    
        try {
            // Check if the role already exists
            $existingRole = $this->_roleRepo->getRoleByValue($createRoleDTO->value);
            if ($existingRole) {
                ServiceResponseExtensions::setExisting($response, "Role");
                return $response;
            }
    
            // Convert CreateRoleDTO to Role
            $newRole = new Role(null, $createRoleDTO->value, date('Y-m-d H:i:s'), date('Y-m-d H:i:s'));
    
            // Create the role
            $savedRole = $this->_roleRepo->createRole($newRole);
            ServiceResponseExtensions::setSuccess($response, "Role created successfully", $savedRole);
        } catch (Exception $ex) {
            ServiceResponseExtensions::setError($response, $ex->getMessage());
        }
        return $response;
    }
}