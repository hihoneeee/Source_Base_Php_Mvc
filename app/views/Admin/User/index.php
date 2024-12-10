<?php

use App\Helpers\PaginationHelper;
use App\Helpers\UrlAction;
?>
<div class="">
    <nav class="flex mb-4" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3 rtl:space-x-reverse">
            <li class="inline-flex items-center">
                <a href="/admin" class="flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 gap-2">
                    <i class="ri-home-4-fill"></i>
                    <span>Home</span>
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <i class="ri-arrow-right-s-line text-gray-500"></i>
                    <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2 dark:text-gray-400">Quản lý người
                        dùng</span>
                </div>
            </li>
        </ol>
    </nav>
    <h2 class="mb-4 text-3xl font-extrabold leading-none tracking-tight text-gray-900 md:text-4xl text-white">Quản
        lý
        người dùng</h2>
    <div class="flex items-center justify-between">
        <a href="<?php echo UrlAction::action('admin', 'user', 'create'); ?>"
            class="bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded">
            Tạo mới
        </a>
        <form class="w-[40%]">
            <label for="default-search"
                class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Tìm</label>
            <div class="relative">
                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                    <i class="ri-search-line text-white"></i>
                </div>
                <input type="text" type="text" name="name" value="<?php echo htmlspecialchars($name); ?>"
                    class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Tìm kiếm người dùng..." required />
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
                        Họ đệm
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Tên
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Email
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Vai trò
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Hành động
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($users)): ?>
                <?php foreach ($users as $user): ?>
                <tr
                    class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                    <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        <?php echo htmlspecialchars($user->id); ?>
                    </td>
                    <td class="px-6 py-4"><?php echo htmlspecialchars($user->first_name); ?></td>
                    <td class="px-6 py-4"><?php echo htmlspecialchars($user->last_name); ?></td>
                    <td class="px-6 py-4"><?php echo htmlspecialchars($user->email); ?></td>
                    <td class="px-6 py-4"><?php echo htmlspecialchars($user->value); ?></td>

                    <td class="px-6 py-4">
                        <a href="<?php echo UrlAction::action('admin', 'user', 'detail', [$user->id]); ?>"
                            class="text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-500 dark:focus:ring-blue-800">Chi
                            tiết</a>
                        <a href="<?php echo UrlAction::action('admin', 'user', 'edit', [$user->id]); ?>"
                            class="text-yellow-400 hover:text-white border border-yellow-400 hover:bg-yellow-500 focus:ring-4 focus:outline-none focus:ring-yellow-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 dark:border-yellow-300 dark:text-yellow-300 dark:hover:text-white dark:hover:bg-yellow-400 dark:focus:ring-yellow-900">Sửa</a>
                        <form action="<?php echo UrlAction::action('admin', 'user', 'delete', [$user->id]); ?>"
                            method="POST" style="display: inline;">
                            <button type="submit"
                                class="text-red-700 hover:text-white border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900"
                                onclick="return confirm('Bạn có chắc chắn muốn xóa vai trò này không?');">
                                Xóa
                            </button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php else: ?>
                <tr>
                    <td colspan="5" class="text-center py-4">Không có người dùng nào!</td>
                </tr>
                <?php endif; ?>


            </tbody>
        </table>
    </div>


    <?php
    PaginationHelper::renderAdmin($paginationDTO);
    ?>
</div>