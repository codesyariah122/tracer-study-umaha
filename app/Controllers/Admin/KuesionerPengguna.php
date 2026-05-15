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

    // ============================================
    // ✅ 1. LIST DATA PENGGUNA LULUSAN
    // ============================================
    public function index()
    {
        $data['title'] = 'Data Pengguna Lulusan';
        $data['pengguna'] = $this->penggunaModel
            ->select('
                pengguna_lulusan.*,
                (
                    SELECT COUNT(*)
                    FROM pengguna_lulusan_detail
                    WHERE pengguna_lulusan_detail.pengguna_id = pengguna_lulusan.id
                ) as total_alumni_dinilai
            ')
            ->orderBy('pengguna_lulusan.created_at', 'DESC')
            ->findAll();

        return view('admin/kuesioner_pengguna/index', $data);
    }

    // ============================================
    // ✅ 2. HAPUS DATA
    // ============================================
    public function delete($id)
    {
        $this->penggunaModel->delete($id);
        return redirect()->to(base_url('admin/pengguna'))->with('success', 'Data berhasil dihapus.');
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
            ->where('pengguna_lulusan_detail.pengguna_id', $id)
            ->findAll();

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
            return redirect()->to(base_url('admin/pengguna'))->with('error', 'Data tidak ditemukan.');
        }

        $detailModel = new PenggunaLulusanDetailModel();
        $details = $detailModel
            ->where('pengguna_id', $id)
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
