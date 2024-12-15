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
                <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2 dark:text-gray-400">Thống kê báo cáo bài
                    viết</span>
            </div>
        </li>
    </ol>
</nav>
<h2 class="mb-4 text-3xl font-extrabold leading-none tracking-tight text-gray-900 md:text-4xl text-white">
    Thống kê báo cáo bài viết
</h2>
<div class="flex items-center justify-between">
    <form class="w-[60%] flex gap-4" method="post" action="/admin/report/search">
        <!-- Tìm kiếm theo tiêu đề -->
        <div class="relative w-full">
            <label for="search-title" class="sr-only">Tìm kiếm tiêu đề</label>
            <input type="text" id="search-title" name="title"
                value="<?php echo htmlspecialchars($condition->title ?? ''); ?>"
                class="block w-full p-4 text-sm border rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                placeholder="Tìm kiếm tiêu đề bài viết..." />
        </div>

        <!-- Tìm kiếm theo người dùng -->
        <div class="relative w-full">
            <label for="search-userId" class="sr-only">Người dùng</label>
            <select id="search-userId" name="userId"
                class="block w-full p-4 text-sm border rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                <option value="">-- Chọn người dùng --</option>
                <?php foreach ($users as $user): ?>
                    <option value="<?php echo $user->id; ?>"
                        <?php echo (isset($condition->userId) && $condition->userId == $user->id) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($user->fullname); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Tìm kiếm theo danh mục -->
        <div class="relative w-full">
            <label for="search-categoryId" class="sr-only">Danh mục</label>
            <select id="search-categoryId" name="categoryId"
                class="block w-full p-4 text-sm border rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                <option value="">-- Chọn danh mục --</option>
                <?php foreach ($categories as $category): ?>
                    <option value="<?php echo $category->id; ?>"
                        <?php echo (isset($condition->categoryId) && $condition->categoryId == $category->id) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($category->title); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Hidden fields for additional search parameters -->
        <?php if (!empty($condition)): ?>
            <?php foreach ($condition as $key => $value): ?>
                <?php if (!in_array($key, ['title', 'userId', 'categoryId']) && !empty($value)): ?>
                    <input type="hidden" name="<?php echo htmlspecialchars($key); ?>"
                        value="<?php echo htmlspecialchars($value); ?>">
                <?php endif; ?>
            <?php endforeach; ?>
        <?php endif; ?>

        <!-- Nút tìm kiếm -->
        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm px-4 py-2">
            Tìm kiếm
        </button>
    </form>
</div>

<div class="relative overflow-x-auto shadow-md sm:rounded-lg my-4">
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3 text-center w-[1rem]">ID</th>
                <th scope="col" class="px-6 py-3 text-center w-[15rem]">Tiêu đề</th>
                <th scope="col" class="px-6 py-3 text-center">Tác giả</th>
                <th scope="col" class="px-6 py-3 text-center">Danh mục</th>
                <th scope="col" class="px-6 py-3 text-center">Trạng thái</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($posts)): ?>
                <!-- Nút xuất report chỉ hiển thị nếu có dữ liệu -->
                <div class="flex justify-end mb-4">
                <form method="post" action="/admin/report/generator" class="inline">
                <input type="hidden" name="title" value="<?php echo htmlspecialchars($condition->title ?? ''); ?>">
                <input type="hidden" name="userId" value="<?php echo htmlspecialchars($condition->userId ?? ''); ?>">
                <input type="hidden" name="categoryId" value="<?php echo htmlspecialchars($condition->categoryId ?? ''); ?>">
                <button type="submit" class="text-white bg-green-600 hover:bg-green-700 font-medium rounded-lg text-sm px-4 py-2">
                    Xuất báo cáo
                </button>
            </form>
                </div>
                <?php foreach ($posts as $post): ?>
                    <tr
                        class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white text-center">
                            <?php echo htmlspecialchars($post['id']); ?>
                        </td>
                        <td class="px-6 py-4 font-medium text-gray-700 dark:text-gray-300">
                            <?php
                            $shortTitle = strlen($post['title']) > 50 ? substr($post['title'], 0, 50) . '...' : $post['title'];
                            echo htmlspecialchars($shortTitle);
                            ?>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <?php echo htmlspecialchars($post['fullName']); ?>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <?php echo htmlspecialchars($post['category']); ?>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <?php echo htmlspecialchars($post['status']); ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="text-center py-4 text-gray-500 dark:text-gray-400">Không có dữ liệu báo cáo.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>