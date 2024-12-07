<?php

use App\Helpers\UrlAction;

?>

<div class=" dark:text-gray-200">
    <div class="container mx-auto p-6">
        <h1 class="text-3xl text-white font-bold text-center mb-6">Quản Lý Thông Tin Cá Nhân</h1>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6 ">
                <form action="<?php echo UrlAction::action('admin', 'user', 'update-profile', [$user->id]); ?>"
                    method="POST" enctype="multipart/form-data" class="space-y-6">

                    <div class="flex flex-col items-center">
                        <div class="w-24 h-24 rounded-full overflow-hidden bg-gray-300 relative">
                            <img id="avatarPreview"
                                src="/App/Uploads/User/<?php echo htmlspecialchars($user->avatar); ?>" alt="Avatar"
                                class="w-full h-full object-cover">
                            <input type="file" id="avatarInput" name="avatar" class="hidden" accept="image/*"
                                onchange="previewAvatar(event)">
                            <button type="button" onclick="document.getElementById('avatarInput').click()"
                                class="absolute inset-0 w-full h-full flex items-center justify-center bg-black bg-opacity-50 text-white opacity-0 hover:opacity-100 transition">
                                Thay đổi
                            </button>
                            <?php if (!empty($errors['avatar'])): ?>
                                <p class="text-red-500 text-sm"><?php echo htmlspecialchars($errors['avatar']); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>


                    <div class="flex gap-4 w-full">
                        <div class="w-[50%]">
                            <label class="block text-white font-medium mb-2" for="first_name">Họ Đệm</label>
                            <input type="text" name="first_name" id="first_name" placeholder="Nhập họ đệm..."
                                class="w-full px-4 py-2 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                value="<?php echo htmlspecialchars($user->first_name ?? ''); ?>">
                            <?php if (!empty($errors['first_name'])): ?>
                                <p class="text-red-500 text-sm"><?php echo htmlspecialchars($errors['first_name']); ?></p>
                            <?php endif; ?>
                        </div>
                        <div class="w-[50%]">
                            <label class="block text-white font-medium mb-2" for="last_name">Tên</label>
                            <input type="text" name="last_name" id="last_name" placeholder="Nhập tên..."
                                class="w-full px-4 py-2 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                value="<?php echo htmlspecialchars($user->last_name ?? ''); ?>">
                            <?php if (!empty($errors['last_name'])): ?>
                                <p class="text-red-500 text-sm"><?php echo htmlspecialchars($errors['last_name']); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div>
                        <label class="block text-white font-medium mb-2" for="email">Email</label>
                        <input type="email" name="email" id="email" placeholder="Nhập email..."
                            class="w-full px-4 py-2 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            value="<?php echo htmlspecialchars($user->email ?? ''); ?>">
                        <?php if (!empty($errors['email'])): ?>
                            <p class="text-red-500 text-sm"><?php echo htmlspecialchars($errors['email']); ?></p>
                        <?php endif; ?>
                    </div>

                    <div>
                        <label class="block text-white font-medium mb-2" for="phone">Điện thoại</label>
                        <input type="phone" name="phone" id="phone" placeholder="Nhập phone..."
                            class="w-full px-4 py-2 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            value="<?php echo htmlspecialchars($user->phone ?? ''); ?>">
                        <?php if (!empty($errors['phone'])): ?>
                            <p class="text-red-500 text-sm"><?php echo htmlspecialchars($errors['phone']); ?></p>
                        <?php endif; ?>
                    </div>

                    <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700">
                        Cập Nhật
                    </button>
                </form>
            </div>

            <!-- Đổi Mật Khẩu -->
            <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">
                <h2 class="text-lg font-semibold text-center mb-4">Đổi Mật Khẩu</h2>
                <form action="<?php echo UrlAction::action('admin', 'user', 'updatePassword'); ?>" method="POST"
                    class="space-y-4">
                    <div>
                        <label for="currentPassword" class="block text-white font-medium mb-2">Mật khẩu hiện tại</label>
                        <input type="password" id="currentPassword" name="currentPassword"
                            class="w-full px-4 py-2 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label for="newPassword" class="block text-white font-medium mb-2">Mật khẩu mới</label>
                        <input type="password" id="newPassword" name="newPassword"
                            class="w-full px-4 py-2 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label for="confirmPassword" class="block text-white font-medium mb-2">Nhập lại mật khẩu
                            mới</label>
                        <input type="password" id="confirmPassword" name="confirmPassword"
                            class="w-full px-4 py-2 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700">
                        Cập Nhật
                    </button>
                </form>
            </div>
        </div>
    </div>

</div>
<script>
    function previewAvatar(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const avatarPreview = document.getElementById('avatarPreview');
                avatarPreview.src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    }
</script>