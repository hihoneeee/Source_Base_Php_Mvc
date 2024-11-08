<nav class="flex mb-4" aria-label="Breadcrumb">
    <ol class="inline-flex items-center space-x-1 md:space-x-3 rtl:space-x-reverse">
        <li class="inline-flex items-center">
            <a href="#" class="flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 gap-2">
                <i class="ri-home-4-fill"></i>
                <span>Home</span>
            </a>
        </li>
        <li>
            <div class="flex items-center">
                <i class="ri-arrow-right-s-line w-3 h-3 text-gray-400 mx-1 rtl:rotate-180"></i>
                <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2 dark:text-gray-400">Quản lý người
                    dùng</span>
            </div>
        </li>
    </ol>
</nav>
<h2 class="mb-4 text-3xl font-extrabold leading-none tracking-tight text-gray-900 md:text-4xl text-black">Quản lý
    người dùng</h2>

<div class=" bg-white shadow-md rounded-lg overflow-hidden mt-10">
    <div class="bg-gray-100 px-6 py-4 border-b">
        <h2 class="text-lg font-semibold text-gray-700">Thêm mới người dùng</h2>
    </div>
    <form class="p-4 space-y-4">
        <div class="flex items-center gap-2 w-full">
            <div class="w-[50%]">
                <label class="block text-gray-700 font-semibold mb-2" for="username">Họ đệm</label>
                <input type="text" id="username" placeholder="Nhập tên họ đệm..."
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="w-[50%]">
                <label class="block text-gray-700 font-semibold mb-2" for="username">Tên</label>
                <input type="text" id="username" placeholder="Nhập tên..."
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
        </div>
        <div>
            <label class="block text-gray-700 font-semibold mb-2" for="username">Tài khoản người dùng</label>
            <input type="text" id="username" placeholder="Nhập tên tài khoản..."
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <div>
            <label class="block text-gray-700 font-semibold mb-2" for="email">Email</label>
            <input type="email" id="email" placeholder="Nhập email..."
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <div class="flex justify-end space-x-2">
            <button type="submit"
                class="bg-blue-500 text-white font-semibold px-4 py-2 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">Thêm</button>
            <button type="button"
                class="bg-gray-400 text-white font-semibold px-4 py-2 rounded-lg hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-300">Hủy</button>
        </div>
    </form>
</div>