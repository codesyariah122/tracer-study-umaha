<!DOCTYPE html>
<html>

<head>
    <title>Login Admin Tracer UMAHA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container mt-5">
        <div class="col-md-4 mx-auto card p-4 shadow-sm">
            <a href="<?= base_url('/') ?>">
                <h4 class="text-center mb-3">
                    <img src="<?= base_url('/assets/img/logo-umaha.png') ?>" alt="">
                </h4>
            </a>
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
            <?php endif ?>
            <form action="<?= base_url('admin/login') ?>" method="post">
                <div class="mb-3">
                    <label>Username</label>
                    <input type="text" name="username" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <button class="btn btn-primary w-100">Login</button>
            </form>
        </div>
    </div>
</body>

</html>