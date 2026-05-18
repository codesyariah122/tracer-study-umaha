<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PenggunaLulusanDetailModel;
use App\Models\PenggunaModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class KuesionerPengguna extends BaseController
{
    protected $penggunaModel;

    public function __construct()
    {
        $this->penggunaModel = new PenggunaModel();
    }

    private function groupedPenggunaSelect(): string
    {
        return '
            MIN(pengguna_lulusan.id) as id,
            MIN(pengguna_lulusan.alumni_id) as alumni_id,
            MIN(pengguna_lulusan.request_id) as request_id,
            MIN(TRIM(pengguna_lulusan.nama_perusahaan)) as nama_perusahaan,
            MAX(pengguna_lulusan.alamat_perusahaan) as alamat_perusahaan,
            MIN(TRIM(pengguna_lulusan.nama_pengisi)) as nama_pengisi,
            MIN(TRIM(pengguna_lulusan.jabatan_pengisi)) as jabatan_pengisi,
            MIN(TRIM(pengguna_lulusan.email_pengisi)) as email_pengisi,
            MAX(pengguna_lulusan.no_telp_pengisi) as no_telp_pengisi,
            pengguna_lulusan.tahun_merekrut,
            MAX(pengguna_lulusan.jumlah_lulusan_direkrut) as jumlah_lulusan_direkrut,
            MAX(pengguna_lulusan.created_at) as created_at,
            COUNT(
                DISTINCT CASE
                    WHEN pengguna_lulusan_detail.id IS NOT NULL
                        THEN CONCAT("detail-", pengguna_lulusan_detail.id)
                    WHEN pengguna_lulusan.alumni_id IS NOT NULL
                        THEN CONCAT("legacy-", pengguna_lulusan.id)
                    ELSE NULL
                END
            ) as total_alumni_dinilai
        ';
    }

    private function groupedPenggunaQuery()
    {
        return $this->penggunaModel
            ->select($this->groupedPenggunaSelect(), false)
            ->join(
                'pengguna_lulusan_detail',
                'pengguna_lulusan_detail.pengguna_id = pengguna_lulusan.id',
                'left'
            )
            ->groupBy('LOWER(TRIM(pengguna_lulusan.nama_perusahaan))', false)
            ->groupBy('LOWER(TRIM(COALESCE(pengguna_lulusan.nama_pengisi, "")))', false)
            ->groupBy('LOWER(TRIM(COALESCE(pengguna_lulusan.jabatan_pengisi, "")))', false)
            ->groupBy('LOWER(TRIM(COALESCE(pengguna_lulusan.email_pengisi, "")))', false)
            ->groupBy('pengguna_lulusan.tahun_merekrut');
    }

    private function getGroupedPenggunaRows(array $pengguna): array
    {
        $normalize = static fn ($value) => strtolower(trim((string) $value));

        $target = [
            'nama_perusahaan' => $normalize($pengguna['nama_perusahaan'] ?? ''),
            'nama_pengisi' => $normalize($pengguna['nama_pengisi'] ?? ''),
            'jabatan_pengisi' => $normalize($pengguna['jabatan_pengisi'] ?? ''),
            'email_pengisi' => $normalize($pengguna['email_pengisi'] ?? ''),
            'tahun_merekrut' => (string) ($pengguna['tahun_merekrut'] ?? ''),
        ];

        return array_values(array_filter(
            $this->penggunaModel
                ->orderBy('id', 'ASC')
                ->findAll(),
            static function ($row) use ($normalize, $target) {
                return $normalize($row['nama_perusahaan'] ?? '') === $target['nama_perusahaan']
                    && $normalize($row['nama_pengisi'] ?? '') === $target['nama_pengisi']
                    && $normalize($row['jabatan_pengisi'] ?? '') === $target['jabatan_pengisi']
                    && $normalize($row['email_pengisi'] ?? '') === $target['email_pengisi']
                    && (string) ($row['tahun_merekrut'] ?? '') === $target['tahun_merekrut'];
            }
        ));
    }

    // ============================================
    // ✅ 1. LIST DATA PENGGUNA LULUSAN
    // ============================================
    public function index()
    {
        $data['title'] = 'Data Pengguna Lulusan';
        $data['pengguna'] = $this->groupedPenggunaQuery()
            ->orderBy('created_at', 'DESC')
            ->findAll();

        return view('admin/kuesioner_pengguna/index', $data);
    }

    // ============================================
    // ✅ 2. HAPUS DATA
    // ============================================
    public function delete($id)
    {
        $pengguna = $this->penggunaModel->find($id);

        if (!$pengguna) {
            return redirect()
                ->to(base_url('admin/kuesioner-pengguna'))
                ->with('error', 'Data tidak ditemukan.');
        }

        $groupedIds = array_column($this->getGroupedPenggunaRows($pengguna), 'id');

        if ($groupedIds) {
            (new PenggunaLulusanDetailModel())
                ->whereIn('pengguna_id', $groupedIds)
                ->delete();

            $this->penggunaModel
                ->whereIn('id', $groupedIds)
                ->delete();
        }

        return redirect()
            ->to(base_url('admin/kuesioner-pengguna'))
            ->with('success', 'Data berhasil dihapus.');
    }

    public function detail($id)
    {
        $pengguna = $this->penggunaModel
            ->select('
            pengguna_lulusan.*,

            alumni.nama as nama_alumni,
            alumni.nim,
            alumni.email as email_alumni,
            alumni.no_hp,
            alumni.tahun_lulus as tahun_lulus_alumni,

            prodi.nama_prodi,
            prodi.jenjang,

            pengguna_request.token,
            pengguna_request.created_at as request_created_at,

            tracer_study.status_pekerjaan,
            tracer_study.institusi_bekerja,
            tracer_study.posisi_pekerjaan
        ')
            ->join(
                'alumni',
                'alumni.id = pengguna_lulusan.alumni_id',
                'left'
            )
            ->join(
                'prodi',
                'prodi.kode_prodi = alumni.program_studi',
                'left'
            )
            ->join(
                'pengguna_request',
                'pengguna_request.id = pengguna_lulusan.request_id',
                'left'
            )
            ->join(
                'tracer_study',
                'tracer_study.alumni_id = alumni.id',
                'left'
            )
            ->where('pengguna_lulusan.id', $id)
            ->first();

        if (!$pengguna) {

            throw new \CodeIgniter\Exceptions\PageNotFoundException(
                'Data tidak ditemukan'
            );
        }

        $groupedRows = $this->getGroupedPenggunaRows($pengguna);
        $groupedIds = array_column($groupedRows, 'id');

        $detailModel = new PenggunaLulusanDetailModel();
        $details = $detailModel
            ->select('
                pengguna_lulusan_detail.*,
                alumni.nim,
                alumni.nama as nama_alumni,
                alumni.tahun_lulus as tahun_lulus_alumni,
                prodi.nama_prodi,
                prodi.jenjang
            ')
            ->join(
                'alumni',
                'alumni.id = pengguna_lulusan_detail.alumni_id',
                'left'
            )
            ->join(
                'prodi',
                'prodi.kode_prodi = alumni.program_studi',
                'left'
            )
            ->whereIn('pengguna_lulusan_detail.pengguna_id', $groupedIds ?: [$id])
            ->orderBy('pengguna_lulusan_detail.id', 'ASC')
            ->findAll();

        $detailPenggunaIds = array_filter(array_column($details, 'pengguna_id'));

        foreach ($groupedRows as $row) {
            if (empty($row['alumni_id']) || in_array($row['id'], $detailPenggunaIds, true)) {
                continue;
            }

            $legacy = $this->penggunaModel
                ->select('
                    pengguna_lulusan.*,
                    alumni.nim,
                    alumni.nama as nama_alumni,
                    alumni.tahun_lulus as tahun_lulus_alumni,
                    prodi.nama_prodi,
                    prodi.jenjang
                ')
                ->join(
                    'alumni',
                    'alumni.id = pengguna_lulusan.alumni_id',
                    'left'
                )
                ->join(
                    'prodi',
                    'prodi.kode_prodi = alumni.program_studi',
                    'left'
                )
                ->where('pengguna_lulusan.id', $row['id'])
                ->first();

            if (!$legacy) {
                continue;
            }

            $details[] = [
                'pengguna_id' => $legacy['id'],
                'alumni_id' => $legacy['alumni_id'],
                'nama_pegawai_dinilai' => $legacy['nama_pegawai_dinilai'],
                'asal_program_studi_pegawai' => $legacy['asal_program_studi_pegawai'],
                'tahun_lulus_pegawai' => $legacy['tahun_lulus_pegawai'],
                'etika_kerja' => $legacy['etika_kerja'],
                'keahlian_profesional' => $legacy['keahlian_profesional'],
                'penguasaan_bahasa_asing' => $legacy['penguasaan_bahasa_asing'],
                'teknologi_informasi' => $legacy['teknologi_informasi'],
                'komunikasi' => $legacy['komunikasi'],
                'kerjasama' => $legacy['kerjasama'],
                'pengembangan_diri' => $legacy['pengembangan_diri'],
                'harapan_lulusan_umaha' => $legacy['harapan_lulusan_umaha'],
                'saran_umum' => $legacy['saran_umum'],
                'nim' => $legacy['nim'],
                'nama_alumni' => $legacy['nama_alumni'],
                'tahun_lulus_alumni' => $legacy['tahun_lulus_alumni'],
                'nama_prodi' => $legacy['nama_prodi'],
                'jenjang' => $legacy['jenjang'],
            ];
        }

        return view(
            'admin/kuesioner_pengguna/detail',
            [
                'pengguna' => $pengguna,
                'details' => $details,
            ]
        );
    }

    // ============================================
    // ✅ 3. EXPORT SEMUA
    // ============================================
    public function exportAll()
    {
        $detailModel = new PenggunaLulusanDetailModel();
        $data = $detailModel
            ->select('
                pengguna_lulusan_detail.*,
                pengguna_lulusan.nama_perusahaan,
                pengguna_lulusan.alamat_perusahaan,
                pengguna_lulusan.nama_pengisi,
                pengguna_lulusan.jabatan_pengisi,
                pengguna_lulusan.email_pengisi,
                pengguna_lulusan.no_telp_pengisi,
                pengguna_lulusan.tahun_merekrut,
                pengguna_lulusan.jumlah_lulusan_direkrut,
                pengguna_lulusan.created_at as pengguna_created_at
            ')
            ->join(
                'pengguna_lulusan',
                'pengguna_lulusan.id = pengguna_lulusan_detail.pengguna_id',
                'left'
            )
            ->orderBy('pengguna_lulusan.created_at', 'DESC')
            ->findAll();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Pengguna Lulusan');

        $headers = [
            'No',
            'Nama Perusahaan',
            'Alamat Perusahaan',
            'Nama Pengisi',
            'Jabatan Pengisi',
            'Email',
            'No Telp',
            'Tahun Merekrut',
            'Jumlah Lulusan Direkrut',
            'Nama Pegawai Dinilai',
            'Asal Program Studi Pegawai',
            'Tahun Lulus Pegawai',
            'Etika Kerja',
            'Keahlian Profesional',
            'Bahasa Asing',
            'Teknologi Informasi',
            'Komunikasi',
            'Kerjasama',
            'Pengembangan Diri',
            'Saran Umum',
            'Created At'
        ];

        $col = 'A';
        foreach ($headers as $h) {
            $sheet->setCellValue($col . '1', $h);
            $col++;
        }

        $row = 2;
        $no = 1;
        foreach ($data as $d) {
            $col = 'A';
            $sheet->setCellValue($col++ . $row, $no++);
            $sheet->setCellValue($col++ . $row, $d['nama_perusahaan']);
            $sheet->setCellValue($col++ . $row, $d['alamat_perusahaan']);
            $sheet->setCellValue($col++ . $row, $d['nama_pengisi']);
            $sheet->setCellValue($col++ . $row, $d['jabatan_pengisi']);
            $sheet->setCellValue($col++ . $row, $d['email_pengisi']);
            $sheet->setCellValue($col++ . $row, $d['no_telp_pengisi']);
            $sheet->setCellValue($col++ . $row, $d['tahun_merekrut']);
            $sheet->setCellValue($col++ . $row, $d['jumlah_lulusan_direkrut']);
            $sheet->setCellValue($col++ . $row, $d['nama_pegawai_dinilai']);
            $sheet->setCellValue($col++ . $row, $d['asal_program_studi_pegawai']);
            $sheet->setCellValue($col++ . $row, $d['tahun_lulus_pegawai']);
            $sheet->setCellValue($col++ . $row, $d['etika_kerja']);
            $sheet->setCellValue($col++ . $row, $d['keahlian_profesional']);
            $sheet->setCellValue($col++ . $row, $d['penguasaan_bahasa_asing']);
            $sheet->setCellValue($col++ . $row, $d['teknologi_informasi']);
            $sheet->setCellValue($col++ . $row, $d['komunikasi']);
            $sheet->setCellValue($col++ . $row, $d['kerjasama']);
            $sheet->setCellValue($col++ . $row, $d['pengembangan_diri']);
            $sheet->setCellValue($col++ . $row, $d['saran_umum']);
            $sheet->setCellValue($col++ . $row, $d['pengguna_created_at']);
            $row++;
        }

        foreach (range('A', $sheet->getHighestColumn()) as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ];
        $sheet->getStyle('A1:' . $sheet->getHighestColumn() . ($row - 1))->applyFromArray($styleArray);

        $filename = 'PenggunaLulusan_All_' . date('Ymd_His') . '.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment; filename=\"$filename\"");
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }

    // ============================================
    // ✅ 4. EXPORT SATU DATA
    // ============================================
    public function exportSingle($id)
    {
        $d = $this->penggunaModel->find($id);
        if (!$d) {
            return redirect()->to(base_url('admin/kuesioner-pengguna'))->with('error', 'Data tidak ditemukan.');
        }

        $groupedRows = $this->getGroupedPenggunaRows($d);
        $groupedIds = array_column($groupedRows, 'id');

        $detailModel = new PenggunaLulusanDetailModel();
        $details = $detailModel
            ->whereIn('pengguna_id', $groupedIds ?: [$id])
            ->orderBy('id', 'ASC')
            ->findAll();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Pengguna Lulusan');

        $fields = [
            'Nama Perusahaan' => $d['nama_perusahaan'],
            'Alamat Perusahaan' => $d['alamat_perusahaan'],
            'Nama Pengisi' => $d['nama_pengisi'],
            'Jabatan Pengisi' => $d['jabatan_pengisi'],
            'Email Pengisi' => $d['email_pengisi'],
            'No. Telp Pengisi' => $d['no_telp_pengisi'],
            'Tahun Merekrut' => $d['tahun_merekrut'],
            'Jumlah Lulusan Direkrut' => $d['jumlah_lulusan_direkrut'],
            'Etika Kerja' => $d['etika_kerja'],
            'Keahlian Profesional' => $d['keahlian_profesional'],
            'Penguasaan Bahasa Asing' => $d['penguasaan_bahasa_asing'],
            'Teknologi Informasi' => $d['teknologi_informasi'],
            'Komunikasi' => $d['komunikasi'],
            'Kerjasama' => $d['kerjasama'],
            'Pengembangan Diri' => $d['pengembangan_diri'],
            'Saran Umum' => $d['saran_umum'],
            'Created At' => $d['created_at']
        ];

        $row = 1;
        foreach ($fields as $label => $value) {
            $sheet->setCellValue('A' . $row, $label);
            $sheet->setCellValue('B' . $row, $value);
            $row++;
        }

        $row += 2;
        $sheet->setCellValue('A' . $row, 'Data Alumni/Pegawai yang Dinilai');
        $row++;

        $detailHeaders = [
            'Nama Pegawai',
            'Program Studi',
            'Tahun Lulus',
            'Etika',
            'Keahlian',
            'Bahasa Asing',
            'TI',
            'Komunikasi',
            'Kerjasama',
            'Pengembangan Diri',
            'Harapan',
            'Saran',
        ];

        $col = 'A';
        foreach ($detailHeaders as $header) {
            $sheet->setCellValue($col++ . $row, $header);
        }

        $row++;
        foreach ($details as $detail) {
            $col = 'A';
            $sheet->setCellValue($col++ . $row, $detail['nama_pegawai_dinilai']);
            $sheet->setCellValue($col++ . $row, $detail['asal_program_studi_pegawai']);
            $sheet->setCellValue($col++ . $row, $detail['tahun_lulus_pegawai']);
            $sheet->setCellValue($col++ . $row, $detail['etika_kerja']);
            $sheet->setCellValue($col++ . $row, $detail['keahlian_profesional']);
            $sheet->setCellValue($col++ . $row, $detail['penguasaan_bahasa_asing']);
            $sheet->setCellValue($col++ . $row, $detail['teknologi_informasi']);
            $sheet->setCellValue($col++ . $row, $detail['komunikasi']);
            $sheet->setCellValue($col++ . $row, $detail['kerjasama']);
            $sheet->setCellValue($col++ . $row, $detail['pengembangan_diri']);
            $sheet->setCellValue($col++ . $row, $detail['harapan_lulusan_umaha']);
            $sheet->setCellValue($col++ . $row, $detail['saran_umum']);
            $row++;
        }

        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);

        $filename = 'PenggunaLulusan_' . preg_replace('/[^A-Za-z0-9]/', '_', $d['nama_perusahaan']) . '.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment; filename=\"$filename\"");
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }
}
