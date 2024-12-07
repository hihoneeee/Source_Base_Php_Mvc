<?php

use App\Helpers\UrlAction;

?>

<div class=" dark:text-gray-200">
    <div class="container mx-auto p-6">
        <!-- Header -->
        <h1 class="text-3xl text-black font-bold text-center mb-6">Quản Lý Thông Tin Cá Nhân</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Thông Tin Cá Nhân -->
            <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">
                <div class="flex flex-col items-center">
                    <!-- Avatar -->
                    <div class="w-24 h-24 rounded-full overflow-hidden bg-gray-300">
                        <img src="<?php echo $user->avatar; ?>" alt="Avatar" class="w-full h-full object-cover">
                    </div>
                    <!-- Tên và Vai Trò -->
                    <h2 class="text-xl font-bold mt-4">
                        <?php echo htmlspecialchars($user->first_name . ' ' . $user->last_name); ?>
                    </h2>
                    <p class="text-gray-500">Vai trò : <?php echo htmlspecialchars($user->value); ?></p>
                </div>
                <div class="mt-6 space-y-4">
                    <!-- Ngày tạo -->
                    <div class="flex justify-between">
                        <span class="font-semibold">Ngày tạo:</span>
                        <span><?php echo htmlspecialchars($user->created_at); ?></span>
                    </div>
                    <!-- Email -->
                    <div class="flex justify-between">
                        <span class="font-semibold">Email:</span>
                        <span><?php echo htmlspecialchars($user->email); ?></span>
                    </div>
                    <!-- Phone -->
                    <div class="flex justify-between">
                        <span class="font-semibold">Số điện thoại:</span>
                        <span><?php echo htmlspecialchars($user->phone); ?></span>
                    </div>
                </div>
            </div>

            <!-- Đổi Mật Khẩu -->
            <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">
                <h2 class="text-lg font-semibold text-center mb-4">Đổi Mật Khẩu</h2>
                <form action="<?php echo UrlAction::action('admin', 'user', 'updatePassword'); ?>" method="POST"
                    class="space-y-4">
                    <div>
                        <label for="currentPassword" class="block font-medium mb-1">Mật khẩu hiện tại</label>
                        <input type="password" id="currentPassword" name="currentPassword"
                            class="w-full px-3 py-2 border rounded-lg focus:ring focus:ring-blue-500 focus:outline-none">
                    </div>
                    <div>
                        <label for="newPassword" class="block font-medium mb-1">Mật khẩu mới</label>
                        <input type="password" id="newPassword" name="newPassword"
                            class="w-full px-3 py-2 border rounded-lg focus:ring focus:ring-blue-500 focus:outline-none">
                    </div>
                    <div>
                        <label for="confirmPassword" class="block font-medium mb-1">Nhập lại mật khẩu mới</label>
                        <input type="password" id="confirmPassword" name="confirmPassword"
                            class="w-full px-3 py-2 border rounded-lg focus:ring focus:ring-blue-500 focus:outline-none">
                    </div>
                    <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700">
                        Cập Nhật
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>