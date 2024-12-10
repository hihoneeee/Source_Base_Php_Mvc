<div class="d-flex justify-content-center align-items-center vh-100">
    <div class="card shadow border-0" style="max-width: 500px; width: 100%;">
        <div class="card-body p-4">
            <h1 class="text-center mb-4 text-primary fw-bold" id="formTitle">
                Chào mừng bạn!
            </h1>
            <form action="/verify-register" method="post">
                <!-- Form Đăng Ký -->
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="lastName" class="form-label fw-semibold">Họ đệm</label>
                        <input type="text" name="last_name" id="lastName" class="form-control"
                            placeholder="Nhập họ đệm...">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="firstName" class="form-label fw-semibold">Tên</label>
                        <input type="text" name="first_name" id="firstName" class="form-control"
                            placeholder="Nhập tên...">
                    </div>
                </div>
                <div class="mb-3">
                    <label for="regEmail" class="form-label fw-semibold">Email</label>
                    <input type="email" name="email" id="regEmail" class="form-control" placeholder="Nhập email...">
                </div>
                <div class="mb-3">
                    <label for="regPassword" class="form-label fw-semibold">Mật khẩu</label>
                    <input type="password" name="password" id="regPassword" class="form-control" placeholder="••••••••">
                </div>
                <button type="submit" class="btn btn-success w-100">Đăng ký</button>
                <p class="text-center mt-3">
                    Bạn đã có tài khoản? <a href="#" id="toggleToLogin" class="text-success fw-bold">Đăng nhập ngay!</a>
                </p>
            </form>
        </div>
    </div>
</div>