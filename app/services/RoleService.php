<?php
require_once './app/Helpers/ServiceResponse.php';
require_once './app/Helpers/ServiceResponseExtensions.php';

class RoleService
{
    private $_roleRepo;

    public function __construct(RoleRepository $roleRepo)
    {
        $this->_roleRepo = $roleRepo;
    }

    public function getAllRoles()
    {
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

    public function getRoleById($id)
    {
        $response = new ServiceResponse();
        try {
            $role = $this->_roleRepo->getRoleById($id);
            if ($role == null) {
                ServiceResponseExtensions::setNotFound($response, "Role");
                return $response;
            }
            $response->data = $role;
            ServiceResponseExtensions::setSuccess($response, "Role retrieved successfully");
        } catch (Exception $ex) {
            ServiceResponseExtensions::setError($response, $ex->getMessage());
        }
        return $response;
    }

    public function createRole(CreateRoleDTO $createRoleDTO)
    {
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
            $this->_roleRepo->createRole($newRole);
            ServiceResponseExtensions::setSuccess($response, "Role created successfully");
        } catch (Exception $ex) {
            ServiceResponseExtensions::setError($response, $ex->getMessage());
        }
        return $response;
    }

    public function updateRole($id, CreateRoleDTO $createRoleDTO)
    {
        $response = new ServiceResponse();

        try {
            $role = $this->_roleRepo->getRoleById($id);
            if ($role === null) {
                ServiceResponseExtensions::setNotFound($response, "Role");
                return $response;
            }
            if ($role->value === $createRoleDTO->value) {
                $role->value === $role->value;
            } else {
                $existingRole = $this->_roleRepo->getRoleByValue($createRoleDTO->value);
                if ($existingRole) {
                    ServiceResponseExtensions::setExisting($response, "Role");
                    return $response;
                }
                $role->value = $createRoleDTO->value;
            }
            $role->updated_at = date('Y-m-d H:i:s');
            $updateRole = new Role($role->id, $role->value, $role->created_at, $role->updated_at);
            $this->_roleRepo->updateRole($id, $updateRole);
            ServiceResponseExtensions::setSuccess($response, "Role updated successfully!");
        } catch (Exception $ex) {
            ServiceResponseExtensions::setError($response, $ex->getMessage());
        }
        return $response;
    }

    public function deleteRole($id)
    {
        $response = new ServiceResponse();
        try {
            $role = $this->_roleRepo->getRoleById($id);
            if ($role == null) {
                ServiceResponseExtensions::setNotFound($response, "Role");
                return $response;
            }
            $this->_roleRepo->deleteRoleById($id);
            ServiceResponseExtensions::setSuccess($response, "Role deleted successfully!");
        } catch (Exception $ex) {
            ServiceResponseExtensions::setError($response, $ex->getMessage());
        }
        return $response;
    }
}
