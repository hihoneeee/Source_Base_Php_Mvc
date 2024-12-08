<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php

            use App\Helpers\UrlAction;

            echo isset($title) ? $title : 'Trang chủ'; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.1.0/fonts/remixicon.css" rel="stylesheet" />
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">

</head>

<body>
    <!-- Header -->
    <div class="antialiased bg-gray-50 dark:bg-gray-900">
        <nav
            class="bg-white border-b border-gray-200 px-4 py-2.5 dark:bg-gray-800 dark:border-gray-700 fixed left-0 right-0 top-0 z-50">
            <div class="flex flex-wrap justify-between items-center">
                <div class="flex justify-start items-center">
                    <a href="/admin" class="flex items-center justify-between mr-4">
                        <span
                            class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">AdminLTE</span>
                    </a>
                </div>
                <div class="flex items-center lg:order-2">
                    <button type="button" data-dropdown-toggle="notification-dropdown"
                        class="p-2 mr-1 text-gray-500 rounded-lg hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-700 focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600">
                        <span class="sr-only">View notifications</span>
                        <i class="ri-notification-2-line"></i>
                    </button>

                    <button id="userMenuButton" onclick="toggleUserMenu()"
                        class="flex mx-3 text-sm bg-gray-800 rounded-full md:mr-0 focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600"
                        id="user-menu-button" aria-expanded="false" data-dropdown-toggle="dropdown">
                        <span class="sr-only">Open user menu</span>
                        <img class="w-8 h-8 rounded-full"
                            src="/App/Uploads/User/<?php echo htmlspecialchars($_SESSION['user_info']->avatar); ?>"
                            alt="user photo" />
                    </button>
                    <div class="hidden absolute right-0 top-16 w-48 bg-white dark:bg-gray-800 shadow-md rounded-lg py-2"
                        id="userMenu">
                        <div class="py-3 px-4 text-center">
                            <span class="block text-sm font-semibold text-gray-900 dark:text-white">Xin chào
                                <?php echo htmlspecialchars($_SESSION['user_info']->first_name); ?>
                                <?php echo htmlspecialchars($_SESSION['user_info']->last_name); ?>!</span>
                        </div>
                        <ul class="py-1 text-gray-700 dark:text-gray-300" aria-labelledby="dropdown">
                            <li>
                                <a href="<?php echo UrlAction::action('admin', 'user', 'profile', [$_SESSION['user_info']->id]); ?>"
                                    class="block py-2 px-4 text-sm hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-400 dark:hover:text-white">Trang
                                    cá nhân</a>
                            </li>
                            <li>
                                <a href="<?php echo UrlAction::action('admin', 'auth', 'logout'); ?>"
                                    class="block py-2 px-4 text-sm hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-400 dark:hover:text-white">Đăng
                                    xuất</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>

        <aside
            class="fixed top-0 left-0 z-40 w-64 h-screen pt-14 bg-[#1a2226] border-r border-gray-700 dark:bg-gray-800 dark:border-gray-700"
            aria-label="Sidenav" id="drawer-navigation">
            <div class="overflow-y-auto py-5 px-3 h-full text-[#4b646f]">

                <div
                    class="text-xs font-bold uppercase p-4 bg-[#1a2226] text-[#4b646f] dark:bg-gray-800 dark:border-gray-700">
                    Main Menu
                </div>
                <ul class="space-y-2">
                    <li>
                        <a href="/admin"
                            class="flex items-center justify-between p-2 text-base font-medium text-white rounded-lg hover:bg-gray-700">
                            <div class="flex items-center">
                                <i class="ri-home-3-line mr-3"></i>
                                <span>Trang chủ</span>
                            </div>
                        </a>
                    </li>
                </ul>

                <div
                    class="text-xs font-bold uppercase p-4 bg-[#1a2226] text-[#4b646f] dark:bg-gray-800 dark:border-gray-700">
                    System Menu
                </div>
                <ul class="space-y-2">
                    <li>
                        <a href="<?php echo UrlAction::action('admin', 'user', 'index'); ?>"
                            class="flex items-center p-2 text-base font-medium text-white rounded-lg hover:bg-gray-700">
                            <i class="ri-group-line mr-2 text-lg"></i>
                            <span>Quản lý người dùng</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo UrlAction::action('admin', 'role', 'index'); ?>"
                            class="flex items-center p-2 text-base font-medium text-white rounded-lg hover:bg-gray-700">
                            <i class="ri-user-settings-line mr-2 text-lg"></i>
                            <span>Quản lý vai trò</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo UrlAction::action('admin', 'category', 'index'); ?>"
                            class="flex items-center p-2 text-base font-medium text-white rounded-lg hover:bg-gray-700">
                            <i class="ri-contacts-book-line mr-2 text-lg"></i>
                            <span>Quản lý danh mục</span>
                        </a>
                    </li>
                </ul>

                <div
                    class="text-xs font-bold uppercase p-4 bg-[#1a2226] text-[#4b646f] dark:bg-gray-800 dark:border-gray-700">
                    Client Menu
                </div>
                <ul class="space-y-2">
                    <li>
                        <a href="<?php echo UrlAction::action('admin', 'post', 'index'); ?>"
                            class="flex items-center p-2 text-base font-medium text-white rounded-lg hover:bg-gray-700">
                            <i class="ri-pages-line mr-2 text-lg"></i>
                            <span>Quản lý bài viết</span>
                        </a>
                    </li>
                </ul>
            </div>
        </aside>



        <main class="p-4 md:ml-64 pt-20 min-h-screen">
            <?php echo $content; ?>

        </main>

        <footer class=" p-4 md:ml-64 pt-20 bg-white dark:bg-gray-900">
            <div class="w-full max-w-screen-xl p-4 py-6 lg:py-8">
                <div class="md:flex md:justify-between">
                    <div class="mb-6 md:mb-0">
                        <a href="/admin" class="flex items-center">
                            <span
                                class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">AdminLTE</span>
                        </a>
                    </div>

                </div>
                <hr class="my-6 border-gray-200 sm:mx-auto dark:border-gray-700 lg:my-8" />
                <div class="sm:flex sm:items-center sm:justify-between">
                    <span class="text-sm text-gray-500 sm:text-center dark:text-gray-400">© 2024 <a href="#"
                            class="hover:underline">Hohuy™</a>. All Rights Reserved.
                    </span>
                    <div class="flex mt-4 sm:justify-center sm:mt-0">
                        <a href="#" class="text-gray-500 hover:text-gray-900 dark:hover:text-white">
                            <i class="ri-facebook-line"></i>
                            <span class="sr-only">Facebook page</span>
                        </a>
                        <a href="#" class="text-gray-500 hover:text-gray-900 dark:hover:text-white ms-5">
                            <i class="ri-discord-line"></i>
                            <span class="sr-only">Discord community</span>
                        </a>
                        <a href="#" class="text-gray-500 hover:text-gray-900 dark:hover:text-white ms-5">
                            <i class="ri-twitter-x-line"></i>
                            <span class="sr-only">Twitter page</span>
                        </a>
                        <a href="#" class="text-gray-500 hover:text-gray-900 dark:hover:text-white ms-5">
                            <i class="ri-github-line"></i>
                            <span class="sr-only">GitHub account</span>
                        </a>
                        <a href="#" class="text-gray-500 hover:text-gray-900 dark:hover:text-white ms-5">
                            <i class="ri-dribbble-line"></i>
                            <span class="sr-only">Dribbble account</span>
                        </a>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        clifford: '#da373d',
                    },
                    backgroundColor: {
                        "overlay-10": "rgba(0,0,0,0.1)",
                        "overlay-20": "rgba(0,0,0,0.2)",
                        "overlay-30": "rgba(0,0,0,0.3)",
                        "overlay-50": "rgba(0,0,0,0.5)",
                        "overlay-70": "rgba(0,0,0,0.7)",
                    },
                    fontSize: {
                        xxs: ".5rem",
                    },
                    screens: {
                        mobile: "640px", // Kích thước mobile
                        tablet: "768px", // Kích thước tablet
                        laptop: "1366px", // Kích thước laptop
                        desktop: "1920px", // Kích thước màn hình 23.8 inch
                    },
                }
            }
        }
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>


    <?php if (isset($_SESSION['toastMessage'])): ?>
        <script>
            window.onload = function() {
                var toastMessage = "<?php echo $_SESSION['toastMessage']; ?>";
                var toastSuccess = "<?php echo $_SESSION['toastSuccess'] ? 'true' : 'false'; ?>";

                // Cấu hình mặc định cho Toastr
                toastr.options = {
                    "closeButton": true,
                    "debug": false,
                    "newestOnTop": true,
                    "progressBar": true,
                    "positionClass": "toast-top-right",
                    "preventDuplicates": false,
                    "onclick": null,
                    "showDuration": "300",
                    "hideDuration": "1000",
                    "timeOut": "5000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                };

                // Gọi toastr để hiển thị thông báo
                if (toastSuccess === 'true') {
                    toastr.success(toastMessage);
                } else {
                    toastr.error(toastMessage);
                }
            };
        </script>
        <?php
        unset($_SESSION['toastMessage']);
        unset($_SESSION['toastSuccess']);
        ?>
    <?php endif; ?>

    <script>
        // Toggle dropdown menu visibility
        function toggleUserMenu() {
            const menu = document.getElementById('userMenu');
            if (menu.classList.contains('hidden')) {
                menu.classList.remove('hidden');
            } else {
                menu.classList.add('hidden');
            }
        }

        // Đóng menu khi click ra ngoài
        document.addEventListener('click', function(event) {
            const menu = document.getElementById('userMenu');
            const button = document.getElementById('userMenuButton');
            if (!menu.contains(event.target) && !button.contains(event.target)) {
                menu.classList.add('hidden');
            }
        });
    </script>
</body>

</html>