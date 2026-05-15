<?= $this->extend('layouts/admin_main') ?>
<?= $this->section('content') ?>

<div class="container-fluid p-4">

    <h3 class="mb-4">
        <i class="bi bi-person-workspace me-2"></i>
        Detail Kuesioner Pengguna
    </h3>

    <a href="<?= base_url('admin/kuesioner-pengguna') ?>"
        class="btn btn-secondary mb-4">

        <i class="bi bi-arrow-left"></i>
        Kembali
    </a>

    <!-- DATA ALUMNI -->
    <div class="card mb-4">

        <div class="card-header fw-bold">
            Data Alumni/Pegawai Dinilai
        </div>

        <div class="card-body">

            <?php if (!empty($details)): ?>

                <?php foreach ($details as $i => $detail): ?>

                    <div class="border rounded p-3 mb-3">

                        <h6 class="fw-bold mb-3">
                            Alumni Dinilai #<?= $i + 1 ?>
                        </h6>

                        <div class="row">

                            <div class="col-md-4 mb-3">
                                <label>Nama Pegawai</label>
                                <div class="fw-semibold">
                                    <?= esc($detail['nama_pegawai_dinilai'] ?: $detail['nama_alumni']) ?>
                                </div>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label>NIM</label>
                                <div class="fw-semibold">
                                    <?= esc($detail['nim'] ?? '-') ?>
                                </div>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label>Program Studi</label>
                                <div class="fw-semibold">
                                    <?= esc($detail['asal_program_studi_pegawai'] ?: $detail['nama_prodi']) ?>
                                </div>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label>Tahun Lulus</label>
                                <div class="fw-semibold">
                                    <?= esc($detail['tahun_lulus_pegawai'] ?: $detail['tahun_lulus_alumni']) ?>
                                </div>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label>Jenjang</label>
                                <div class="fw-semibold">
                                    <?= esc($detail['jenjang'] ?? '-') ?>
                                </div>
                            </div>

                        </div>

                        <div class="table-responsive">
                            <table class="table table-sm table-bordered align-middle">
                                <thead>
                                    <tr>
                                        <th>Etika</th>
                                        <th>Keahlian</th>
                                        <th>Bahasa</th>
                                        <th>TI</th>
                                        <th>Komunikasi</th>
                                        <th>Kerjasama</th>
                                        <th>Pengembangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><?= esc($detail['etika_kerja']) ?></td>
                                        <td><?= esc($detail['keahlian_profesional']) ?></td>
                                        <td><?= esc($detail['penguasaan_bahasa_asing']) ?></td>
                                        <td><?= esc($detail['teknologi_informasi']) ?></td>
                                        <td><?= esc($detail['komunikasi']) ?></td>
                                        <td><?= esc($detail['kerjasama']) ?></td>
                                        <td><?= esc($detail['pengembangan_diri']) ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <label>Harapan terhadap lulusan UMAHA</label>
                                <div><?= nl2br(esc($detail['harapan_lulusan_umaha'] ?? '-')) ?></div>
                            </div>
                            <div class="col-md-6 mb-2">
                                <label>Saran dan masukan</label>
                                <div><?= nl2br(esc($detail['saran_umum'] ?? '-')) ?></div>
                            </div>
                        </div>

                    </div>

                <?php endforeach; ?>

            <?php else: ?>

                <div class="text-muted">
                    Belum ada detail alumni yang tersimpan.
                </div>

            <?php endif; ?>

        </div>

    </div>

    <!-- DATA PEKERJAAN -->
    <div class="card mb-4">

        <div class="card-header fw-bold">
            Data Pekerjaan Alumni
        </div>

        <div class="card-body">

            <div class="row">

                <div class="col-md-4 mb-3">
                    <label>Status Pekerjaan</label>
                    <div class="fw-semibold">
                        <?= esc($pengguna['status_pekerjaan']) ?>
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <label>Perusahaan</label>
                    <div class="fw-semibold">
                        <?= esc($pengguna['institusi_bekerja']) ?>
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <label>Posisi</label>
                    <div class="fw-semibold">
                        <?= esc($pengguna['posisi_pekerjaan']) ?>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- PENILAI -->
    <div class="card mb-4">

        <div class="card-header fw-bold">
            Penilai / HRD
        </div>

        <div class="card-body">

            <div class="row">

                <div class="col-md-6 mb-3">
                    <label>Nama Pengisi</label>
                    <div class="fw-semibold">
                        <?= esc($pengguna['nama_pengisi']) ?>
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Jabatan</label>
                    <div class="fw-semibold">
                        <?= esc($pengguna['jabatan_pengisi']) ?>
                    </div>
                </div>

            </div>

        </div>

    </div>

</div>

<?= $this->endSection() ?>
