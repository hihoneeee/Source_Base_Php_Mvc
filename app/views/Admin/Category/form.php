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
                <a href="<?php echo UrlAction::action('admin', 'category', 'index'); ?>"
                    class="flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 gap-2">
                    <span>Quản lý danh mục</span>
                </a>
            </div>
        </li>
        <li>
            <div class="flex items-center">
                <i class="ri-arrow-right-s-line text-gray-500"></i>
                <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2 dark:text-gray-400">
                    <?php echo isset($category->id) ? 'Cập nhật danh mục' : 'Thêm mới danh mục'; ?>
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
            <?php echo isset($category) ? 'Cập nhật danh mục' : 'Thêm mới danh mục'; ?>
        </h2>
    </div>
    <form
        action="<?php echo isset($category) ? UrlAction::action('admin', 'category', 'update', [$category->id]) : UrlAction::action('admin', 'category', 'store'); ?>"
        method="post" enctype="multipart/form-data" class="p-4 space-y-4">

        <!-- Tên danh mục -->
        <div>
            <label class="block text-white font-medium mb-2" for="title">Tên danh mục</label>
            <input type="text" name="title" id="title" placeholder="Nhập tên danh mục..."
                class="w-full px-4 py-2 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                value="<?php echo htmlspecialchars($category->title ?? ''); ?>">
            <?php if (!empty($errors['title'])): ?>
                <p class="text-red-500 text-sm"><?php echo htmlspecialchars($errors['title']); ?></p>
            <?php endif; ?>
        </div>

        <!-- Mô tả -->
        <div>
            <label class="block text-white font-medium mb-2" for="description">Mô tả</label>
            <textarea name="description" id="description" placeholder="Nhập mô tả..."
                class="w-full px-4 py-2 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"><?php echo htmlspecialchars($category->description ?? ''); ?></textarea>
            <?php if (!empty($errors['description'])): ?>
                <p class="text-red-500 text-sm"><?php echo htmlspecialchars($errors['description']); ?></p>
            <?php endif; ?>
        </div>

        <!-- Avatar -->
        <div>
            <label class="block text-white font-medium mb-2" for="avatar">Hình ảnh</label>
            <input type="file" name="avatar" id="avatar"
                class="w-full px-4 py-2 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                onchange="previewImage(event)">
            <?php if (isset($category) && !empty($category->avatar)): ?>
                <!-- Hiển thị ảnh cũ -->
                <img id="imagePreview" src="/App/Uploads/Category/<?php echo htmlspecialchars($category->avatar); ?>"
                    alt="Ảnh danh mục" class="mt-4 max-h-48">
            <?php else: ?>
                <img id="imagePreview" src="#" alt="Preview ảnh" class="hidden mt-4 max-h-48">
            <?php endif; ?>
            <?php if (!empty($errors['avatar'])): ?>
                <p class="text-red-500 text-sm"><?php echo htmlspecialchars($errors['avatar']); ?></p>
            <?php endif; ?>
        </div>

        <div class="flex justify-end space-x-2">
            <button type="submit"
                class="bg-<?php echo isset($category) ? 'green-600' : 'blue-500'; ?> text-white font-semibold px-4 py-2 rounded-lg hover:bg-<?php echo isset($category) ? 'green-700' : 'blue-600'; ?> focus:outline-none focus:ring-2 focus:ring-blue-500">
                <?php echo isset($category) ? 'Cập Nhật' : 'Thêm'; ?>
            </button>
            <a href="<?php echo UrlAction::action('admin', 'category', 'index'); ?>"
                class="bg-gray-400 text-white font-semibold px-4 py-2 rounded-lg hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-300">Hủy</a>
        </div>
    </form>
</div>

<script>
    function previewImage(event) {
        const input = event.target;
        const preview = document.getElementById('imagePreview');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove('hidden');
            };
            reader.readAsDataURL(input.files[0]);
        } else {
            preview.src = "#";
            preview.classList.add('hidden');
        }
    }
</script>