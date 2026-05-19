<!-- app/Views/rekap_pengguna.php -->
<?= $this->extend('layouts/main') ?>

<?php
/** @var array $tahun_list */
/** @var array $rekap_prodi */
/** @var array $rekap_jenjang */
/** @var array $rekap_lembaga */
/** @var array $rekap_lulus */
/** @var array $rekap_wilayah */
/** @var array $rekap_terdaftar */
/** @var array $rekap_kondisi */
/** @var array $list */

/** @var string|null $filter_tahun */
/** @var string|null $filter_nama */
?>

<?= $this->section('content') ?>

<style>
    body {
        background: #f4f8f6;
    }

    .report-hero {
        position: relative;
        overflow: hidden;
        border-radius: 32px;
        background:
            linear-gradient(135deg,
                rgba(0, 102, 51, 0.96),
                rgba(0, 153, 102, 0.92)),
            url('https://pmb.umaha.ac.id/wp-content/uploads/2024/02/umaha.jpg');
        background-size: cover;
        background-position: center;
        padding: 70px 40px;
        color: white;
        box-shadow: 0 20px 45px rgba(0, 0, 0, .12);
    }

    .report-hero::before {
        content: '';
        position: absolute;
        width: 350px;
        height: 350px;
        border-radius: 50%;
        background: rgba(255, 255, 255, .06);
        top: -120px;
        right: -80px;
    }

    .report-hero::after {
        content: '';
        position: absolute;
        width: 240px;
        height: 240px;
        border-radius: 50%;
        background: rgba(255, 255, 255, .05);
        bottom: -80px;
        left: -50px;
    }

    .hero-content {
        position: relative;
        z-index: 2;
    }

    .hero-badge {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        background: rgba(255, 255, 255, .14);
        backdrop-filter: blur(10px);
        padding: 10px 18px;
        border-radius: 50px;
        font-size: 14px;
        font-weight: 600;
        margin-bottom: 24px;
    }

    .hero-title {
        font-size: 2.8rem;
        font-weight: 800;
        margin-bottom: 12px;
    }

    .hero-subtitle {
        opacity: .9;
        font-size: 1.05rem;
        line-height: 1.8;
        max-width: 800px;
    }

    .modern-card {
        border: none;
        border-radius: 28px;
        overflow: hidden;
        background: white;
        box-shadow: 0 10px 30px rgba(0, 0, 0, .05);
    }

    .filter-card {
        border-radius: 28px;
        background: white;
        padding: 30px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, .05);
    }

    .form-control,
    .form-select {
        border-radius: 16px;
        min-height: 52px;
        border: 1px solid #dbe5df;
        box-shadow: none !important;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #00a86b;
    }

    .btn-modern {
        background: linear-gradient(135deg, #006633, #00a86b);
        border: none;
        min-height: 52px;
        border-radius: 16px;
        color: white;
        font-weight: 700;
        transition: .3s ease;
    }

    .btn-modern:hover {
        transform: translateY(-2px);
        color: white;
    }

    .section-title {
        font-size: 26px;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 8px;
    }

    .section-subtitle {
        color: #64748b;
        font-size: 14px;
    }

    .chart-card {
        border: none;
        border-radius: 28px;
        overflow: hidden;
        background: white;
        box-shadow: 0 10px 30px rgba(0, 0, 0, .05);
        margin-bottom: 35px;
    }

    .chart-card-header {
        padding: 28px 30px 10px;
    }

    .chart-card-body {
        padding: 20px 30px 30px;
    }

    .modern-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0 14px;
    }

    .modern-table thead th {
        background: linear-gradient(135deg, #006633, #009966);
        color: white;
        border: none;
        padding: 16px;
        font-size: 14px;
        font-weight: 700;
    }

    .modern-table thead th:first-child {
        border-radius: 16px 0 0 16px;
    }

    .modern-table thead th:last-child {
        border-radius: 0 16px 16px 0;
    }

    .modern-table tbody tr {
        background: white;
        box-shadow: 0 5px 15px rgba(0, 0, 0, .03);
        transition: .3s ease;
    }

    .modern-table tbody tr:hover {
        transform: translateY(-2px);
        background: #f4fff9;
    }

    .modern-table tbody td {
        padding: 18px 16px;
        border: none;
        vertical-align: middle;
    }

    .modern-table tbody td:first-child {
        border-radius: 14px 0 0 14px;
    }

    .modern-table tbody td:last-child {
        border-radius: 0 14px 14px 0;
    }

    @media(max-width:768px) {

        .report-hero {
            padding: 50px 24px;
        }

        .hero-title {
            font-size: 2rem;
        }

        .chart-card-body {
            padding: 20px;
        }
    }
</style>

<div class="container py-5">
    <!-- HERO -->
    <div class="report-hero mb-5">

        <div class="hero-content">

            <div class="hero-badge">
                <i class="bi bi-bar-chart-fill"></i>
                Statistik Pengguna Lulusan
            </div>

            <h1 class="hero-title">
                Rekap Pengguna Lulusan UMAHA
            </h1>

            <p class="hero-subtitle">
                Visualisasi data statistik pengguna lulusan Universitas Maarif Hasyim Latif
                berdasarkan hasil tracer study alumni dan pengguna lulusan.
            </p>

        </div>

    </div>

    <form method="get" class="row g-3 mb-4">
        <div class="filter-card mb-5">

            <div class="row align-items-end g-4">

                <div class="col-md-4">

                    <label class="form-label fw-semibold">
                        Filter Tahun
                    </label>

                    <select name="tahun" class="form-select">
                        <option value="">Semua Tahun</option>
                        <?php foreach ($tahun_list as $t): ?>
                            <option value="<?= $t['tahun_merekrut'] ?>" <?= $filter_tahun == $t['tahun_merekrut'] ? 'selected' : '' ?>>
                                <?= $t['tahun_merekrut'] ?>
                            </option>
                        <?php endforeach ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Nama Perusahaan</label>
                    <input type="text" name="nama_perusahaan" value="<?= esc($filter_nama) ?>" class="form-control" placeholder="Ketik sebagian nama...">
                </div>
                <div class="col-md-4 align-self-end">
                    <button class="btn btn-modern w-100">
                        <i class="bi bi-funnel-fill me-2"></i>
                        Tampilkan Data
                    </button>
                </div>
            </div>
    </form>

    <div class="chart-card">
        <div class="chart-card-header">
            <h4 class="section-title">
                Persentase Berdasarkan Prodi
            </h4>

            <div class="section-subtitle">
                Distribusi data pengguna lulusan berdasarkan program studi.
            </div>
        </div>
        <div class="chart-card-body">
            <div class="row">
                <div class="col-md-6">
                    <!-- Tabel Data -->
                    <div class="table-responsive">
                        <table class="modern-table" id="table-prodi">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Program Studi</th>
                                    <th>Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($rekap_prodi as $i => $row): ?>
                                    <tr>
                                        <td><?= $i + 1 ?></td>
                                        <td><?= esc($row['nama_prodi']) ?></td>
                                        <td><?= $row['total'] ?></td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-6">
                    <!-- Chart -->
                    <div id="chart-prodi" style="height: 300px;"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Jenjang -->
    <div class="card mb-5 shadow-sm border-0 rounded-4 animate-fade">
        <div class="card-header bg-gradient-to-r from-success to-teal text-dark rounded-top-4 fw-semibold">
            Persentase Berdasarkan Jenjang
        </div>
        <div class="card-body bg-white">
            <div class="row">
                <div class="col-md-6">
                    <div class="table-responsive">
                        <table class="table table-modern small mb-3" id="table-jenjang">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Jenjang</th>
                                    <th>Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($rekap_jenjang as $i => $row): ?>
                                    <tr>
                                        <td><?= $i + 1 ?></td>
                                        <td><?= esc($row['jenjang']) ?></td>
                                        <td><?= $row['total'] ?></td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-6">
                    <div id="chart-jenjang" style="height: 300px;"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Lembaga -->
    <div class="card mb-5 shadow-sm border-0 rounded-4 animate-fade">
        <div class="card-header bg-gradient-to-r from-success to-teal text-dark rounded-top-4 fw-semibold">
            Persentase Berdasarkan Lembaga
        </div>
        <div class="card-body bg-white">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-modern small mb-3" id="table-lembaga">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Lembaga</th>
                                <th>Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($rekap_lembaga as $i => $row): ?>
                                <tr>
                                    <td><?= $i + 1 ?></td>
                                    <td><?= esc($row['lembaga']) ?></td>
                                    <td><?= $row['total'] ?></td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-6">
                    <div id="chart-lembaga" style="height: 300px;"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tahun lulus -->
    <div class="card mb-5 shadow-sm border-0 rounded-4 animate-fade">
        <div class="card-header bg-gradient-to-r from-success to-teal text-dark rounded-top-4 fw-semibold">
            Persentase Berdasarkan Tahun Lulus
        </div>
        <div class="card-body bg-white">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-modern small mb-3" id="table-lulus">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Tahun Lulus</th>
                                <th>Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($rekap_lulus as $i => $row): ?>
                                <tr>
                                    <td><?= $i + 1 ?></td>
                                    <td><?= esc($row['tahun_lulus']) ?></td>
                                    <td><?= $row['total'] ?></td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-6">
                    <div id="chart-lulus" style="height: 300px;"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Provinsi & Kota -->
    <div class="card mb-5 shadow-sm border-0 rounded-4 animate-fade">
        <div class="card-header bg-gradient-to-r from-success to-teal text-dark rounded-top-4 fw-semibold">
            Persentase Berdasarkan Provinsi dan Kota
        </div>
        <div class="card-body bg-white">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-modern small mb-3" id="table-wilayah">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Provinsi & Kota</th>
                                <th>Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($rekap_wilayah as $i => $row): ?>
                                <tr>
                                    <td><?= $i + 1 ?></td>
                                    <td><?= esc($row['provinsi_kota']) ?></td>
                                    <td><?= $row['total'] ?></td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-6">
                    <div id="chart-wilayah" style="height: 300px;"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tahun terdaftar -->
    <div class="card mb-5 shadow-sm border-0 rounded-4 animate-fade">
        <div class="card-header bg-gradient-to-r from-success to-teal text-dark rounded-top-4 fw-semibold">
            Persentase Berdasarkan Tahun Terdaftar di Institusi
        </div>
        <div class="card-body bg-white">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-modern small mb-3" id="table-terdaftar">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Tahun Masuk</th>
                                <th>Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($rekap_terdaftar as $i => $row): ?>
                                <tr>
                                    <td><?= $i + 1 ?></td>
                                    <td><?= esc($row['tahun_masuk']) ?></td>
                                    <td><?= $row['total'] ?></td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-6">
                    <div id="chart-terdaftar" style="height: 300px;"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-5 shadow-sm border-0 rounded-4 animate-fade">
        <div class="card-header bg-gradient-to-r from-success to-teal text-dark rounded-top-4 fw-semibold">
            Penilaian Pengguna terhadap Lulusan UMAHA
        </div>
        <div class="card-body bg-white">
            <div id="grafikPengguna" style="height: 400px;"></div>
        </div>
    </div>

    <!-- Kondisi saat ini -->
    <div class="card mb-5 shadow-sm border-0 rounded-4 animate-fade">
        <div class="card-header bg-gradient-to-r from-success to-teal text-dark rounded-top-4 fw-semibold">
            Persentase Berdasarkan Kondisi Saat Ini
        </div>
        <div class="card-body bg-white">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-modern small mb-3" id="table-kondisi">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Kondisi</th>
                                <th>Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($rekap_kondisi as $i => $row): ?>
                                <tr>
                                    <td><?= $i + 1 ?></td>
                                    <td><?= esc($row['status_pekerjaan']) ?></td>
                                    <td><?= $row['total'] ?></td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-6">
                    <div id="chart-kondisi" style="height: 300px;"></div>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Script -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>

<script>
    $(function() {
        $('#tabelPengguna').DataTable();
        // Prodi
        Highcharts.chart('chart-prodi', {
            chart: {
                type: 'pie'
            },
            title: {
                text: 'Distribusi Berdasarkan Program Studi'
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.y}</b>'
            },
            accessibility: {
                point: {
                    valueSuffix: ''
                }
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        format: '{point.name}: {point.percentage:.1f} %'
                    }
                }
            },
            series: [{
                name: 'Jumlah',
                colorByPoint: true,
                data: <?= json_encode(array_map(function ($d) {
                            return [
                                'name' => $d['nama_prodi'],
                                'y' => (int) $d['total']
                            ];
                        }, $rekap_prodi)) ?>
            }]
        });

        // Jenjang
        Highcharts.chart('chart-jenjang', {
            chart: {
                type: 'pie'
            },
            title: {
                text: 'Distribusi Berdasarkan Jenjang'
            },
            series: [{
                name: 'Jumlah',
                colorByPoint: true,
                data: <?= json_encode(array_map(function ($d) {
                            return [
                                'name' => $d['jenjang'],
                                'y' => (int) $d['total']
                            ];
                        }, $rekap_jenjang)) ?>
            }]
        });

        // Lembaga
        Highcharts.chart('chart-lembaga', {
            chart: {
                type: 'pie'
            },
            title: {
                text: 'Distribusi Berdasarkan Lembaga'
            },
            series: [{
                name: 'Jumlah',
                colorByPoint: true,
                data: <?= json_encode(array_map(function ($d) {
                            return [
                                'name' => $d['lembaga'],
                                'y' => (int) $d['total']
                            ];
                        }, $rekap_lembaga)) ?>
            }]
        });

        // Tahun Lulus
        Highcharts.chart('chart-lulus', {
            chart: {
                type: 'pie'
            },
            title: {
                text: 'Distribusi Berdasarkan Tahun Lulus'
            },
            series: [{
                name: 'Jumlah',
                colorByPoint: true,
                data: <?= json_encode(array_map(function ($d) {
                            return [
                                'name' => $d['tahun_lulus'],
                                'y' => (int) $d['total']
                            ];
                        }, $rekap_lulus)) ?>
            }]
        });

        // Provinsi & Kota
        Highcharts.chart('chart-wilayah', {
            chart: {
                type: 'pie'
            },
            title: {
                text: 'Distribusi Berdasarkan Wilayah'
            },
            series: [{
                name: 'Jumlah',
                colorByPoint: true,
                data: <?= json_encode(array_map(function ($d) {
                            return [
                                'name' => $d['provinsi_kota'],
                                'y' => (int) $d['total']
                            ];
                        }, $rekap_wilayah)) ?>
            }]
        });

        // Tahun Terdaftar
        Highcharts.chart('chart-terdaftar', {
            chart: {
                type: 'pie'
            },
            title: {
                text: 'Distribusi Berdasarkan Tahun Masuk'
            },
            series: [{
                name: 'Jumlah',
                colorByPoint: true,
                data: <?= json_encode(array_map(function ($d) {
                            return [
                                'name' => $d['tahun_masuk'],
                                'y' => (int) $d['total']
                            ];
                        }, $rekap_terdaftar)) ?>
            }]
        });

        // Kondisi Saat Ini
        Highcharts.chart('chart-kondisi', {
            chart: {
                type: 'pie'
            },
            title: {
                text: 'Distribusi Berdasarkan Kondisi Saat Ini'
            },
            series: [{
                name: 'Jumlah',
                colorByPoint: true,
                data: <?= json_encode(array_map(function ($d) {
                            return [
                                'name' => $d['status_pekerjaan'],
                                'y' => (int) $d['total']
                            ];
                        }, $rekap_kondisi)) ?>
            }]
        });

        Highcharts.chart('grafikPengguna', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'Penilaian Pengguna terhadap Lulusan UMAHA'
            },
            xAxis: {
                categories: ['Etika', 'Profesional', 'Bahasa Asing', 'IT', 'Komunikasi', 'Kerja Sama', 'Pengembangan Diri'],
                crosshair: true
            },
            yAxis: {
                min: 0,
                max: 5,
                title: {
                    text: 'Rata-rata Skor (1�5)'
                }
            },
            tooltip: {
                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                    '<td style="padding:0"><b>{point.y:.2f}</b></td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0
                }
            },
            series: [{
                name: 'Skor Rata-rata',
                data: [
                    <?= number_format(array_sum(array_column($list, 'etika_kerja')) / max(count($list), 1), 2) ?>,
                    <?= number_format(array_sum(array_column($list, 'keahlian_profesional')) / max(count($list), 1), 2) ?>,
                    <?= number_format(array_sum(array_column($list, 'penguasaan_bahasa_asing')) / max(count($list), 1), 2) ?>,
                    <?= number_format(array_sum(array_column($list, 'teknologi_informasi')) / max(count($list), 1), 2) ?>,
                    <?= number_format(array_sum(array_column($list, 'komunikasi')) / max(count($list), 1), 2) ?>,
                    <?= number_format(array_sum(array_column($list, 'kerjasama')) / max(count($list), 1), 2) ?>,
                    <?= number_format(array_sum(array_column($list, 'pengembangan_diri')) / max(count($list), 1), 2) ?>
                ]
            }]
        });

    });
</script>

<?= $this->endSection() ?>