<?php
// app/Controllers/KuesionerPengguna.php
namespace App\Controllers;

use App\Models\{AlumniModel, LandingModel, PenggunaLulusanDetailModel};
use App\Models\PenggunaModel;

class KuesionerPengguna extends BaseController
{
    public function index($token = null)
    {
        $requestModel = new \App\Models\PenggunaRequestModel();

        $request = $requestModel
            ->where('token', $token)
            ->first();

        // =====================================================
        // TOKEN INVALID
        // =====================================================

        if (!$request) {

            return redirect()
                ->to('/')
                ->with(
                    'error',
                    'Link kuesioner tidak valid.'
                );
        }

        // =====================================================
        // SUDAH SUBMIT
        // =====================================================

        if ((int)$request['is_submitted'] === 1) {

            return redirect()
                ->to('/')
                ->with(
                    'error',
                    'Kuesioner pengguna sudah pernah diisi.'
                );
        }

        // =====================================================
        // TOKEN EXPIRED
        // =====================================================

        if (
            !empty($request['expired_at']) &&
            strtotime($request['expired_at']) < time()
        ) {

            return redirect()
                ->to('/')
                ->with(
                    'error',
                    'Link kuesioner sudah kadaluarsa.'
                );
        }

        $landing = new LandingModel();

        $data['landing'] = [

            'title' =>
            $landing->getValue('judul')
                ?? 'Tracer Study UMAHA',

            'subtitle' =>
            $landing->getValue('subjudul')
                ?? 'Jembatan antara kampus ...',

            'description' =>
            $landing->getValue('konten')
                ?? 'Dukung pengembangan kurikulum ...'
        ];

        $data['social_links'] =
            $landing->getSocialLinks();

        // =====================================================
        // REQUEST DATA
        // =====================================================

        $alumniModel = new AlumniModel();
        $data['alumniDinilai'] = $alumniModel
            ->select('alumni.*, prodi.nama_prodi')
            ->join('prodi', 'prodi.kode_prodi = alumni.program_studi', 'left')
            ->where('alumni.id', $request['alumni_id'])
            ->first();

        $data['request'] = $request;

        return view(
            'kuesioner_pengguna',
            $data
        );
    }

    public function simpan()
    {
        $penggunaModel = new PenggunaModel();
        $detailModel = new PenggunaLulusanDetailModel();

        if (!$this->validate([
            'nama_perusahaan' => 'required',
            'nama_pengisi'    => 'required',
            'jabatan_pengisi' => 'required',
            'tahun_merekrut'  => 'required|numeric',
            'jumlah_lulusan_direkrut' => 'required|numeric',
        ])) {

            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    'Form belum lengkap atau tidak valid.'
                );
        }

        $post = $this->request->getPost();
        $detailsInput = $post['details'] ?? [];

        $requestModel = new \App\Models\PenggunaRequestModel();

        $request = $requestModel
            ->where(
                'token',
                $this->request->getPost('token')
            )
            ->first();

        if (!$request) {

            return redirect()
                ->back()
                ->with(
                    'error',
                    'Token tidak valid.'
                );
        }

        // =====================================================
        // CEGAH DOUBLE SUBMIT
        // =====================================================

        if ((int)$request['is_submitted'] === 1) {

            return redirect()
                ->to('/')
                ->with(
                    'error',
                    'Kuesioner sudah pernah diisi.'
                );
        }

        $indikator = [
            'etika_kerja',
            'keahlian_profesional',
            'penguasaan_bahasa_asing',
            'teknologi_informasi',
            'komunikasi',
            'kerjasama',
            'pengembangan_diri',
        ];

        $details = [];

