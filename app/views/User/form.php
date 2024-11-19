<?php

use App\Helpers\UrlAction;
?>

<nav class="flex mb-4" aria-label="Breadcrumb">
    <ol class="inline-flex items-center space-x-1 md:space-x-3 rtl:space-x-reverse">
        <li class="inline-flex items-center">
            <a href="<?php echo UrlAction::action('home', 'index'); ?>"
                class="flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 gap-2">
                <i class="ri-home-4-fill"></i>
                <span>Trang chủ</span>
            </a>
        </li>
        <li>
            <div class="flex items-center">
                <i class="ri-arrow-right-s-line"></i>
                <a href="<?php echo UrlAction::action('user', 'index'); ?>"
                    class="flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 gap-2">
                    <span>Quản lý người dùng</span>
                </a>
            </div>
        </li>
        <li>
            <div class="flex items-center">
                <i class="ri-arrow-right-s-line"></i>
                <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2 dark:text-gray-400">
                    <?php echo isset($user->id) ? 'Cập nhật người dùng' : 'Thêm mới người dùng'; ?>
                </span>
            </div>
        </li>
    </ol>
</nav>
<h2 class="mb-4 text-3xl font-extrabold leading-none tracking-tight text-gray-900 md:text-4xl text-black">Quản lý
    người
    dùng</h2>

<div class="bg-white shadow-md rounded-lg overflow-hidden mt-10">
    <div class="bg-gray-100 px-6 py-4 border-b">
        <h2 class="text-lg font-semibold text-gray-700">
            <?php echo isset($user) ? 'Cập nhật người dùng' : 'Thêm mới người dùng'; ?>
        </h2>
    </div>
    <form
        action="<?php echo isset($user) ? UrlAction::action('user', 'update', [$user->id]) : UrlAction::action('user', 'store'); ?>"
        method="post" class="p-4 space-y-4">
        <div class="flex gap-2 w-full">
            <div class="w-[50%]">
                <label class="block text-gray-700 font-semibold mb-2" for="first_name">Họ Đệm</label>

                <input type="text" name="first_name" id="first_name" placeholder="Nhập họ đệm..."
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    value="<?php echo htmlspecialchars($user->first_name ?? ''); ?>">

                <?php if (!empty($errors['first_name'])): ?>
                    <p class="text-red-500 text-sm"><?php echo htmlspecialchars($errors['first_name']); ?></p>
                <?php endif; ?>
            </div>
            <div class="w-[50%]">
                <label class="block text-gray-700 font-semibold mb-2" for="last_name">Tên</label>

                <input type="text" name="last_name" id="last_name" placeholder="Nhập tên..."
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    value="<?php echo htmlspecialchars($user->last_name ?? ''); ?>">

                <?php if (!empty($errors['last_name'])): ?>
                    <p class="text-red-500 text-sm"><?php echo htmlspecialchars($errors['last_name']); ?></p>
                <?php endif; ?>
            </div>
        </div>
        <div>
            <label class="block text-gray-700 font-semibold mb-2" for="email">Email</label>

            <input type="email" name="email" id="email" placeholder="Nhập email..."
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                value="<?php echo htmlspecialchars($user->email ?? ''); ?>">

            <?php if (!empty($errors['email'])): ?>
                <p class="text-red-500 text-sm"><?php echo htmlspecialchars($errors['email']); ?></p>
            <?php endif; ?>
        </div>
        <div>
            <label class="block text-gray-700 font-semibold mb-2" for="password">Mật khẩu</label>

            <input type="text" name="password" id="password" placeholder="••••••••"
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                value="<?php echo htmlspecialchars($user->password ?? ''); ?>">

            <?php if (!empty($errors['password'])): ?>
                <p class="text-red-500 text-sm"><?php echo htmlspecialchars($errors['password']); ?></p>
            <?php endif; ?>
        </div>
        <div>
            <label class="block text-gray-700 font-semibold mb-2" for="role">Vai trò</label>
            <select name="role_id" id="role"
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">Chọn vai trò</option>
                <?php foreach ($roles as $role): ?>
                    <option value="<?php echo htmlspecialchars($role->id); ?>"
                        <?php echo (isset($user) && $user->role_id == $role->id) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($role->value); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <?php if (!empty($errors['role_id'])): ?>
                <p class="text-red-500 text-sm"><?php echo htmlspecialchars($errors['role_id']); ?></p>
            <?php endif; ?>
        </div>

        <div class="flex justify-end space-x-2">
            <button type="submit"
                class="bg-<?php echo isset($user) ? 'green-600' : 'blue-500'; ?> text-white font-semibold px-4 py-2 rounded-lg hover:bg-<?php echo isset($user) ? 'green-700' : 'blue-600'; ?> focus:outline-none focus:ring-2 focus:ring-blue-500">
                <?php echo isset($user) ? 'Cập Nhật' : 'Thêm'; ?>
            </button>
            <a href="<?php echo UrlAction::action('user', 'index'); ?>"
                class="bg-gray-400 text-white font-semibold px-4 py-2 rounded-lg hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-300">Hủy</a>
        </div>
    </form>

</div>