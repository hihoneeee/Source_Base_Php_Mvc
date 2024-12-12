    <div class="profile-header">
        <div class="container position-relative">
            <img src="/App/Public/Uploads/User/<?= $user->avatar ?>" alt="Writer Avatar">
            <h1><?= $user->first_name ?> <?= $user->last_name ?></h1>
            <p class="text-muted">A passionate writer who loves sharing knowledge about technology and lifestyle.</p>
            <p><strong>Phone:</strong> <?= $user->phone ?></p>
            <p><strong>Email:</strong> <?= $user->email ?></p>
            <p><strong>Tác giả này có <?= $totalPost ?> bài viết</strong></p>

            <?php if ($_SESSION['user_info']->id == $user->id): ?>
                <button class="btn text-black btn-light position-absolute top-0 end-0 mt-3 me-3" id="editProfileBtn">
                    <i class="bi bi-gear" style="font-size: large;"></i>
                </button>

                <div id="editProfileForm" class="d-none">
                    <form method="POST" action="/user/update">
                        <div class="form-group">
                            <label for="first_name">First Name</label>
                            <input type="text" id="first_name" name="first_name" class="form-control"
                                value="<?= $user->first_name ?>">
                        </div>
                        <div class="form-group">
                            <label for="last_name">Last Name</label>
                            <input type="text" id="last_name" name="last_name" class="form-control"
                                value="<?= $user->last_name ?>">
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="text" id="phone" name="phone" class="form-control" value="<?= $user->phone ?>">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" class="form-control" value="<?= $user->email ?>">
                        </div>
                        <button type="submit" class="btn btn-primary mt-3">Thay đổi</button>
                    </form>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="container my-5">
        <h2 class="mb-4">Bài viết</h2>
        <div class="row">
            <?php foreach ($user->dataPosts as $post): ?>
                <div class="col-md-4 d-flex align-items-stretch">
                    <div class="card blog-card">
                        <a href="/tin-tuc/<?= $post->id ?>">
                            <img src="/App/Public/Uploads/Post/<?= $post->avatar ?>" class="card-img-top" alt="Blog Image">
                        </a>
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">
                                <a href="/tin-tuc/<?= $post->id ?>">
                                    <?= mb_strimwidth($post->title, 0, 50, '...') ?>
                                    <!-- Giới hạn tiêu đề -->
                                </a>
                            </h5>
                            <p class="blog-meta">
                                Danh mục: <a href="/danh-muc/<?= $post->categoryId ?>"
                                    class="text-decoration-none text-danger-hover delete-link">
                                    <?= $post->categoryTitle ?>
                                </a>
                                | Ngày viết: <?= date('M. jS, Y', strtotime($post->created_at)) ?>
                            </p>
                            <p class="card-text">
                                <?= mb_strimwidth(strip_tags($post->meta), 0, 120, '...') ?>
                                <!-- Giới hạn đoạn mô tả -->
                            </p>
                            <a href="/tin-tuc/<?= $post->id ?>" class="btn btn-primary mt-auto">Đọc thêm</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>

        </div>
    </div>
    <style>
        .profile-header {
            background-color: #f8f9fa;
            padding: 30px 0;
            text-align: center;
        }

        .profile-header img {
            border-radius: 50%;
            width: 150px;
            height: 150px;
            object-fit: cover;
            border: 4px solid #fff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .profile-header h1 {
            font-size: 2.5rem;
            margin-top: 15px;
        }

        .blog-card img {
            height: 200px;
            object-fit: cover;
        }

        #editProfileForm {
            position: absolute;
            top: 70px;
            right: 20px;
            background: white;
            padding: 20px;
            border: 1px solid #ddd;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        #editProfileBtn {
            opacity: 1;
            /* Bỏ mọi hiệu ứng làm mờ */
            visibility: visible;
        }

        /* Giới hạn chiều cao của tiêu đề và mô tả */
        .blog-card .card-title a {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            /* Giới hạn 2 dòng */
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: normal;
        }

        .blog-card .card-text {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            /* Giới hạn 3 dòng */
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: normal;
        }

        /* Đảm bảo chiều cao thẻ bài viết */
        .card.blog-card {
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        /* Căn đều nút "Đọc thêm" */
        .card.blog-card .btn {
            margin-top: auto;
        }

        /* Phong cách ban đầu của nút */
        .card.blog-card .btn {
            background-color: #214252;
            /* Màu nền */
            color: #fff;
            /* Màu chữ */
            border: none;
            /* Bỏ viền */
            transition: all 0.3s ease;
            /* Hiệu ứng mượt */
        }

        /* Hiệu ứng khi hover vào nút */
        .card.blog-card .btn:hover {
            background-color: #457b9d;
            /* Đổi màu nền */
            color: #f1faee;
            /* Đổi màu chữ */
            transform: translateY(-3px);
            /* Đẩy nút lên */
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            /* Tạo bóng */
        }

        /* Hiệu ứng khi nhấn vào nút */
        .card.blog-card .btn:active {
            transform: translateY(0);
            /* Quay lại vị trí ban đầu */
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.2);
            /* Giảm bóng */
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const editProfileBtn = document.getElementById('editProfileBtn');
            const editProfileForm = document.getElementById('editProfileForm');

            if (editProfileBtn && editProfileForm) {
                editProfileBtn.addEventListener('click', () => {
                    editProfileForm.classList.toggle('d-none');
                });
            }
        });
    </script>