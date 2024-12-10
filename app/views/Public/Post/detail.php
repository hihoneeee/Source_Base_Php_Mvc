<div class="site-cover site-cover-sm same-height overlay single-page"
    style="background-image: url('/App/Public/Client/images/hero_5.jpg');">
    <div class="container">
        <div class="row same-height justify-content-center">
            <div class="col-md-6">
                <div class="post-entry text-center">
                    <h1 class="mb-4"><?= $postDetail->dataDetail['title'] ?></h1>
                    <div class="post-meta align-items-center text-center">
                        <figure class="author-figure mb-0 me-3 d-inline-block">
                            <img src="/App/Public/Uploads/User/<?= $postDetail->dataUser['avatar'] ?>"
                                alt="Author Avatar" class="img-fluid">
                        </figure>
                        <span class="d-inline-block mt-1">By <?= $postDetail->dataUser['fullName'] ?></span>
                        <span>&nbsp;-&nbsp; <?= date('F j, Y', strtotime($postDetail->updated_at)) ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<section class="section">
    <div class="container">
        <div class="row blog-entries element-animate">
            <div class="col-md-12 col-lg-8 main-content">
                <div class="post-content-body">
                    <p><?= nl2br($postDetail->dataDetail['content']) ?></p>
                </div>
                <div class="pt-5">
                    <p>Category: <a href="/danh-muc/"><?= $postDetail->dataCategory['title'] ?></a></p>
                </div>
                <div class="pt-5 comment-wrap">
                    <h3 class="mb-5 heading">6 Comments</h3>
                    <ul class="comment-list">
                        <li class="comment">
                            <div class="vcard">
                                <img src="images/person_1.jpg" alt="Image placeholder">
                            </div>
                            <div class="comment-body">
                                <h3>Jean Doe</h3>
                                <div class="meta">January 9, 2018 at 2:21pm</div>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Pariatur quidem laborum
                                    necessitatibus, ipsam impedit vitae autem, eum officia, fugiat saepe enim sapiente
                                    iste iure! Quam voluptas earum impedit necessitatibus, nihil?</p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="col-md-12 col-lg-4 sidebar">
                <div class="sidebar-box">
                    <div class="bio text-center">
                        <img src="/App/Public/Uploads/User/<?= $postDetail->dataUser['avatar'] ?>"
                            alt="Image Placeholder" class="img-fluid mb-3">
                        <div class="bio-body">
                            <h2><?= $postDetail->dataUser['fullName'] ?></h2>
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