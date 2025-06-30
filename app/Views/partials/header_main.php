<header class="sticky-header shadow-sm bg-white">
    <div class="container-fluid py-3">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center text-center text-md-start gap-3">
            <!-- Logo / Brand -->
            <div class="d-flex align-items-center justify-content-center justify-content-md-start flex-wrap flex-grow-1">
                <img src="<?= base_url('/assets/img/logo-umaha-192.png') ?>" alt="UMAHA Logo" width="40" height="40" class="me-2 mb-2 mb-md-0">
                <div>
                    <a href="<?= base_url() ?>" class="fw-bold text-success fs-5 mb-0 text-decoration-none d-block">
                        Tracer Study UMAHA
                    </a>
                    <small class="text-muted">Universitas Maarif Hasyim Latif</small>
                </div>
            </div>

            <!-- Sosial Media Icons + Auth -->
            <div class="d-flex flex-wrap justify-content-center justify-content-md-end align-items-center gap-3 fs-5">
                <a href="#" class="text-secondary"><i class="bi bi-instagram"></i></a>
                <a href="#" class="text-secondary"><i class="bi bi-facebook"></i></a>
                <a href="#" class="text-secondary"><i class="bi bi-twitter-x"></i></a>

                <?php if (session()->get('logged_in')): ?>
                    <span class="text-success fw-semibold small"><?= session()->get('email') ?></span>
                    <a href="<?= base_url('alumni/dashboard') ?>" class="btn btn-outline-primary btn-sm">Dashboard</a>
                    <a href="<?= base_url('auth/logout') ?>" class="btn btn-outline-danger btn-sm">Logout</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</header>