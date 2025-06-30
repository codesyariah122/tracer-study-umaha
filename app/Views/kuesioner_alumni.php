<!-- app/Views/kuesioner_alumni.php -->
<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container mt-4 mb-5">
    <h3 class="mb-3">Form Kuesioner Tracer Study</h3>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif ?>

    <form action="<?= base_url('kuesioner/alumni/simpan') ?>" method="post">
        <input type="hidden" name="tahun_pengisian" value="<?= date('Y') ?>">

        <!-- Step 1 -->
        <div id="step-1" class="step">
            <h5 class="mb-2">Biodata Alumni</h5>
            <div class="row">
                <div class="col-md-6">
                    <label>NIM</label>
                    <input type="text" class="form-control" value="<?= esc($alumni['nim']) ?>" readonly>
                </div>
                <div class="col-md-6">
                    <label>Nama</label>
                    <input type="text" class="form-control" value="<?= esc($alumni['nama']) ?>" readonly>
                </div>
                <div class="col-md-6 mt-2">
                    <label>Program Studi</label>
                    <input type="text" class="form-control" value="<?= esc($alumni['nama_prodi']) ?> (<?= esc($alumni['jenjang']) ?>)" readonly>
                </div>
                <div class="col-md-6 mt-2">
                    <label>Tahun Lulus</label>
                    <input type="text" class="form-control" value="<?= esc($alumni['tahun_lulus']) ?>" readonly>
                </div>
            </div>

            <hr>
            <h5>Status Pekerjaan</h5>
            <div class="mb-3">
                <select name="status_pekerjaan" class="form-select" required>
                    <option value="">Pilih</option>
                    <option value="bekerja">Bekerja</option>
                    <option value="wirausaha">Wirausaha</option>
                    <option value="belum_bekerja">Belum Bekerja</option>
                    <option value="studi_lanjut">Studi Lanjut</option>
                </select>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <label>Institusi Tempat Bekerja</label>
                    <input type="text" class="form-control" name="institusi_bekerja">
                </div>
                <div class="col-md-6">
                    <label>Posisi Pekerjaan</label>
                    <input type="text" class="form-control" name="posisi_pekerjaan">
                </div>
            </div>

            <hr>
            <h5>Informasi Tambahan Pekerjaan</h5>

            <div class="mb-3">
                <label>Jenis Pekerjaan</label>
                <select name="sektor_tempat_kerja" class="form-select">
                    <option value="">Pilih</option>
                    <option value="PNS">PNS</option>
                    <option value="Swasta">Swasta</option>
                    <option value="Wirausaha">Wirausaha</option>
                    <option value="Lainnya">Lainnya</option>
                </select>
            </div>

            <div class="mb-3">
                <label>Pekerjaan Sesuai Bidang?</label>
                <select name="sesuai_bidang" class="form-select">
                    <option value="">Pilih</option>
                    <option value="ya">Ya</option>
                    <option value="tidak">Tidak</option>
                </select>
            </div>

            <div class="mb-3">
                <label>Tahun Mulai Bekerja</label>
                <input type="number" name="tahun_mulai_bekerja" class="form-control" placeholder="Contoh: 2024">
            </div>

            <div class="mb-3">
                <label>Mulai Mencari Kerja (Bulan sebelum/setelah lulus)</label>
                <input type="text" name="bulan_mulai_mencari_pekerjaan" class="form-control" placeholder="Contoh: 2 bulan setelah lulus">
            </div>

            <div class="mb-3">
                <label>Cara Mendapatkan Pekerjaan</label>
                <textarea class="form-control" name="cara_mendapat_kerja" rows="3"></textarea>
            </div>

            <div class="mb-3">
                <label>Gaji Pertama</label>
                <input type="number" name="gaji_pertama" class="form-control" placeholder="Contoh: 2500000">
            </div>

            <button type="button" class="btn btn-success mt-3" onclick="nextStep()">Lanjut <i class="bi bi-arrow-bar-right"></i></button>
        </div>

        <!-- Step 2 -->
        <div id="step-2" class="step d-none">
            <h5>Penilaian terhadap pembelajaran di kampus</h5>
            <?php
            $pertanyaan = [
                'kepuasan_etika' => 'Etika',
                'kepuasan_keahlian_bidan_ilmu' => 'Keahlian Bidang Ilmu',
                'kepuasan_bahasa_asing' => 'Bahasa Asing',
                'kepuasan_teknologi_informasi' => 'Teknologi Informasi',
                'kepuasan_komunikasi' => 'Komunikasi',
                'kepuasan_kerjasama' => 'Kerja Sama',
                'kepuasan_pengembangan_diri' => 'Pengembangan Diri',
            ];

            foreach ($pertanyaan as $field => $label):
            ?>
                <div class="mb-3">
                    <label><?= $label ?> (1 = Sangat Kurang, 5 = Sangat Baik)</label>
                    <select class="form-select" name="<?= $field ?>" required>
                        <option value="">Pilih</option>
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <option value="<?= $i ?>"><?= $i ?></option>
                        <?php endfor ?>
                    </select>
                </div>
            <?php endforeach ?>

            <hr>
            <h5>Relevansi Kurikulum & Saran</h5>
            <div class="mb-3">
                <label>Relevansi Kurikulum</label>
                <select name="relevansi_kurikulum" class="form-select" required>
                    <option value="">Pilih</option>
                    <option value="tinggi">Tinggi</option>
                    <option value="sedang">Sedang</option>
                    <option value="rendah">Rendah</option>
                </select>
            </div>

            <div class="mb-3">
                <label>Saran/Masukan untuk Kampus</label>
                <textarea class="form-control" name="saran_kurikulum" rows="3"></textarea>
            </div>

            <div class="mb-3">
                <label>Bagaimana harapan Anda terhadap lulusan UMAHA?</label>
                <textarea class="form-control" name="harapan_umaha" rows="3"></textarea>
            </div>

            <button type="button" class="btn btn-secondary" onclick="prevStep()">Kembali</button>
            <button type="submit" class="btn btn-success">Simpan Kuesioner</button>
        </div>
    </form>
</div>

<!-- Stepper Script -->
<script>
    function nextStep() {
        const requiredFields = document.querySelectorAll('#step-1 [required]');
        let isValid = true;

        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                field.classList.add('is-invalid');
                isValid = false;
            } else {
                field.classList.remove('is-invalid');
            }
        });

        if (isValid) {
            document.getElementById('step-1').classList.add('d-none');
            document.getElementById('step-2').classList.remove('d-none');
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        } else {
            Swal.fire({
                icon: 'warning',
                title: 'Lengkapi Data',
                text: 'Harap lengkapi semua data wajib di Langkah 1 sebelum melanjutkan.',
                confirmButtonColor: '#3085d6',
            });
        }
    }

    function prevStep() {
        document.getElementById('step-2').classList.add('d-none');
        document.getElementById('step-1').classList.remove('d-none');
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    }
</script>


<?= $this->endSection() ?>