<div class="d-flex justify-content-center align-items-center vh-100">
    <div class="card shadow border-0" style="max-width: 500px; width: 100%;">
        <div class="card-body p-4">
            <h1 class="text-center mb-4 text-primary fw-bold" id="formTitle">
                Quên Mật Khẩu
            </h1>
            <form action="/forgot-password-verify" method="post">
                <div class="mb-3">
                    <label for="email" class="form-label fw-semibold">Email</label>
                    <input type="email" name="email" id="email" class="form-control" placeholder="Nhập email...">
                    <?php if (!empty($errors['email'])): ?>
                    <p class="text-danger"><?php echo htmlspecialchars($errors['email']); ?></p>
                    <?php endif; ?>
                </div>
                <button type="submit" class="btn btn-primary w-100">Quên</button>
                <p class="text-center mt-3">
                    Quay lại? <a href="/dang-ky" id="toggleToRegister" class="text-primary fw-bold">Đăng nhập!</a>
                </p>
            </form>
        </div>
    </div>
</div>