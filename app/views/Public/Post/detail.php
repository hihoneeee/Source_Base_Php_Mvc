<div class="site-cover site-cover-sm same-height overlay single-page"
    style="background-image: url('/App/Public/Client/images/hero_5.jpg');">
    <div class="container">
        <div class="row same-height justify-content-center">
            <div class="col-md-6">
                <div class="post-entry text-center">
                    <h1 class="mb-4 w-100"><?= $postDetail->dataDetail['title'] ?></h1>
                    <div class="post-meta align-items-center text-center">
                        <figure class="author-figure mb-0 me-3 d-inline-block">
                            <img src="/App/Public/Uploads/User/<?= $postDetail->dataUser['avatar'] ?>"
                                alt="Author Avatar" class="rounded-circle"
                                style="width: 40px; height: 40px; object-fit: cover;">
                        </figure>
                        <span class="d-inline-block mt-1">By <?= $postDetail->dataUser['fullName'] ?></span>
                        <span>&nbsp;-&nbsp; <?= date('F j, Y', strtotime($postDetail->updated_at)) ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<section class="section py-3">
    <div class="container">
        <div class="row blog-entries element-animate">
            <div class="col-md-12 col-lg-8 main-content">
                <div class="post-content-body">
                    <p><?= nl2br($postDetail->dataDetail['content']) ?></p>
                </div>
                <div>
                    <p>Danh mục: <a href="/danh-muc/"><?= $postDetail->dataCategory['title'] ?></a></p>
                </div>
                <?php if (!empty($_COOKIE['testToken'])): ?>
                <div class="container mt-4">
                    <div class="d-flex align-items-start">
                        <!-- Avatar -->
                        <div class="me-3">
                            <img src="/App/Public/Uploads/User/<?= $_SESSION['user_info']->avatar ?>" alt="User Avatar"
                                class="rounded-circle" style="width: 50px; height: 50px; object-fit: cover;">
                        </div>
                        <!-- Comment Form -->
                        <div class="flex-grow-1">
                            <form action="/comment/create" method="post">
                                <input type="hidden" name="postDetail_id" id="postDetail_id"
                                    value="<?= htmlspecialchars($postDetail->dataDetail['id']) ?>">
                                <div class="mb-3">
                                    <textarea name="content" id="content" class="form-control" rows="3"
                                        placeholder="Nhập bình luận của bạn..."></textarea>
                                </div>
                                <?php if (!empty($errors['content'])): ?>
                                <p class="text-red-500 text-sm">
                                    <?php echo htmlspecialchars($errors['content']); ?>
                                </p>
                                <?php endif; ?>
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary">Gửi</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <?php else: ?>
                <p>Để binh luận hãy <a href="/dang-nhap">Đăng nhập</a> ngay!</p>
                <?php endif; ?>

                <div class="pt-5 comment-wrap">
                    <h3 class="mb-5 heading"><?= $totalComments ?> Bình luận</h3>
                    <?php if (!empty($commentList)): ?>
                    <?php foreach ($commentList as $comment): ?>
                    <ul class="comment-list">
                        <li class="comment d-flex align-items-start mb-4">
                            <!-- Avatar -->
                            <div class="vcard me-3">
                                <img src="/App/Public/Uploads/User/<?= $comment->avatar ?>" alt="User Avatar"
                                    class="rounded-circle" style="width: 50px; height: 50px; object-fit: cover;">
                            </div>

                            <!-- Nội dung bình luận -->
                            <div class="comment-body flex-grow-1">
                                <h5 class="fw-bold mb-1"><?= $comment->fullName ?></h5>
                                <p class="mb-2"><?= $comment->content ?></p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <!-- Ngày bình luận và nút xóa -->
                                    <span class="text-muted small">
                                        <?= date('d M, Y', strtotime($comment->created_at)) ?>
                                        <?php if (isset($_SESSION['user_info']) && $_SESSION['user_info']->id == $comment->user_id): ?>
                                        |
                                        <a href="/comment/delete/<?= $comment->id ?>"
                                            class="text-decoration-none text-danger-hover delete-link">
                                            xóa
                                        </a>
                                        <?php endif; ?>
                                    </span>
                                </div>
                            </div>
                        </li>
                    </ul>
                    <?php endforeach; ?>
                    <?php else: ?>
                    <p>Không có bình luận nào trong bài viết này.</p>
                    <?php endif; ?>
                </div>



            </div>

            <div class="col-md-12 col-lg-4 sidebar">
                <div class="sidebar-box">
                    <div class="bio text-center">
                        <img src="/App/Public/Uploads/User/<?= $postDetail->dataUser['avatar'] ?>"
                            alt="Image Placeholder" class="rounded-circle mb-3"
                            style="width: 100px; height: 100px; object-fit: cover;">
                        <div class="bio-body">
                            <h2>Tác giả: <?= $postDetail->dataUser['fullName'] ?></h2>
                            <p>Email: <?= $postDetail->dataUser['email'] ?></p>
                            <p>Phone: <?= $postDetail->dataUser['phone'] ?></p>
                            <p><a href="#" class="btn btn-primary btn-sm rounded px-2 py-2">Xem chi tiết</a></p>
                            <p class="social">
                                <a href="#" class="p-2"><span class="icon-facebook"></span></a>
                                <a href="#" class="p-2"><span class="icon-instagram"></span></a>
                                <a href="#" class="p-2"><span class="icon-twitter"></span></a>
                            </p>
                        </div>
                    </div>
                </div>


                <div class="sidebar-box">
                    <h3 class="heading">Danh mục</h3>
                    <ul class="categories">
                        <?php foreach ($categories as $category): ?>
                        <li>
                            <a href="/danh-muc/<?php echo htmlspecialchars($category->id); ?>">
                                <?php echo htmlspecialchars($category->title); ?>
                                <span>(<?php echo $category->postCount; ?>)</span>
                            </a>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
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
</section>

<section class="section posts-entry posts-entry-sm bg-light">
    <div class="container">
        <div class="row mb-4">
            <div class="col-12 text-uppercase text-black">Bài viết liên quan</div>
        </div>
        <div class="row">
            <?php foreach ($getPostByCategory as $relatedPost): ?>
            <div class="col-md-6 col-lg-3">
                <div class="blog-entry">
                    <a href="/tin-tuc/<?= $relatedPost->id ?>" class="img-link">
                        <img src="/App/Public/Uploads/Post/<?= $relatedPost->avatar ?>" alt="Image" class="img-fluid">
                    </a>
                    <span class="date"><?= date('M. jS, Y', strtotime($relatedPost->updated_at)) ?></span>
                    <h2><a href="/tin-tuc/<?= $relatedPost->id ?>"><?= $relatedPost->title ?></a></h2>
                    <p><?= substr(strip_tags($relatedPost->meta), 0, 100) ?>...</p>
                    <p><a href="/tin-tuc/<?= $relatedPost->id ?>" class="read-more">Đọc tiếp</a></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<style>
.delete-link {
    color: inherit;
    /* Mặc định theo màu chữ xung quanh */
    text-decoration: none;
    /* Không gạch chân mặc định */
    font-size: 0.9rem;
    /* Thu nhỏ chữ một chút */
}

.delete-link:hover {
    color: red;
    /* Đổi sang màu đỏ khi hover */
    text-decoration: underline;
    /* Gạch chân khi hover */
}
</style>