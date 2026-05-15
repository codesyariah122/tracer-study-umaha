<!-- app/Views/kuesioner_pengguna.php -->
<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<style>
    .form-step {
        display: none;
    }

    .form-step.active {
        display: block;
    }
</style>

<div class="container mt-4 mb-5">
    <h3 class="mb-3">Form Kuesioner Pengguna Lulusan UMAHA</h3>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif ?>

    <form method="post" action="<?= base_url('kuesioner/pengguna/simpan') ?>" id="multiStepForm">
        <input
            type="hidden"
            name="token"
            value="<?= esc($request['token']) ?>">
        <?php
        $namaAlumni = old(
            'details.0.nama_pegawai_dinilai',
            $alumniDinilai['nama'] ?? ''
        );
        $prodiAlumni = old(
            'details.0.asal_program_studi_pegawai',
            $alumniDinilai['nama_prodi'] ?? ($alumniDinilai['program_studi'] ?? '')
        );
        $tahunLulusAlumni = old(
            'details.0.tahun_lulus_pegawai',
            $alumniDinilai['tahun_lulus'] ?? ''
        );
        $indikator = [
            'etika_kerja' => 'Etika profesional dan integritas',
            'keahlian_profesional' => 'Keahlian berdasarkan bidang ilmu',
            'penguasaan_bahasa_asing' => 'Kemampuan Bahasa Inggris / asing',
            'teknologi_informasi' => 'Penggunaan Teknologi Informasi',
            'komunikasi' => 'Kemampuan Komunikasi',
            'kerjasama' => 'Kerja sama tim',
            'pengembangan_diri' => 'Pengembangan diri',
        ];
        ?>

        <!-- LANGKAH 1 -->
        <div class="form-step step-1 active">
            <h5>Langkah 1: Informasi Perusahaan & Rekrutmen</h5>
            <div class="row">
                <div class="col-md-12 mb-2">
                    <label>Nama Perusahaan</label>
                    <input
                        type="text"
                        name="nama_perusahaan"
                        class="form-control"
                        value="<?= esc($request['nama_perusahaan']) ?>"
                        readonly
                        required>
                </div>
                <div class="col-md-12 mb-2">
                    <label>Alamat Perusahaan</label>
                    <textarea
                        name="alamat_perusahaan"
                        class="form-control"
                        readonly><?= esc(
                                        $request['alamat_perusahaan'] ?? ''
                                    ) ?></textarea>
                </div>
                <div class="col-md-12 mb-2">
                    <label>Nama Pengisi dari Instansi</label>
                    <input
                        type="text"
                        name="nama_pengisi"
                        class="form-control"
                        value="<?= esc(old('nama_pengisi', $request['nama_penilai'] ?? '')) ?>"
                        required>
                </div>
                <div class="col-md-12 mb-2">
                    <label>Posisi/Jabatan Pengisi</label>
                    <input
                        type="text"
                        name="jabatan_pengisi"
                        class="form-control"
                        value="<?= esc(old('jabatan_pengisi', $request['jabatan_penilai'] ?? '')) ?>"
                        required>
                </div>
                <div class="col-md-6 mb-2">
                    <label>Email</label>
                    <input
                        type="email"
                        name="email_pengisi"
                        class="form-control"
                        value="<?= esc(old('email_pengisi', $request['email_hrd'] ?? '')) ?>">
                </div>
                <div class="col-md-6 mb-2">
                    <label>No. Telepon / WhatsApp</label>
                    <input
                        type="text"
                        name="no_telp_pengisi"
                        class="form-control"
                        value="<?= esc(old('no_telp_pengisi', $request['no_telp_penilai'] ?? '')) ?>">
                </div>
                <div class="col-md-6 mb-2">
                    <label>Tahun Merekrut</label>
                    <input
                        type="number"
                        name="tahun_merekrut"
                        class="form-control"
                        min="1900"
                        max="2100"
                        value="<?= esc(old('tahun_merekrut')) ?>"
                        required>
                </div>
                <div class="col-md-6 mb-2">
                    <label>Jumlah Lulusan UMAHA yang Direkrut</label>
                    <input
                        type="number"
                        name="jumlah_lulusan_direkrut"
                        class="form-control"
                        min="1"
                        value="<?= esc(old('jumlah_lulusan_direkrut', 1)) ?>"
                        required>
                </div>
            </div>

            <button type="button" class="btn btn-success mt-3" onclick="nextStep()">Lanjut <i class="bi bi-arrow-bar-right"></i></button>
        </div>

        <!-- LANGKAH 2 -->
        <div class="form-step step-2">
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
                <h5 class="mb-0">Langkah 2: Pegawai/Alumni yang Dinilai</h5>
                <button
                    type="button"
                    class="btn btn-outline-success btn-sm"
                    onclick="addAlumniDetail()">
                    <i class="bi bi-plus-circle"></i>
                    Tambah Alumni
                </button>
            </div>

            <div class="alert alert-info">
                Satu pengisi dapat menilai lebih dari satu alumni UMAHA dari perusahaan/instansi yang sama.
            </div>

            <div id="alumniDetails">
                <div class="card mb-3 alumni-detail" data-index="0">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <strong>Alumni Dinilai #1</strong>
                    </div>
                    <div class="card-body">
                        <input
                            type="hidden"
                            name="details[0][alumni_id]"
                            value="<?= esc($alumniDinilai['id'] ?? '') ?>">

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Nama Pegawai yang Dinilai</label>
                                <input
                                    type="text"
                                    name="details[0][nama_pegawai_dinilai]"
                                    class="form-control step2-required"
                                    value="<?= esc($namaAlumni) ?>">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label>Tahun Lulus Pegawai</label>
                                <input
                                    type="number"
                                    name="details[0][tahun_lulus_pegawai]"
                                    class="form-control"
                                    min="1900"
                                    max="2100"
                                    value="<?= esc($tahunLulusAlumni) ?>">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label>Asal Program Studi</label>
                                <input
                                    type="text"
                                    name="details[0][asal_program_studi_pegawai]"
                                    class="form-control"
                                    value="<?= esc($prodiAlumni) ?>">
                            </div>
                        </div>

                        <div class="row">
                            <?php foreach ($indikator as $key => $label): ?>
                                <div class="col-md-6 mb-3">
                                    <label><?= esc($label) ?> (1 = Sangat Rendah, 5 = Sangat Tinggi)</label>
                                    <select class="form-select step2-required" name="details[0][<?= esc($key) ?>]">
                                        <option value="">Pilih</option>
                                        <?php for ($i = 1; $i <= 5; $i++): ?>
                                            <option value="<?= $i ?>"><?= $i ?></option>
                                        <?php endfor ?>
                                    </select>
                                </div>
                            <?php endforeach ?>
                        </div>

                        <div class="mb-3">
                            <label>Bagaimana harapan Anda terhadap lulusan UMAHA?</label>
                            <textarea
                                name="details[0][harapan_lulusan_umaha]"
                                class="form-control"
                                rows="3"></textarea>
                        </div>

                        <div class="mb-0">
                            <label>Saran dan masukan untuk UMAHA</label>
                            <textarea
                                name="details[0][saran_umum]"
                                class="form-control"
                                rows="3"></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <button type="button" class="btn btn-secondary" onclick="prevStep()">Kembali</button>
            <button
                type="button"
                class="btn btn-success"
                onclick="submitForm()">

                Kirim Kuesioner
            </button>
        </div>
    </form>
