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
                <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2 dark:text-gray-400">Quản lý vai trò</span>
            </div>
        </li>
    </ol>
</nav>
<h2 class="mb-4 text-3xl font-extrabold leading-none tracking-tight text-gray-900 md:text-4xl text-black">Quản lý vai
    trò</h2>
<div class="flex items-center justify-between">
    <a href="<?php echo UrlAction::action('role', 'create'); ?>"
        class="bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded">
        Tạo mới
    </a>
    <form method="GET" action="/role">
        <input type="text" name="name" value="<?php echo htmlspecialchars($name); ?>"
            placeholder="Tìm kiếm theo tên...">
        <button type="submit" class="bg-blue-500 text-white px-4 py-2">Tìm kiếm</button>
    </form>


</div>
<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    ID
                </th>
                <th scope="col" class="px-6 py-3">
                    Tên
                </th>
                <th scope="col" class="px-6 py-3">
                    Hành động
                </th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($roles)): ?>
            <?php foreach ($roles as $role): ?>
            <tr
                class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    <?php echo htmlspecialchars($role->id); ?>
                </td>
                <td class="px-6 py-4"><?php echo htmlspecialchars($role->value); ?></td>
                <td class="px-6 py-4">
                    <a href="<?php echo UrlAction::action('role', 'edit', [$role->id]); ?>"
                        class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Sửa</a>
                    <!-- Delete Form -->
                    <form action="<?php echo UrlAction::action('role', 'delete', [$role->id]); ?>" method="POST"
                        style="display: inline;">
                        <button type="submit" class="font-medium text-red-600 dark:text-red-500 hover:underline"
                            onclick="return confirm('Bạn có chắc chắn muốn xóa vai trò này không?');">
                            Xóa
                        </button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php else: ?>
            <tr>
                <td colspan="3" class="text-center py-4">Không có vai trò nào.</td>
            </tr>
            <?php endif; ?>
        </tbody>
        <?php echo $paginationHelper->render(); ?>

    </table>
</div>