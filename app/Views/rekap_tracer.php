<?= $this->extend('layouts/main') ?>
<?php
/** @var array $tahun_list */
/** @var array $prodi_list */

/** @var string|null $filter_tahun */
/** @var string|null $filter_prodi */

/** @var array $rekap_prodi */
/** @var array $rekap_jk */
/** @var array $rekap_lulus */
/** @var array $rekap_status */
/** @var array $rekap_sumberdana */
/** @var array $rekap_jenjang */
/** @var array $rekap_terdaftar */
/** @var array $rekap_kabupaten */
/** @var array $rekap_sektor */
/** @var array $rekap_sesuai */
/** @var array $rekap_sebelum_lulus */
/** @var array $rekap_relevansi */

/** @var array $rekap_bulan_sebelum */
/** @var array $rekap_bulan_setelah */
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
        padding: 75px 40px;
        color: white;
        box-shadow: 0 20px 45px rgba(0, 0, 0, .12);
    }

    .report-hero::before {
        content: '';
        position: absolute;
        width: 380px;
        height: 380px;
        border-radius: 50%;
        background: rgba(255, 255, 255, .06);
        top: -140px;
        right: -100px;
    }

    .report-hero::after {
        content: '';
        position: absolute;
        width: 240px;
        height: 240px;
        border-radius: 50%;
        background: rgba(255, 255, 255, .05);
        bottom: -90px;
        left: -60px;
    }

    .hero-content {
        position: relative;
        z-index: 2;
        max-width: 850px;
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
        font-size: 3rem;
        font-weight: 800;
        margin-bottom: 14px;
    }

    .hero-subtitle {
        font-size: 1.08rem;
        opacity: .92;
        line-height: 1.8;
    }

    .filter-card {
        background: white;
        border-radius: 28px;
        padding: 30px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, .05);
        margin-bottom: 40px;
    }

    .form-control,
    .form-select {
        border-radius: 16px;
        min-height: 54px;
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
        border-radius: 16px;
        min-height: 54px;
        color: white;
        font-weight: 700;
        transition: .3s ease;
    }

    .btn-modern:hover {
        transform: translateY(-2px);
        color: white;
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

    .mini-title {
        font-size: 18px;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 20px;
    }

    @media(max-width:768px) {

        .report-hero {
            padding: 55px 24px;
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
                <i class="bi bi-graph-up-arrow"></i>
                Statistik Tracer Study
            </div>

            <h1 class="hero-title">
                Rekap Tracer Study Alumni
            </h1>

            <p class="hero-subtitle">
                Visualisasi statistik tracer study alumni Universitas Maarif Hasyim Latif
                berdasarkan hasil pengisian kuesioner alumni secara real-time dan terintegrasi.
            </p>

        </div>

    </div>

    <form method="get" class="filter-card">
        <div class="row g-4 align-items-end">

            <div class="col-md-4">
                <label class="form-label fw-semibold">Filter Tahun</label>
                <select class="form-select" name="tahun">
                    <option value="">Semua Tahun</option>

                    <?php foreach ($tahun_list as $t): ?>
                        <option value="<?= $t['tahun_pengisian'] ?>"
                            <?= ($filter_tahun == $t['tahun_pengisian']) ? 'selected' : '' ?>>
                            <?= $t['tahun_pengisian'] ?>
                        </option>
                    <?php endforeach ?>
                </select>
            </div>

            <div class="col-md-4">
                <label class="form-label fw-semibold">Filter Program Studi</label>
                <select class="form-select" name="prodi">
                    <option value="">Semua Prodi</option>

                    <?php foreach ($prodi_list as $p): ?>
                        <option value="<?= $p['nama_prodi'] ?>"
                            <?= ($filter_prodi == $p['nama_prodi']) ? 'selected' : '' ?>>
                            <?= $p['nama_prodi'] ?>
                        </option>
                    <?php endforeach ?>
                </select>
            </div>

            <div class="col-md-4">
                <button type="submit" class="btn btn-modern w-100">
                    <i class="bi bi-funnel-fill me-2"></i>
                    Tampilkan Data
                </button>
            </div>

        </div>
    </form>

    <?php
    $grafik = [
        'Rekap Prodi' => ['rekap_prodi', 'nama_prodi'],
        'Jenis Kelamin' => ['rekap_jk', 'jenis_kelamin'],
        'Tahun Lulus' => ['rekap_lulus', 'tahun_lulus'],
        'Status Pekerjaan' => ['rekap_status', 'status_pekerjaan'],
        'Sumber Dana' => ['rekap_sumberdana', 'sumber_dana'],
        'Program Studi' => ['rekap_prodi', 'nama_prodi'],
        'Jenjang' => ['rekap_jenjang', 'jenjang'],
        'Tahun Masuk' => ['rekap_terdaftar', 'tahun_masuk'],
        'Tempat Kerja (Kabupaten)' => ['rekap_kabupaten', 'kabupaten'],
        'Sektor Tempat Kerja' => ['rekap_sektor', 'sektor'],
        'Kesesuaian Bidang' => ['rekap_sesuai', 'sesuai'],
        'Kerja Sebelum Lulus' => ['rekap_sebelum_lulus', 'sebelum_lulus'],
        'Relevansi Kurikulum' => ['rekap_relevansi', 'relevansi_kurikulum'],
    ];
    ?>

    <?php foreach ($grafik as $judul => [$var, $key]): ?>
        <div class="chart-card">
            <div class="chart-card-header">

                <h4 class="section-title">
                    <?= esc($judul) ?>
                </h4>

                <div class="section-subtitle">
                    Visualisasi distribusi data berdasarkan <?= strtolower($judul) ?>.
                </div>

            </div>
            <div class="chart-card-body">
                <div class="row">
                    <div class="col-md-6 mb-3 mb-md-0">
                        <table class="modern-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th><?= $judul ?></th>
                                    <th>Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($$var as $i => $row): ?>
                                    <tr>
                                        <td><?= $i + 1 ?></td>
                                        <td><?= esc($row[$key]) ?></td>
                                        <td><?= $row['total'] ?></td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <div id="chart-<?= $key ?>" style="height: 300px;"></div>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach ?>

    <!-- Waktu Mendapatkan Pekerjaan -->
    <div class="chart-card">
        <div class="chart-card-header">

            <h4 class="section-title">
                Rata-rata Waktu Mendapatkan Pekerjaan
            </h4>

            <div class="section-subtitle">
                Distribusi alumni berdasarkan waktu memperoleh pekerjaan sebelum dan setelah lulus.
            </div>

        </div>
        <div class="chart-card-body">
            <div class="row">
                <div class="col-md-6 mb-4">
                    <h5 class="mini-title">Sebelum Lulus</h6>
                        <table class="modern-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Kategori (bulan)</th>
                                    <th>Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($rekap_bulan_sebelum as $i => $row): ?>
                                    <tr>
                                        <td><?= $i + 1 ?></td>
                                        <td><?= esc($row['kategori']) ?></td>
                                        <td><?= $row['total'] ?></td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                        <div id="chart-sebelum" style="height: 300px;"></div>
                </div>
                <div class="col-md-6">
                    <h6 class="fw-bold mb-3">Setelah Lulus</h6>
                    <table class="table table-sm table-bordered mb-3">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Kategori (bulan)</th>
                                <th>Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($rekap_bulan_setelah as $i => $row): ?>
                                <tr>
                                    <td><?= $i + 1 ?></td>
                                    <td><?= esc($row['kategori']) ?></td>
                                    <td><?= $row['total'] ?></td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                    <div id="chart-setelah" style="height: 300px;"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart Scripts -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script>
    <?php foreach ($grafik as $judul => [$var, $key]): ?>
        Highcharts.chart('chart-<?= $key ?>', {
            chart: {
                type: 'pie',
                backgroundColor: 'transparent'
            },
            plotOptions: {
                pie: {
                    borderRadius: 8,
                    innerSize: '45%',
                    dataLabels: {
                        enabled: true,
                        format: '<b>{point.name}</b><br>{point.percentage:.1f}%'
                    }
                }
            },
            title: {
                text: ''
            },
            series: [{
                name: 'Jumlah',
                colorByPoint: true,
                data: <?= json_encode(array_map(fn($d) => ['name' => $d[$key], 'y' => (int)$d['total']], $$var)) ?>
            }]
        });
    <?php endforeach ?>

    Highcharts.chart('chart-sebelum', {
        chart: {
            type: 'pie',
            backgroundColor: 'transparent'
        },
        plotOptions: {
            pie: {
                borderRadius: 8,
                innerSize: '45%',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b><br>{point.percentage:.1f}%'
                }
            }
        },
        title: {
            text: ''
        },
        series: [{
            name: 'Jumlah',
            colorByPoint: true,
            data: <?= json_encode(array_map(fn($r) => ['name' => $r['kategori'] . ' bulan', 'y' => (int)$r['total']], $rekap_bulan_sebelum)) ?>
        }]
    });

    Highcharts.chart('chart-setelah', {
        chart: {
            type: 'pie',
            backgroundColor: 'transparent'
        },
        plotOptions: {
            pie: {
                borderRadius: 8,
                innerSize: '45%',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b><br>{point.percentage:.1f}%'
                }
            }
        },
        title: {
            text: ''
        },
        series: [{
            name: 'Jumlah',
            colorByPoint: true,
            data: <?= json_encode(array_map(fn($r) => ['name' => $r['kategori'] . ' bulan', 'y' => (int)$r['total']], $rekap_bulan_setelah)) ?>
        }]
    });
</script>

<?= $this->endSection() ?>