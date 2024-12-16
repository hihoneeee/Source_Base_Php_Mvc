<?php

namespace App\Services;

use App\Repositories\RoleRepository;
use App\Core\Mapper;
use App\Helpers\ServiceResponse;
use App\Helpers\ServiceResponseExtensions;
use App\Data\Models\Role;
use App\DTOs\Role as RoleDTO;


use Exception;

class RoleService
{
    private $_roleRepo;
    private $_mapper;

    public function __construct(RoleRepository $roleRepo, Mapper $mapper)
    {
        $this->_roleRepo = $roleRepo;
        $this->_mapper = $mapper;
    }

    public function getAllRoles($limit, $page, $name)
    {
        $response = new ServiceResponse();
        try {
            $data = $this->_roleRepo->getAllRoles($limit, $page, $name);
            $response->data = $data['roles'];
            $response->total = $data['total'];
            $response->limit = $limit;
            $response->page = $page;
            ServiceResponseExtensions::setSuccess($response, "Lấy danh sách vai trò thành công!");
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
                ServiceResponseExtensions::setNotFound($response, "Vai trò");
                return $response;
            }
            $response->data = $role;
            ServiceResponseExtensions::setSuccess($response, "Lấy vai trò thành công!");
        } catch (Exception $ex) {
            ServiceResponseExtensions::setError($response, $ex->getMessage());
        }
        return $response;
    }
    public function getRoleByValue($value)
    {
        $response = new ServiceResponse();
        try {
            $role = $this->_roleRepo->getRoleByValue($value);
            if ($role == null) {
                ServiceResponseExtensions::setNotFound($response, "Vai trò");
                return $response;
            }
            $response->data = $role;
            ServiceResponseExtensions::setSuccess($response, "Lấy vai trò thành công!");
        } catch (Exception $ex) {
            ServiceResponseExtensions::setError($response, $ex->getMessage());
        }
        return $response;
    }
    public function getRoleDetail($id, RoleDTO\GetRoleDTO $getRoleDto)
    {
        $response = new ServiceResponse();
        try {
            $data = $this->_roleRepo->getRoleDetail($id);
            if ($data == null) {
                ServiceResponseExtensions::setNotFound($response, "Vai trò");
                return $response;
            }
            $roleDTO = $this->_mapper->map($data['role'], $getRoleDto);
            $roleDTO->dataUser = $data['users'];
            $response->data = $roleDTO;
            ServiceResponseExtensions::setSuccess($response, "Lấy chi tiết thành công!");
        } catch (Exception $ex) {
            ServiceResponseExtensions::setError($response, $ex->getMessage());
        }
        return $response;
    }
    public function createRole(RoleDTO\CreateRoleDTO $createRoleDTO)
    {
        $response = new ServiceResponse();

        try {
            $existingRole = $this->_roleRepo->getRoleByValue($createRoleDTO->value);
            if ($existingRole) {
                ServiceResponseExtensions::setExisting($response, "Vai trò");
                return $response;
            }
            $role = new Role();
            $newRole = $this->_mapper->map($createRoleDTO, $role);
            $this->_roleRepo->createRole($newRole);
            ServiceResponseExtensions::setSuccess($response, "Tạo mới vai trò thành công!");
        } catch (Exception $ex) {
            ServiceResponseExtensions::setError($response, $ex->getMessage());
        }
        return $response;
    }
    public function updateRole($id, RoleDTO\CreateRoleDTO $createRoleDTO)
    {
        $response = new ServiceResponse();

        try {
            $checkRole = $this->_roleRepo->getRoleById($id);
            if ($checkRole === null) {
                ServiceResponseExtensions::setNotFound($response, "Vai trò");
                return $response;
            }
            if ($checkRole->value === $createRoleDTO->value) {
                $checkRole->value === $checkRole->value;
            } else {
                $existingRole = $this->_roleRepo->getRoleByValue($createRoleDTO->value);
                if ($existingRole) {
                    ServiceResponseExtensions::setExisting($response, "Vai trò");
                    return $response;
                }
                $checkRole->value = $createRoleDTO->value;
            }
            $checkRole->updated_at = date('Y-m-d H:i:s');
            $role = new Role();
            $mapper = $this->_mapper->map($checkRole, $role);
            $this->_roleRepo->updateRole($id, $mapper);
            ServiceResponseExtensions::setSuccess($response, "Chỉnh sửa vai trò thành công!");
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
                ServiceResponseExtensions::setNotFound($response, "Vai trò");
                return $response;
            }
            $this->_roleRepo->deleteRoleById($id);
            ServiceResponseExtensions::setSuccess($response, "Xóa vai trò thành công!");
        } catch (Exception $ex) {
            ServiceResponseExtensions::setError($response, $ex->getMessage());
        }
        return $response;
    }
}
