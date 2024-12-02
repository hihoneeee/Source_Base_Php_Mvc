<?php

use App\Helpers\UrlAction;
?>
<nav class="flex mb-4" aria-label="Breadcrumb">
    <ol class="inline-flex items-center space-x-1 md:space-x-3 rtl:space-x-reverse">
        <li class="inline-flex items-center">
            <a href="/admin" class=" flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 gap-2">
                <i class="ri-home-4-fill"></i>
                <span>Trang chủ</span>
            </a>
        </li>
        <li>
            <div class="flex items-center">
                <i class="ri-arrow-right-s-line"></i>
                <a href="<?php echo UrlAction::action('admin', 'role', 'index'); ?>"
                    class="flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 gap-2">
                    <span>Quản lý vai trò</span>
                </a>
            </div>
        </li>
        <li>
            <div class="flex items-center">
                <i class="ri-arrow-right-s-line"></i>
                <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2 dark:text-gray-400">
                    Chi tiết vai trò
                </span>
            </div>
        </li>
    </ol>
</nav>
<h2 class="mb-4 text-3xl font-extrabold leading-none tracking-tight text-gray-900 md:text-4xl text-black">Quản lý vai
    trò</h2>
<div class="container mx-auto p-4">
    <!-- Role Information -->
    <div class="bg-gray-100 p-6 rounded-lg shadow-md mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Chi tiết vai trò</h1>
        <p class="text-lg mt-2"><span class="font-semibold">Tên vai trò:</span> <?= htmlspecialchars($role->value) ?>
        </p>
        <p class="text-lg"><span class="font-semibold">Tạo ngày:</span> <?= htmlspecialchars($role->created_at) ?></p>
        <p class="text-lg"><span class="font-semibold">Sửa ngày:</span> <?= htmlspecialchars($role->updated_at) ?></p>
    </div>

    <!-- Users List -->
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Danh sách người dùng sở hữu vai trò này</h2>
        <?php if (!empty($role->dataUser)) : ?>
            <table class="min-w-full border-collapse border border-gray-300">
                <thead>
                    <tr class="bg-gray-200 text-gray-700">
                        <th class="border border-gray-300 px-4 py-2">#</th>
                        <th class="border border-gray-300 px-4 py-2">Họ và tên</th>
                        <th class="border border-gray-300 px-4 py-2">Email</th>
                        <th class="border border-gray-300 px-4 py-2">Số điện thoại</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($role->dataUser as $index => $user) : ?>
                        <tr class="hover:bg-gray-100">
                            <td class="border border-gray-300 px-4 py-2"><?= $index + 1 ?></td>
                            <td class="border border-gray-300 px-4 py-2">
                                <?= htmlspecialchars($user->first_name . ' ' . $user->last_name) ?></td>
                            <td class="border border-gray-300 px-4 py-2"><?= htmlspecialchars($user->email) ?></td>
                            <td class="border border-gray-300 px-4 py-2"><?= htmlspecialchars($user->phone) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else : ?>
            <p class="text-gray-500">No users assigned to this role.</p>
        <?php endif; ?>
    </div>
</div>