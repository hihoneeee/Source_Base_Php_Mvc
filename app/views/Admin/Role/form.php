<?php

use App\Helpers\UrlAction;
?>
<nav class="flex mb-4" aria-label="Breadcrumb">
    <ol class="inline-flex items-center space-x-1 md:space-x-3 rtl:space-x-reverse">
        <li class="inline-flex items-center">
            <a href="/admin" class="flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 gap-2">
                <i class="ri-home-4-fill"></i>
                <span>Trang chủ</span>
            </a>
        </li>
        <li>
            <div class="flex items-center">
                <i class="ri-arrow-right-s-line text-gray-500"></i>
                <a href="<?php echo UrlAction::action('admin', 'role', 'index'); ?>"
                    class="flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 gap-2">
                    <span>Quản lý vai trò</span>
                </a>
            </div>
        </li>
        <li>
            <div class="flex items-center">
                <i class="ri-arrow-right-s-line text-gray-500"></i>
                <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2 dark:text-gray-400">
                    <?php echo isset($role->id) ? 'Cập nhật vai trò' : 'Thêm mới vai trò'; ?>
                </span>
            </div>
        </li>
    </ol>
</nav>
<h2 class="mb-4 text-3xl font-extrabold leading-none tracking-tight text-gray-900 md:text-4xl text-white">Quản lý vai
    trò</h2>

<div class="bg-gray-800 shadow-md rounded-lg overflow-hidden mt-10">
    <div class="bg-gray-700 px-6 py-4 border-b border-gray-600">
        <h2 class="text-lg font-semibold text-white">
            <?php echo isset($role) ? 'Cập nhật vai trò' : 'Thêm mới vai trò'; ?>
        </h2>
    </div>
    <form
        action="<?php echo isset($role) ? UrlAction::action('admin', 'role', 'update', [$role->id]) : UrlAction::action('admin', 'role', 'store'); ?>"
        method="post" class="p-6 space-y-6">

        <div>
            <label class="block text-white font-medium mb-2" for="value">Tên vai trò</label>

            <input type="text" name="value" id="value" placeholder="Nhập tên vai trò..."
                class="w-full px-4 py-2 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                value="<?php echo htmlspecialchars($role->value ?? ''); ?>">

            <?php if (!empty($errors['value'])): ?>
                <p class="text-red-500 text-sm"><?php echo htmlspecialchars($errors['value']); ?></p>
            <?php endif; ?>
        </div>

        <div class="flex justify-end space-x-2">
            <button type="submit"
                class="bg-<?php echo isset($role) ? 'green-600' : 'blue-500'; ?> text-white font-semibold px-4 py-2 rounded-lg hover:bg-<?php echo isset($role) ? 'green-700' : 'blue-600'; ?> focus:outline-none focus:ring-2 focus:ring-blue-500">
                <?php echo isset($role) ? 'Cập Nhật' : 'Thêm'; ?>
            </button>
            <a href="<?php echo UrlAction::action('admin', 'role', 'index'); ?>"
                class="bg-gray-400 text-white font-semibold px-4 py-2 rounded-lg hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-300">Hủy</a>
        </div>
    </form>

</div>