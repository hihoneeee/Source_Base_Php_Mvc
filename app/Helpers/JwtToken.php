<?php

namespace App\Helpers;

use App\Repositories\RoleRepository;
use App\Repositories\UserRepository;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JwtToken
{
    private $_secret;
    private $_roleRepo;

    public function __construct(string $secret, RoleRepository $roleRepo)
    {
        $this->_secret = $secret;
        $this->_roleRepo = $roleRepo;
    }

    public function generateJWTToken(
        string $id,
        string $firstName,
        string $lastName,
        string $email,
        string $roleId,
        ?string $avatar,  // Cho phép avatar là null
        int $expire
    ): string {
        $role = $this->_roleRepo->getRoleById($roleId);
        if (!$role) {
            throw new \Exception("Role not found for ID: $roleId");
        }

        // Xây dựng payload
        $payload = [
            'sub' => $id,
            'role' => $role->value,
            'firstName' => $firstName,
            'lastName' => $lastName,
            'email' => $email,
            'avatar' => $avatar,  // Avatar có thể là null
            'iat' => time(),
            'exp' => $expire
        ];

        return JWT::encode($payload, $this->_secret, 'HS256');
    }


    public static function decodeJWTToken(string $token)
    {
        try {
            // Giải mã token bằng secret key
            $decoded = JWT::decode($token, new Key(JWT_SECRET, 'HS256'));

            // Trả về payload dưới dạng object
            return $decoded;
        } catch (\Exception $e) {
            // Xử lý lỗi khi giải mã token (hết hạn, không hợp lệ, v.v.)
            throw new \Exception("Invalid or expired token: " . $e->getMessage());
        }
    }

    public static function getUserInfoFromToken(string $token): ?object
    {
        try {
            $decoded = JWT::decode($token, new Key(JWT_SECRET, 'HS256'));
            return (object) [
                'id' => $decoded->sub,
                'role' => $decoded->role,
                'first_name' => $decoded->firstName,
                'last_name' => $decoded->lastName,
                'email' => $decoded->email,
                'avatar' => $decoded->avatar,
            ];
        } catch (\Exception $e) {
            return null;
        }
    }

    public static function updateJWTToken(string $token, array $updatedData): string
    {
        // Giải mã token để lấy payload
        try {
            $decoded = JWT::decode($token, new Key(JWT_SECRET, 'HS256'));
            $payload = (array) $decoded; // Chuyển đổi sang mảng để dễ dàng chỉnh sửa
        } catch (\Exception $e) {
            throw new \Exception("Invalid token: " . $e->getMessage());
        }

        // Cập nhật các trường cần thay đổi
        foreach ($updatedData as $key => $value) {
            $payload[$key] = $value;
        }

        // Không thay đổi giá trị 'exp', giữ nguyên thời hạn cũ

        // Tạo lại token mới
        return JWT::encode($payload, JWT_SECRET, 'HS256');
    }
}
