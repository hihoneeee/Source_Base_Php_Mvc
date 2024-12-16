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
    <form class="w-[60%] flex gap-4" method="post" action="/admin/report/time/search">

        <div class="relative w-full">
            <label for="search-time" class="sr-only">Tiêu chí lựa chọn</label>
            <select id="search-time" name="time"
                class="block w-full p-4 text-sm border rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                <option value="1" <?php echo isset($condition->time) && $condition->time == '1' ? 'selected' : ''; ?>>
                    Theo tháng</option>
                <option value="2" <?php echo isset($condition->time) && $condition->time == '2' ? 'selected' : ''; ?>>
                    Theo năm</option>
            </select>
        </div>

        <!-- Hidden fields for additional search parameters -->
        <?php if (!empty($condition)): ?>
            <?php foreach ($condition as $key => $value): ?>
                <?php if (!in_array($key, ['time']) && !empty($value)): ?>
                    <input type="hidden" name="<?php echo htmlspecialchars($key); ?>"
                        value="<?php echo htmlspecialchars($value); ?>">
                <?php endif; ?>
            <?php endforeach; ?>
        <?php endif; ?>

        <!-- Nút tìm kiếm -->
        <button type="submit"
            class="text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm p-2 w-[18%]">
            Tìm kiếm
        </button>
    </form>
</div>

<div class="relative overflow-x-auto shadow-md sm:rounded-lg my-4">
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <?php if (isset($condition) && $condition->time === "1"): ?>
                    <th scope="col" class="px-6 py-3 text-center">Tháng</th>
                <?php else: ?>
                    <th scope="col" class="px-6 py-3 text-center">Năm</th>
                <?php endif; ?>
                <th scope="col" class="px-6 py-3 text-center w-[15rem]">Số bài viết</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($posts)): ?>
                <!-- Nút xuất report chỉ hiển thị nếu có dữ liệu -->
                <div class="flex justify-end mb-4">
                    <form method="post" action="/admin/report/generator" class="inline">
                        <input type="hidden" name="time" value="<?php echo htmlspecialchars($condition->time ?? ''); ?>">
                        <button type="submit"
                            class="text-white bg-green-600 hover:bg-green-700 font-medium rounded-lg text-sm px-4 py-2">
                            Xuất báo cáo
                        </button>
                    </form>
                </div>
                <?php foreach ($posts as $post): ?>
                    <tr
                        class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                        <!-- Conditionally render data based on selected time -->
                        <?php if ($condition->time == "1"): ?>
                            <td class="px-6 py-4 text-center">
                                <?php echo htmlspecialchars($post['month']); ?>
                            </td>
                        <?php else: ?>
                            <td class="px-6 py-4 text-center">
                                <?php echo htmlspecialchars($post['year']); ?>
                            </td>
                        <?php endif; ?>
                        <td class="px-6 py-4 text-center">
                            <?php echo htmlspecialchars($post['post_count']); ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="2" class="text-center py-4 text-gray-500 dark:text-gray-400">Không có dữ liệu báo cáo.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>