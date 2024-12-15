<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Untree.co">
    <link rel="shortcut icon" href="favicon.png">

    <meta name="description" content="" />
    <meta name="keywords" content="bootstrap, bootstrap5" />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">

    <link rel="stylesheet" href="/App/Public/Client/fonts/icomoon/style.css">
    <link rel="stylesheet" href="/App/Public/Client/fonts/flaticon/font/flaticon.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">

    <link rel="stylesheet" href="/App/Public/Client/css/tiny-slider.css">
    <link rel="stylesheet" href="/App/Public/Client/css/aos.css">
    <link rel="stylesheet" href="/App/Public/Client/css/glightbox.min.css">
    <link rel="stylesheet" href="/App/Public/Client/css/style.css">

    <link rel="stylesheet" href="/App/Public/Client/css/flatpickr.min.css">


    <title>Blogy &mdash; Free Bootstrap 5 Website Template by Untree.co</title>
</head>

<body>

    <div class="site-mobile-menu site-navbar-target">
        <div class="site-mobile-menu-header">
            <div class="site-mobile-menu-close">
                <span class="icofont-close js-menu-toggle"></span>
            </div>
        </div>
        <div class="site-mobile-menu-body"></div>
    </div>

    <nav class="site-nav">
        <div class="container">
            <div class="menu-bg-wrap">
                <div class="site-navigation">
                    <div class="row g-0 align-items-center">
                        <div class="col-2">
                            <a href="/" class="logo m-0 float-start">Blogy<span class="text-primary">.Com</span></a>
                        </div>
                        <div class="col-8 text-center">
                            <ul class="js-clone-nav d-none d-lg-inline-block text-start site-menu mx-auto">
                                <li class="<?php echo $_SERVER['REQUEST_URI'] === '/' ? 'active' : ''; ?>">
                                    <a href="/">Trang Chủ</a>
                                </li>
                                <?php if (isset($categories)) { ?>
                                <?php foreach ($categories as $category): ?>
                                <?php $categoryUrl = "/danh-muc/" . $category->id; ?>
                                <li class="<?php echo $_SERVER['REQUEST_URI'] === $categoryUrl ? 'active' : ''; ?>">
                                    <a href="<?php echo $categoryUrl; ?>">
                                        <?php echo htmlspecialchars($category->title); ?>
                                    </a>
                                </li>
                                <?php endforeach; ?>
                                <?php } ?>
                            </ul>
                        </div>
                        <div class="col-2 text-end d-flex gap-2 align-items-center">
                            <a href="#" class="search-btn" id="searchIcon">
                                <i class="bi bi-search"></i>
                            </a>
                            <?php if (!isset($_COOKIE['TestToken'])): ?>
                            <a href="/dang-nhap" class="btn btn-outline-white py-2">Đăng nhập</a>
                            <?php else: ?>
                            <div class="dropdown">
                                <a href="#"
                                    class="btn btn-outline-white py-2 dropdown-toggle d-flex align-items-center gap-2"
                                    id="userMenu" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-person-circle"></i>
                                    <span><?php echo htmlspecialchars($_SESSION['user_info']->last_name); ?></span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end user-dropdown-menu"
                                    aria-labelledby="userMenu">
                                    <li><a class="dropdown-item"
                                            href="/trang-ca-nhan/<?= ($_SESSION['user_info']->id); ?>">Trang
                                            cá nhân</a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item" href="/dang-xuat">Đăng xuất</a></li>
                                </ul>
                            </div>

                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>


    <!-- Search Modal -->
    <div id="searchModal" class="search-modal">
        <div class="search-modal-content">
            <form action="/search" method="get">
                <input type="text" name="q" class="form-control" placeholder="Tìm kiếm gì đó...">
                <button type="submit" class="btn btn-primary mt-3 w-100">Tìm kiếm</button>
            </form>
        </div>
    </div>


    <?php echo $content; ?>


    <footer class="site-footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <div class="widget">
                        <h3 class="mb-4">VỀ CHÚNG TÔI</h3>
                        <p>Xa xa, đằng sau những ngọn núi chữ, xa khỏi đất nước Vokalia và Consonantia, có những văn bản
                            mù.</p>
                    </div> <!-- /.widget -->
                    <div class="widget">
                        <h3>MẠNG XÃ HỘI</h3>
                        <ul class="list-unstyled social">
                            <li><a href="#"><span class="icon-instagram"></span></a></li>
                            <li><a href="#"><span class="icon-twitter"></span></a></li>
                            <li><a href="#"><span class="icon-facebook"></span></a></li>
                            <li><a href="#"><span class="icon-linkedin"></span></a></li>
                            <li><a href="#"><span class="icon-pinterest"></span></a></li>
                            <li><a href="#"><span class="icon-dribbble"></span></a></li>
                        </ul>
                    </div> <!-- /.widget -->
                </div> <!-- /.col-lg-4 -->
                <div class="col-lg-4 ps-lg-5">
                    <div class="widget">
                        <h3 class="mb-4">Doanh nghiệp</h3>
                        <ul class="list-unstyled float-start links">
                            <li><a href="#">Về chúng tôi</a></li>
                            <li><a href="#">Dịch vụ</a></li>
                            <li><a href="#">Tầm nhìn</a></li>
                            <li><a href="#">Nhiệm vụ</a></li>
                            <li><a href="#">Điều khoản</a></li>
                            <li><a href="#">Riêng tư</a></li>
                        </ul>
                        <ul class="list-unstyled float-start links">
                            <li><a href="#">Đối tác</a></li>
                            <li><a href="#">Kinh doanh</a></li>
                            <li><a href="#">Nghề nghiệp</a></li>
                            <li><a href="#">Tin tức</a></li>
                            <li><a href="#">Câu hỏi</a></li>
                            <li><a href="#">Sáng tạo</a></li>
                        </ul>
                    </div> <!-- /.widget -->
                </div> <!-- /.col-lg-4 -->
            </div> <!-- /.row -->
        </div>
    </footer>

    <!-- Preloader -->
    <div id="overlayer"></div>
    <div class="loader">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>


    <script src="/App/Public/Client/js/bootstrap.bundle.min.js"></script>
    <script src="/App/Public/Client/js/tiny-slider.js"></script>

    <script src="/App/Public/Client/js/flatpickr.min.js"></script>


    <script src="/App/Public/Client/js/aos.js"></script>
    <script src="/App/Public/Client/js/glightbox.min.js"></script>
    <script src="/App/Public/Client/js/navbar.js"></script>
    <script src="/App/Public/Client/js/counter.js"></script>
    <script src="/App/Public/Client/js/custom.js"></script>


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

    <style>
    .toast-success {
        background-color: #28a745 !important;
        /* Màu xanh cho thông báo thành công */
        color: #ffffff !important;
    }

    .toast-error {
        background-color: #dc3545 !important;
        /* Màu đỏ cho thông báo lỗi */
        color: #ffffff !important;
    }

    /* Search modal styles */
    .search-modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.8);
        z-index: 1050;
        justify-content: center;
        align-items: center;
    }

    .search-modal-content {
        background: #fff;
        padding: 20px;
        border-radius: 8px;
        text-align: center;
        max-width: 400px;
        width: 100%;
    }

    .search-modal.active {
        display: flex;
    }

    /* Điều chỉnh kiểu nút tìm kiếm */
    .search-btn {
        background-color: transparent;
        border: 1px solid #fff;
        font-weight: 600;
        color: #fff;
        width: 2rem;
        height: 2rem;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        /* Hình tròn */
        transition: all 0.3s ease;
    }

    .search-btn:hover {
        background-color: #fff;
    }

    /* Kích thước icon */
    .search-btn i {
        font-size: .8rem;
    }
    </style>
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        const searchIcon = document.getElementById("searchIcon");
        const searchModal = document.getElementById("searchModal");

        searchIcon.addEventListener("click", function(e) {
            e.preventDefault();
            searchModal.classList.add("active");
        });

        searchModal.addEventListener("click", function(e) {
            if (e.target === this) {
                searchModal.classList.remove("active");
            }
        });
    });
    </script>
</body>

</html>