        foreach ($detailsInput as $detail) {
            $namaPegawai = trim($detail['nama_pegawai_dinilai'] ?? '');

            if ($namaPegawai === '') {
                continue;
            }

            foreach ($indikator as $field) {
                if (($detail[$field] ?? '') === '') {
                    return redirect()
                        ->back()
                        ->withInput()
                        ->with(
                            'error',
                            'Penilaian kompetensi setiap pegawai/alumni yang dinilai wajib lengkap.'
                        );
                }
            }

            $details[] = [
                'alumni_id' => !empty($detail['alumni_id'])
                    ? (int) $detail['alumni_id']
                    : null,
                'nama_pegawai_dinilai' => $namaPegawai,
                'asal_program_studi_pegawai' => trim(
                    $detail['asal_program_studi_pegawai'] ?? ''
                ),
                'tahun_lulus_pegawai' => !empty($detail['tahun_lulus_pegawai'])
                    ? (int) $detail['tahun_lulus_pegawai']
                    : null,
                'etika_kerja' => (int) $detail['etika_kerja'],
                'keahlian_profesional' => (int) $detail['keahlian_profesional'],
                'penguasaan_bahasa_asing' => (int) $detail['penguasaan_bahasa_asing'],
                'teknologi_informasi' => (int) $detail['teknologi_informasi'],
                'komunikasi' => (int) $detail['komunikasi'],
                'kerjasama' => (int) $detail['kerjasama'],
                'pengembangan_diri' => (int) $detail['pengembangan_diri'],
                'harapan_lulusan_umaha' => trim(
                    $detail['harapan_lulusan_umaha'] ?? ''
                ),
                'saran_umum' => trim($detail['saran_umum'] ?? ''),
            ];
        }

        if (!$details) {
            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    'Minimal satu pegawai/alumni UMAHA harus dinilai.'
                );
        }

        // =====================================================
        // SAVE KUESIONER
        // =====================================================

        // =====================================================
        // RELASI
        // =====================================================

        $firstDetail = $details[0];

        $data = [
            'nama_perusahaan' => $post['nama_perusahaan'],
            'alamat_perusahaan' => $post['alamat_perusahaan'] ?? null,
            'nama_pengisi' => $post['nama_pengisi'],
            'jabatan_pengisi' => $post['jabatan_pengisi'],
            'email_pengisi' => $post['email_pengisi'] ?? null,
            'no_telp_pengisi' => $post['no_telp_pengisi'] ?? null,
            'tahun_merekrut' => $post['tahun_merekrut'],
            'jumlah_lulusan_direkrut' => $post['jumlah_lulusan_direkrut'],
            'alumni_id' => $request['alumni_id'],
            'request_id' => $request['id'],
            'nama_pegawai_dinilai' => $firstDetail['nama_pegawai_dinilai'],
            'asal_program_studi_pegawai' => $firstDetail['asal_program_studi_pegawai'],
            'tahun_lulus_pegawai' => $firstDetail['tahun_lulus_pegawai'],
            'etika_kerja' => $firstDetail['etika_kerja'],
            'keahlian_profesional' => $firstDetail['keahlian_profesional'],
            'penguasaan_bahasa_asing' => $firstDetail['penguasaan_bahasa_asing'],
            'teknologi_informasi' => $firstDetail['teknologi_informasi'],
            'komunikasi' => $firstDetail['komunikasi'],
            'kerjasama' => $firstDetail['kerjasama'],
            'pengembangan_diri' => $firstDetail['pengembangan_diri'],
            'harapan_lulusan_umaha' => $firstDetail['harapan_lulusan_umaha'],
            'saran_umum' => $firstDetail['saran_umum'],
        ];

        // =====================================================
        // SAVE KUESIONER
        // =====================================================

        $db = \Config\Database::connect();
        $db->transStart();

        $penggunaId = $penggunaModel->insert($data, true);

        foreach ($details as &$detail) {
            $detail['pengguna_id'] = $penggunaId;
        }
        unset($detail);

        $detailModel->insertBatch($details);

        // =====================================================
        // UPDATE REQUEST STATUS
        // =====================================================

        $requestModel->update(
            $request['id'],
            [

                'is_submitted' => 1,

                'submitted_at' => date(
                    'Y-m-d H:i:s'
                ),
            ]
        );

        $db->transComplete();

        if (!$db->transStatus()) {
            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    'Kuesioner gagal disimpan. Silakan coba kembali.'
                );
        }

        return redirect()
            ->to('/')
            ->with(
                'success',
                'Terima kasih! Kuesioner pengguna telah disimpan.'
            );
    }
}
