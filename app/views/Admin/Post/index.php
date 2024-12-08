<?php

use App\Helpers\PaginationHelper;
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
                <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2 dark:text-gray-400">Quản lý bài viết</span>
            </div>
        </li>
    </ol>
</nav>
<h2 class="mb-4 text-3xl font-extrabold leading-none tracking-tight text-gray-900 md:text-4xl text-white">Quản lý bài
    viết</h2>
<div class="flex items-center justify-between">
    <a href="<?php echo UrlAction::action('admin', 'post', 'create'); ?>"
        class="bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded">
        Tạo mới
    </a>
    <form class="w-[40%]">
        <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Tìm</label>
        <div class="relative">
            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                <i class="ri-search-line text-white"></i>
            </div>
            <input type="text" type="text" name="name" value="<?php echo htmlspecialchars($name); ?>"
                class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="Tìm kiếm tên bài viết..." required />
            <button type="submit"
                class="text-white absolute end-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Tìm</button>
        </div>
    </form>
</div>
<div class="relative overflow-x-auto shadow-md sm:rounded-lg my-4">
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    ID
                </th>
                <th scope="col" class="px-6 py-3">
                    Tiêu đề
                </th>
                <th scope="col" class="px-6 py-3">
                    Mô tả
                </th>
                <th scope="col" class="px-6 py-3">
                    Hình ảnh
                </th>
                <th scope="col" class="px-6 py-3">
                    Danh mục
                </th>
                <th scope="col" class="px-6 py-3">
                    Tác giả
                </th>
                <th scope="col" class="px-6 py-3">
                    Trạng thái
                </th>
                <th scope="col" class="px-6 py-3">
                    Hành động
                </th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($posts)): ?>
                <?php foreach ($posts as $post): ?>
                    <tr
                        class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                        <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            <?php echo htmlspecialchars($post->id); ?>
                        </td>
                        <td class="px-6 py-4"><?php echo htmlspecialchars($post->title); ?></td>
                        <td class="px-6 py-4"><?php echo htmlspecialchars($post->meta); ?></td>
                        <td class="px-6 py-4">
                            <img src="/App/Uploads/Post/<?php echo htmlspecialchars($post->avatar); ?>" alt="post Image"
                                class="w-16 h-16 object-cover rounded">
                        </td>
                        <td class="px-6 py-4"><span
                                class="bg-gray-100 text-gray-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full dark:bg-gray-700 dark:text-gray-300"><?php echo htmlspecialchars($post->categoryName); ?></span>
                        </td>
                        <td class="px-6 py-4"><span
                                class="bg-blue-100 text-blue-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full dark:bg-blue-900 dark:text-blue-300"><?php echo htmlspecialchars($post->fullName); ?></span>
                        </td>
                        <td class="px-6 py-4">
                            <?php
                            // Gán màu và class cho từng trạng thái
                            switch ($post->status) {
                                case 'pending':
                                    $statusClass = 'bg-yellow-100 text-yellow-800';
                                    $statusText = 'Chờ duyệt';
                                    break;
                                case 'completed':
                                    $statusClass = 'bg-green-100 text-green-800';
                                    $statusText = 'Đã duyệt';
                                    break;
                                case 'hidden':
                                    $statusClass = 'bg-red-100 text-red-800';
                                    $statusText = 'Bị ẩn';
                                    break;
                                default:
                                    $statusClass = 'bg-gray-100 text-gray-800';
                                    $statusText = 'Unknown';
                            }
                            ?>
                            <span class="<?php echo $statusClass; ?> text-xs font-medium px-2.5 py-0.5 rounded-full">
                                <?php echo htmlspecialchars($statusText); ?>
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <a href="<?php echo UrlAction::action('admin', 'post', 'detail', [$post->id]); ?>"
                                class="text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-500 dark:focus:ring-blue-800">Chi
                                tiết</a>
                            <a href="<?php echo UrlAction::action('admin', 'post', 'edit', [$post->id]); ?>"
                                class="text-yellow-400 hover:text-white border border-yellow-400 hover:bg-yellow-500 focus:ring-4 focus:outline-none focus:ring-yellow-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 dark:border-yellow-300 dark:text-yellow-300 dark:hover:text-white dark:hover:bg-yellow-400 dark:focus:ring-yellow-900">Sửa</a>
                            <form action="<?php echo UrlAction::action('admin', 'post', 'delete', [$post->id]); ?>"
                                method="POST" style="display: inline;">
                                <button type="submit"
                                    class="text-red-700 hover:text-white border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900"
                                    onclick="return confirm('Bạn có chắc chắn muốn xóa bài viết này không?');">
                                    Xóa
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3" class="text-center py-4">Không có bài viết nào.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php
PaginationHelper::render($paginationDTO);
?>