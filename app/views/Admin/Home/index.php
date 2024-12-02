<?php

use App\Helpers\UrlAction;
?>
<div class="desktop:h-[64.3vh] laptop:h-[53.7vh]">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Card 1: Tổng số Users -->
        <div class="bg-blue-500 text-white p-4 rounded-lg shadow-md">
            <div class="text-4xl font-bold"><?= $totalUsers ?></div>
            <div class="mt-2">Tổng số vai trò</div>
            <a href="<?php echo UrlAction::action('admin', 'user', 'index'); ?>"
                class="text-white underline mt-4 inline-block">Xem thêm &rarr;</a>
        </div>

        <!-- Card 2: Tổng số Roles -->
        <div class="bg-green-500 text-white p-4 rounded-lg shadow-md">
            <div class="text-4xl font-bold"><?= $totalRoles ?></div>
            <div class="mt-2">Tổng số người dùng</div>
            <a href="<?php echo UrlAction::action('admin', 'role', 'index'); ?>"
                class="text-white underline mt-4 inline-block">Xem thêm &rarr;</a>
        </div>

        <!-- Card 3: Tùy chỉnh -->
        <div class="bg-yellow-500 text-white p-4 rounded-lg shadow-md">
            <div class="text-4xl font-bold">75%</div>
            <div class="mt-2">Tỷ lệ thoát
            </div>
            <a href="#" class="text-white underline mt-4 inline-block">Xem thêm &rarr;</a>
        </div>

        <!-- Card 4: Tùy chỉnh -->
        <div class="bg-red-500 text-white p-4 rounded-lg shadow-md">
            <div class="text-4xl font-bold">123</div>
            <div class="mt-2">Unique Visitors</div>
            <a href="#" class="text-white underline mt-4 inline-block">Xem thêm &rarr;</a>
        </div>
    </div>
</div>