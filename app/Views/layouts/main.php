<!-- app/Views/layouts/main.php -->
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Tracer Study UMAHA</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="<?= base_url('/assets/img/logo-umaha-192.png') ?>" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Nunito&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body {
            font-family: 'Nunito', sans-serif;
            cursor: none;
            background: #f7f7f7;
        }

        .custom-cursor {
            position: fixed;
            top: 0;
            left: 0;
            width: 40px;
            height: 40px;
            border: 2px solid #2db598;
            border-radius: 50%;
            pointer-events: none;
            transform: translate(-50%, -50%);
            z-index: 9999;
        }

        .custom-cursor::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 8px;
            height: 8px;
            background-color: #2db598;
            border-radius: 50%;
            transform: translate(-50%, -50%);
        }

        .card-hover {
            transition: transform 0.2s;
        }

        .card-hover:hover {
            transform: scale(1.02);
        }

        /* Header sticky shrink */
        .sticky-header {
            position: sticky;
            top: 0;
            z-index: 1000;
            background: #fff;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        /* Logo miring kiri */
        .ribbon {
            background-color: #2bbbad;
            color: white;
            font-weight: 600;
            font-size: 20px;
            padding: 55px 30px;
            clip-path: polygon(0 0, 100% 0, 95% 100%, 0% 100%);
            display: inline-block;
            white-space: nowrap;
        }

        .ribbon-wrapper {
            min-width: 50%;
            margin-left: -2rem;
            height: auto;
            /* biar fleksibel */
        }

        .ribbon-back {
            position: absolute;
            top: 10px;
            left: 0px;
            background-color: #2bbbad;
            height: 100%;
            width: 100%;
            clip-path: polygon(0 10%, 100% 10%, 96% 100%, 0% 100%);
            z-index: 0;
        }

        .ribbon-front {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            padding: 16px 40px;
            clip-path: polygon(0 0, 100% 0, 95% 100%, 0% 100%);
            background-color: #26a69a;
            color: white;
            font-weight: 600;
            font-size: 20px;
        }

        /* Header row disamakan tinggi dengan isi */
        .header-row {
            display: flex;
            justify-content: space-between;
            align-items: stretch;
            /* biar ngikut tinggi konten */
            padding: 0 20px;
            min-height: auto;
            /* biarkan isi yang menentukan tinggi */
        }

        /* Sosmed ikon */
        .sosmed-icons a {
            color: #444;
            margin-left: 12px;
            font-size: 18px;
            text-decoration: none;
        }

        .sticky-header {
            border-bottom: 1px solid #e0e0e0;
        }

        .table-modern {
            border-collapse: separate;
            border-spacing: 0;
            overflow: hidden;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.03);
        }

        .table-modern thead {
            background: linear-gradient(90deg, #198754, #2db598);
            color: white;
            font-weight: 600;
            font-size: 14px;
        }

        .table-modern th,
        .table-modern td {
            vertical-align: middle;
            padding: 12px;
            font-size: 14px;
            text-align: center;
        }

        .table-modern tbody tr {
            background-color: #fff;
            transition: all 0.3s ease-in-out;
        }

        .table-modern tbody tr:hover {
            background-color: #f1fdf7;
        }

        .animate-fade {
            animation: fadeInUp 0.5s ease forwards;
            opacity: 0;
            transform: translateY(10px);
        }

        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 768px) {
            body {
                cursor: auto !important;
            }

            .custom-cursor {
                display: none !important;
            }
        }
    </style>
</head>

<body>
    <div class="custom-cursor" id="cursor"></div>

    <?= $this->include('partials/header_main') ?>



    <?= $this->renderSection('content') ?>

    <!-- Modal Login -->
    <div class="modal fade" id="loginModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form id="loginForm" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Halaman Login</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" name="email" required>
                    <label class="form-label mt-2">Password</label>
                    <input type="password" class="form-control" name="password" required>
                    <div id="loginError" class="text-danger mt-2 small"></div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success w-100" type="submit">MASUK</button>
                </div>
            </form>
        </div>
    </div>


    <?= $this->include('partials/footer_main') ?>

    <!-- JS Login -->
    <script>
        const cursor = document.getElementById('cursor');
        document.addEventListener('mousemove', e => {
            cursor.style.top = `${e.clientY}px`;
            cursor.style.left = `${e.clientX}px`;
        });

        // Hanya aktif di device dengan pointer "fine" (biasanya mouse/trackpad)
        if (window.matchMedia("(pointer: fine)").matches) {
            const cursor = document.getElementById('cursor');
            document.addEventListener('mousemove', e => {
                cursor.style.top = `${e.clientY}px`;
                cursor.style.left = `${e.clientX}px`;
            });
        }
    </script>
    <script>
        document.querySelector('#loginForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const form = this;
            const data = new FormData(form);

            fetch('<?= base_url('auth/login') ?>', {
                    method: 'POST',
                    body: data
                })
                .then(res => res.json())
                .then(res => {
                    if (res.success) {
                        window.location.href = res.redirect;
                    } else {
                        document.getElementById('loginError').textContent = res.message;
                    }
                })
                .catch(() => {
                    document.getElementById('loginError').textContent = 'Terjadi kesalahan saat login.';
                });
        });

        const backToTop = document.getElementById('backToTop');
        window.addEventListener('scroll', () => {
            backToTop.style.display = window.scrollY > 300 ? 'block' : 'none';
        });
        backToTop.addEventListener('click', () => {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>