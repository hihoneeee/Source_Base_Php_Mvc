<?php

use App\Helpers\UrlAction;
?>
<nav class="flex mb-4" aria-label="Breadcrumb">
    <ol class="inline-flex items-center space-x-1 md:space-x-3 rtl:space-x-reverse">
        <li class="inline-flex items-center">
            <a href="/admin" class="flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 gap-2">
                <i class="ri-home-4-fill "></i>
                <span>Trang chủ</span>
            </a>
        </li>
        <li>
            <div class="flex items-center">
                <i class="ri-arrow-right-s-line text-gray-500 "></i>
                <a href="<?php echo UrlAction::action('admin', 'post', 'index'); ?>"
                    class="flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 gap-2">
                    <span>Quản lý bài viết</span>
                </a>
            </div>
        </li>
        <li>
            <div class="flex items-center">
                <i class="ri-arrow-right-s-line text-gray-500"></i>
                <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2 dark:text-gray-400">
                    <?php echo isset($post->id) ? 'Cập nhật bài viết' : 'Thêm mới bài viết'; ?>
                </span>
            </div>
        </li>
    </ol>
</nav>
<h2 class="mb-4 text-3xl font-extrabold leading-none tracking-tight text-gray-900 md:text-4xl text-white">Quản lý danh
    mục</h2>

<div class="bg-gray-800 shadow-md rounded-lg overflow-hidden mt-10">
    <div class="bg-gray-700 px-6 py-4 border-b border-gray-600">
        <h2 class="text-lg font-semibold text-white">
            <?php echo isset($post) ? 'Cập nhật bài viết' : 'Thêm mới bài viết'; ?>
        </h2>
    </div>
    <form
        action="<?php echo isset($post) ? UrlAction::action('admin', 'post', 'update', [$post->id]) : UrlAction::action('admin', 'post', 'store'); ?>"
        method="post" enctype="multipart/form-data" class="p-4">
        <!-- Nút hành động -->
        <div class="flex justify-end space-x-2 mt-4 w-full">
            <button type="submit"
                class="bg-<?php echo isset($post) ? 'green-600' : 'blue-500'; ?> text-white font-semibold px-4 py-2 rounded-lg hover:bg-<?php echo isset($post) ? 'green-700' : 'blue-600'; ?> focus:outline-none focus:ring-2 focus:ring-blue-500">
                <?php echo isset($post) ? 'Cập Nhật' : 'Thêm'; ?>
            </button>
            <a href="<?php echo UrlAction::action('admin', 'post', 'index'); ?>"
                class="bg-gray-400 text-white font-semibold px-4 py-2 rounded-lg hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-300">Hủy</a>
        </div>
        <div class="flex space-x-4">
            <!-- Phần trái: 70% -->
            <div class="w-[70%] space-y-4">
                <!-- Tiêu đề bài viết -->
                <div>
                    <label class="block text-white font-medium mb-2" for="title">Tiêu đề bài viết</label>
                    <input type="text" name="title" id="title" placeholder="Nhập tên bài viết..."
                        class="w-full px-4 py-2 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        value="<?php echo htmlspecialchars($post->title ?? ''); ?>">
                    <?php if (!empty($errors['title'])): ?>
                    <p class="text-red-500 text-sm"><?php echo htmlspecialchars($errors['title']); ?></p>
                    <?php endif; ?>
                </div>

                <!-- Mô tả -->
                <div>
                    <label class="block text-white font-medium mb-2" for="meta">Mô tả</label>
                    <textarea name="meta" id="meta" placeholder="Nhập mô tả..."
                        class="w-full px-4 py-2 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"><?php echo htmlspecialchars($post->meta ?? ''); ?></textarea>
                    <?php if (!empty($errors['meta'])): ?>
                    <p class="text-red-500 text-sm"><?php echo htmlspecialchars($errors['meta']); ?></p>
                    <?php endif; ?>
                </div>

                <!-- Nội dung -->
                <div>
                    <label class="block text-white font-medium mb-2" for="content">Nội dung</label>
                    <textarea name="content" id="content"
                        class="w-full px-4 py-2 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"><?php echo htmlspecialchars($post->content ?? ''); ?></textarea>
                    <?php if (!empty($errors['content'])): ?>
                    <p class="text-red-500 text-sm"><?php echo htmlspecialchars($errors['content']); ?></p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Phần phải: 30% -->
            <div class="w-[30%] space-y-4">
                <div>
                    <label class="block text-white font-medium mb-2" for="author">Tác giả</label>
                    <input type="text" id="author"
                        class="w-full px-4 py-2 bg-gray-700 text-gray-400 border border-gray-600 rounded-lg" disabled
                        value="<?php echo htmlspecialchars($userFullName); ?>">
                </div>

                <div class="relative w-full">
                    <label for="search-categoryId" class="sr-only">Danh mục</label>
                    <select id="search-categoryId" name="categoryId"
                        class="block w-full p-4 text-sm border rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                        <option value="">-- Chọn danh mục --</option>
                        <?php foreach ($categories as $category): ?>
                        <option value="<?php echo htmlspecialchars($category->id); ?>"
                            <?php echo (isset($post->category_id) && $post->category_id == $category->id) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($category->title); ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div>
                    <label class="block text-white font-medium mb-2" for="status">Trạng thái</label>
                    <select name="status" id="status"
                        class="w-full px-4 py-2 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <?php if ($_SESSION['user_info']->role === 'Admin'): ?>
                        <option value="pending"
                            <?php echo isset($post) && $post->status === 'pending' ? 'selected' : ''; ?>>
                            Nháp</option>
                        <option value="completed"
                            <?php echo isset($post) && $post->status === 'completed' ? 'selected' : ''; ?>>
                            Duyệt</option>
                        <option value="hidden"
                            <?php echo isset($post) && $post->status === 'hidden' ? 'selected' : ''; ?>>
                            Ẩn</option>
                        <?php else: ?>
                        <option value="pending"
                            <?php echo isset($post) && $post->status === 'pending' ? 'selected' : ''; ?>>
                            Nháp
                        </option>
                        <?php endif; ?>
                    </select>
                </div>

                <!-- Hình ảnh -->
                <div>
                    <label class="block text-white font-medium mb-2" for="avatar">Hình ảnh</label>
                    <input type="file" name="avatar" id="avatar"
                        class="w-full px-4 py-2 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        onchange="previewImage(event)">
                    <?php if (isset($post) && !empty($post->avatar)): ?>
                    <img id="imagePreview" src="/App/Public/Uploads/post/<?php echo htmlspecialchars($post->avatar); ?>"
                        alt="Ảnh bài viết" class="mt-4 max-h-48">
                    <?php else: ?>
                    <img id="imagePreview" src="#" alt="Preview ảnh" class="hidden mt-4 max-h-48">
                    <?php endif; ?>
                    <?php if (!empty($errors['avatar'])): ?>
                    <p class="text-red-500 text-sm"><?php echo htmlspecialchars($errors['avatar']); ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </form>
</div>