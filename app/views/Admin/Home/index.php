<?php

use App\Helpers\UrlAction;
?>
<div class="desktop:h-[64.3vh] laptop:h-[53.7vh]">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Card 1: Tổng số Users -->
        <div class="bg-blue-500 text-white p-4 rounded-lg shadow-md">
            <div class="text-4xl font-bold"><?= $totalUsers ?></div>
            <div class="flex items-center gap-2 mt-2">
                <i class="ri-group-line"></i>
                <p>Tổng số người dùng</p>
            </div>
            <a href="<?php echo UrlAction::action('admin', 'user', 'index'); ?>"
                class="text-white underline mt-4 inline-block">Xem thêm &rarr;</a>
        </div>

        <!-- Card 2: Tổng số Roles -->
        <div class="bg-green-500 text-white p-4 rounded-lg shadow-md">
            <div class="text-4xl font-bold"><?= $totalRoles ?></div>
            <div class="flex items-center gap-2 mt-2">
                <i class="ri-user-settings-line"></i>
                <p>Tổng số vai trò</p>
            </div>
            <a href="<?php echo UrlAction::action('admin', 'role', 'index'); ?>"
                class="text-white underline mt-4 inline-block">Xem thêm &rarr;</a>
        </div>

        <!-- Card 3: Tùy chỉnh -->
        <div class="bg-green-500 text-white p-4 rounded-lg shadow-md">
            <div class="text-4xl font-bold"><?= $totalRoles ?></div>
            <div class="flex items-center gap-2 mt-2">
                <i class="ri-pages-line"></i>
                <p>Tổng số bài viết</p>
            </div>
            <a href="<?php echo UrlAction::action('admin', 'post', 'index'); ?>"
                class="text-white underline mt-4 inline-block">Xem thêm &rarr;</a>
        </div>

        <!-- Card 4: Tùy chỉnh -->
        <div class="bg-red-500 text-white p-4 rounded-lg shadow-md">
            <div class="text-4xl font-bold">123</div>
            <div class="mt-2">Unique Visitors</div>
            <a href="#" class="text-white underline mt-4 inline-block">Xem thêm &rarr;</a>
        </div>
    </div>
</div>