</div>

<script>
    function nextStep() {
        const step1Fields = document.querySelectorAll('.step-1 [required]');
        let isValid = true;

        step1Fields.forEach(field => {
            if (!field.value.trim()) {
                field.classList.add('is-invalid');
                isValid = false;
            } else {
                field.classList.remove('is-invalid');
            }
        });

        if (isValid) {
            document.querySelector('.step-1').classList.remove('active');
            document.querySelector('.step-2').classList.add('active');
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
        document.querySelector('.step-2').classList.remove('active');
        document.querySelector('.step-1').classList.add('active');
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    }
</script>

<script>
    function submitForm() {

        const step2Fields =
            document.querySelectorAll('.alumni-detail .step2-required');

        let isValid = true;

        step2Fields.forEach(field => {

            if (!field.value.trim()) {

                field.classList.add('is-invalid');

                isValid = false;

            } else {

                field.classList.remove('is-invalid');
            }

        });

        if (!isValid) {

            Swal.fire({
                icon: 'warning',
                title: 'Lengkapi Penilaian',
                text: 'Harap isi semua penilaian sebelum mengirim kuesioner.',
                confirmButtonColor: '#3085d6',
            });

            return;
        }

        document.getElementById('multiStepForm').submit();
    }

    const indikator = <?= json_encode($indikator) ?>;
    let detailIndex = 1;

    function ratingSelect(index, key, label) {
        let options = '<option value="">Pilih</option>';

        for (let i = 1; i <= 5; i++) {
            options += `<option value="${i}">${i}</option>`;
        }

        return `
            <div class="col-md-6 mb-3">
                <label>${label} (1 = Sangat Rendah, 5 = Sangat Tinggi)</label>
                <select class="form-select step2-required" name="details[${index}][${key}]">
                    ${options}
                </select>
            </div>
        `;
    }

    function addAlumniDetail() {
        const index = detailIndex++;
        const wrapper = document.createElement('div');

        wrapper.className = 'card mb-3 alumni-detail';
        wrapper.dataset.index = index;

        let ratingFields = '';
        Object.keys(indikator).forEach(key => {
            ratingFields += ratingSelect(index, key, indikator[key]);
        });

        wrapper.innerHTML = `
            <div class="card-header d-flex align-items-center justify-content-between">
                <strong>Alumni Dinilai #${index + 1}</strong>
                <button
                    type="button"
                    class="btn btn-outline-danger btn-sm"
                    onclick="removeAlumniDetail(this)">
                    <i class="bi bi-trash"></i>
                    Hapus
                </button>
            </div>
            <div class="card-body">
                <input type="hidden" name="details[${index}][alumni_id]" value="">

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Nama Pegawai yang Dinilai</label>
                        <input
                            type="text"
                            name="details[${index}][nama_pegawai_dinilai]"
                            class="form-control step2-required">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label>Tahun Lulus Pegawai</label>
                        <input
                            type="number"
                            name="details[${index}][tahun_lulus_pegawai]"
                            class="form-control"
                            min="1900"
                            max="2100">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label>Asal Program Studi</label>
                        <input
                            type="text"
                            name="details[${index}][asal_program_studi_pegawai]"
                            class="form-control">
                    </div>
                </div>

                <div class="row">${ratingFields}</div>

                <div class="mb-3">
                    <label>Bagaimana harapan Anda terhadap lulusan UMAHA?</label>
                    <textarea
                        name="details[${index}][harapan_lulusan_umaha]"
                        class="form-control"
                        rows="3"></textarea>
                </div>

                <div class="mb-0">
                    <label>Saran dan masukan untuk UMAHA</label>
                    <textarea
                        name="details[${index}][saran_umum]"
                        class="form-control"
                        rows="3"></textarea>
                </div>
            </div>
        `;

        document.getElementById('alumniDetails').appendChild(wrapper);
    }

    function removeAlumniDetail(button) {
        button.closest('.alumni-detail').remove();
    }
</script>
<?= $this->endSection() ?>
