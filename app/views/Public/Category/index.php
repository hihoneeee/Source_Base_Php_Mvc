<?php

use App\Helpers\PaginationHelper;

?>
<div class="site-cover site-cover-sm same-height overlay single-page"
    style="background-image: url('/App/Public/Client/images/hero_5.jpg');">
    <div class="container">
        <div class="row same-height justify-content-center">
            <div class="col-md-6">
                <div class="post-entry text-center">
                    <h1 class="mb-4">Danh mục: <?php echo htmlspecialchars($category->title); ?></h1>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="section search-result-wrap">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="heading">Danh Mục: <?php echo htmlspecialchars($category->title); ?></div>
                <?php
                $description = strip_tags($category->description); // Loại bỏ thẻ HTML
                $description = str_replace('&nbsp;', ' ', $description); // Thay thế &nbsp;
                $description = trim($description); // Loại bỏ khoảng trắng thừa
                ?>
                <p class="category-description"><?php echo htmlspecialchars($category->description); ?></p>
            </div>
        </div>
        <div class="row posts-entry">
            <div class="col-lg-8">
                <?php if (!empty($category->dataPost)): ?>
                <?php foreach ($category->dataPost as $post): ?>
                <div class="blog-entry d-flex blog-entry-search-item">
                    <a href="/tin-tuc/<?php echo htmlspecialchars($post->id); ?>" class="img-link me-4">
                        <img src="/App/Public/Uploads/Post/<?php echo htmlspecialchars($post->avatar); ?>" alt="Image"
                            class="img-fluid">
                    </a>
                    <div>
                        <span class="date">
                            <?php echo htmlspecialchars(date('d M, Y', strtotime($post->updated_at))); ?> &bullet;
                            <a href="#"><?php echo htmlspecialchars($post->fullName); ?></a>
                        </span>
                        <h2>
                            <a
                                href="/tin-tuc/<?php echo htmlspecialchars($post->id); ?>"><?php echo htmlspecialchars($post->postTitle); ?></a>
                        </h2>
                        <p><?= strip_tags($post->meta) ?></p>
                        <p><a href="/tin-tuc/<?php echo htmlspecialchars($post->id); ?>"
                                class="btn btn-sm btn-outline-primary">Xem thêm</a></p>
                    </div>
                </div>
                <?php endforeach; ?>
                <?php else: ?>
                <p>Không có bài viết nào trong danh mục này.</p>
                <?php endif; ?>

                <?php
                PaginationHelper::renderPublic($paginationDTO);
                ?>

            </div>

            <div class="col-lg-4 sidebar">
                <div class="sidebar-box">
                    <h3 class="heading">Bài viết nổi bật</h3>
                    <div class="post-entry-sidebar">
                        <ul>
                            <?php foreach ($postRandom as $post): ?>
                            <li>
                                <a href="">
                                    <img src="/App/Public/Uploads/Post/<?php echo htmlspecialchars($post->avatar); ?>"
                                        alt="Image placeholder" class="me-4 rounded">
                                    <div class="text">
                                        <h4><?php echo htmlspecialchars($post->title); ?></h4>
                                        <div class="post-meta">
                                            <span class="mr-2"><?php echo htmlspecialchars($post->updated_at); ?></span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
                <!-- END sidebar-box -->

                <div class="sidebar-box">
                    <h3 class="heading">Danh mục</h3>
                    <ul class="categories">
                        <?php foreach ($categories as $category): ?>
                        <li>
                            <a href="#">
                                <?php echo htmlspecialchars($category->title); ?>
                                <span>(<?php echo $category->postCount; ?>)</span>
                            </a>
                        </li>
                        <?php endforeach; ?>

                    </ul>
                </div>
                <!-- END sidebar-box -->

                <div class="sidebar-box">
                    <h3 class="heading">Thẻ</h3>
                    <ul class="tags">
                        <li><a href="#">Du lịch</a></li>
                        <li><a href="#">Phiêu lưu</a></li>
                        <li><a href="#">Đồ ăn</a></li>
                        <li><a href="#">Cuộc sống</a></li>
                        <li><a href="#">Kinh doanh</a></li>
                        <li><a href="#">Tự do</a></li>
                    </ul>
                </div>

            </div>
        </div>
    </div>
</div>