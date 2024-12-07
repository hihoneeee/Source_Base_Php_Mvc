<?php

namespace App\Repositories;

use App\Data\Models\Role;
use App\Data\Models\User;
use App\Data\Models\Category;
use Faker\Factory as Faker;

class FakeDataRepository
{
    private $_db;
    private $faker;

    public function __construct($db)
    {
        $this->_db = $db;
        $this->faker = Faker::create();
    }

    private function insert(string $table, array $data)
    {
        $columns = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_map(fn($key) => ":$key", array_keys($data)));
        $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";
        $stmt = $this->_db->prepare($sql);

        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }

        $stmt->execute();
    }

    public function generateAndInsertData()
    {
        // 1. Insert roles
        $roles = [
            new Role(['value' => 'Admin']),
            new Role(['value' => 'Writer']),
            new Role(['value' => 'User']),
        ];

        foreach ($roles as $role) {
            $this->insert('roles', [
                'value' => $role->value,
                'created_at' => $role->created_at,
                'updated_at' => $role->updated_at
            ]);
        }

        // Retrieve admin and writer role IDs
        $adminRoleId = $this->_db->query("SELECT id FROM roles WHERE value = 'Admin'")->fetchColumn();
        $writerRoleId = $this->_db->query("SELECT id FROM roles WHERE value = 'Writer'")->fetchColumn();

        // 2. Insert users
        $users = [];
        $users[] = new User([
            'first_name' => 'Hồ Anh',
            'last_name' => 'Huy',
            'email' => 'hohuy12344@gmail.com',
            'phone' => '0912345678',
            'password' => password_hash('12345678', PASSWORD_BCRYPT),
            'avatar' => 'default-user.png',
            'role_id' => $adminRoleId
        ]);

        for ($i = 0; $i < 10; $i++) {
            $users[] = new User([
                'first_name' => $this->faker->firstName(),
                'last_name' => $this->faker->lastName(),
                'email' => $this->faker->email(),
                'phone' => '09' . $this->faker->numberBetween(10000000, 99999999),
                'password' => password_hash('12345678', PASSWORD_BCRYPT),
                'avatar' => 'default-user.png',
                'role_id' => $writerRoleId
            ]);
        }

        foreach ($users as $user) {
            $this->insert('users', [
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'email' => $user->email,
                'phone' => $user->phone,
                'password' => $user->password,
                'avatar' => $user->avatar,
                'role_id' => $user->role_id,
                'created_at' => $user->created_at,
                'updated_at' => $user->updated_at
            ]);
        }

        // 3. Insert categories
        $categories = [
            new Category(['title' => 'Công Nghệ', 'avatar' => $this->faker->imageUrl(150, 150), 'description' => 'Bài viết công nghệ mới nhất 2024']),
            new Category(['title' => 'Đời Sống', 'avatar' => $this->faker->imageUrl(150, 150), 'description' => 'Các bài viết về đời sống hàng ngày.']),
            new Category([
                'title' => 'Sức Khỏe',
                'avatar' => $this->faker->imageUrl(150, 150, 'health', true, 'Health'),
                'description' => 'Thông tin về sức khỏe và chăm sóc cơ thể.',
            ]),
            new Category([
                'title' => 'Làm Đẹp',
                'avatar' => $this->faker->imageUrl(150, 150, 'beauty', true, 'Beauty'),
                'description' => 'Những xu hướng làm đẹp mới nhất.',
            ]),
        ];

        foreach ($categories as $category) {
            $this->insert('categories', [
                'title' => $category->title,
                'avatar' => $category->avatar,
                'description' => $category->description,
                'created_at' => $category->created_at,
                'updated_at' => $category->updated_at
            ]);
        }
    }
}
