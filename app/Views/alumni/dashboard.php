<?= $this->extend('layouts/alumni') ?>
<?= $this->section('content') ?>

<div class="container mt-5">
    <h4 class="mb-4">Dashboard Alumni</h4>

    <div class="card mb-4">
        <div class="card-header bg-success text-white">Biodata</div>
        <div class="card-body">
            <p><strong>NIM:</strong> <?= esc($alumni['nim']) ?></p>
            <p><strong>Nama:</strong> <?= esc($alumni['nama']) ?></p>
            <p><strong>Prodi:</strong> <?= esc($alumni['nama_prodi']) ?> (<?= esc($alumni['jenjang']) ?>)</p>
            <p><strong>Tahun Lulus:</strong> <?= esc($alumni['tahun_lulus']) ?></p>
        </div>
    </div>

    <?php if ($tracer): ?>
        <div class="card mb-4">
            <div class="card-header bg-info text-white">Data Tracer Study</div>
            <div class="card-body">
                <p><strong>Status Pekerjaan:</strong> <?= esc($tracer['status_pekerjaan']) ?></p>
                <p><strong>Institusi:</strong> <?= esc($tracer['institusi_bekerja']) ?></p>
                <p><strong>Posisi:</strong> <?= esc($tracer['posisi_pekerjaan']) ?></p>
                <p><strong>Gaji Pertama:</strong> Rp<?= number_format($tracer['gaji_pertama'], 0, ',', '.') ?></p>
            </div>
        </div>
    <?php else: ?>
        <div class="alert alert-warning">Anda belum mengisi kuesioner tracer study.</div>
    <?php endif ?>
</div>

<?= $this->endSection() ?>