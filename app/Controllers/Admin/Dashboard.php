<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\TracerModel;
use App\Models\AlumniModel;
use App\Models\PerusahaanModel; // kalau ada model perusahaan
use App\Models\PenggunaLulusanDetailModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $tracer = new TracerModel();
        $alumni = new AlumniModel();

        $data['total_alumni'] = $alumni->countAll();
        $data['total_tracer'] = $tracer->countAll();

        // Persentase alumni yang sudah mengisi tracer
        $data['persentase_tracer'] = $data['total_alumni'] > 0
            ? round(($data['total_tracer'] / $data['total_alumni']) * 100, 1)
            : 0;

        // Pie chart status pekerjaan
        $data['grafik'] = [
            'bekerja' => $tracer->where('status_pekerjaan', 'bekerja')->countAllResults(),
            'wirausaha' => $tracer->where('status_pekerjaan', 'wirausaha')->countAllResults(),
            'belum_bekerja' => $tracer->where('status_pekerjaan', 'belum_bekerja')->countAllResults(),
            'studi_lanjut' => $tracer->where('status_pekerjaan', 'studi_lanjut')->countAllResults(),
        ];

        // Bar chart alumni per tahun kelulusan
        $tahun = $alumni->select('YEAR(tahun_lulus) as tahun, COUNT(*) as jumlah')
            ->groupBy('tahun')
            ->orderBy('tahun', 'ASC')
            ->findAll();
        $data['alumni_per_tahun'] = $tahun;

        // Top 5 perusahaan alumni bekerja
        $data['top_perusahaan'] = $tracer->select('institusi_bekerja, COUNT(*) as jumlah')
            ->groupBy('institusi_bekerja')
            ->orderBy('jumlah', 'DESC')
            ->limit(5)
            ->findAll();

        // =====================================================
        // Statistik Kuesioner Pengguna Lulusan
        // =====================================================

        $detailModel = new PenggunaLulusanDetailModel();

        $indikator = [
            'etika_kerja' => 'Etika',
            'keahlian_profesional' => 'Keahlian',
            'penguasaan_bahasa_asing' => 'Bahasa Asing',
            'teknologi_informasi' => 'Teknologi Informasi',
            'komunikasi' => 'Komunikasi',
            'kerjasama' => 'Kerjasama',
            'pengembangan_diri' => 'Pengembangan Diri',
        ];

        $totalRespon = (int) $detailModel->countAll();

        $distribusi = [
            'categories' => array_values($indikator),
            'series' => [],
            'hasData' => $totalRespon > 0,
        ];

        if ($totalRespon > 0) {

            $select = [];

            foreach ($indikator as $field => $label) {

                for ($score = 1; $score <= 5; $score++) {

                    $alias = $field . '_skor_' . $score;

                    $select[] =
                        "SUM(CASE WHEN {$field} = {$score} THEN 1 ELSE 0 END) AS {$alias}";
                }
            }

            $row = $detailModel
                ->select(implode(",", $select), false)
                ->first();

            $warna = [
                '#ef4444',
                '#f97316',
                '#eab308',
                '#22c55e',
                '#16a34a',
            ];

            for ($score = 1; $score <= 5; $score++) {

                $dataSkor = [];

                foreach ($indikator as $field => $label) {

                    $alias = $field . '_skor_' . $score;

                    $dataSkor[] = (int) ($row[$alias] ?? 0);
                }

                $distribusi['series'][] = [
                    'name' => (string) $score,
                    'data' => $dataSkor,
                    'color' => $warna[$score - 1] ?? null,
                ];
            }
        }

        $data['kuesioner_pengguna_distribusi_skor'] = $distribusi;

        // =====================================================
        // Pie Chart
        // =====================================================

        $pieSeries = [];

        if ($totalRespon > 0) {

            foreach ($indikator as $field => $label) {

                $avg = $detailModel
                    ->selectAvg($field, 'rata_rata')
                    ->first();

                $nilai = round((float) ($avg['rata_rata'] ?? 0), 2);

                $pieSeries[] = [
                    'name' => $label,
                    'y' => $nilai
                ];
            }
        }

        $data['kuesioner_pengguna_pie'] = [
            'hasData' => $totalRespon > 0,
            'series' => $pieSeries
        ];

        // =====================================================
        // Summary
        // =====================================================

        $indikatorTerbaik = '-';

        if (!empty($pieSeries)) {

            $maxNilai = max(array_column($pieSeries, 'y'));

            foreach ($pieSeries as $item) {

                if ($item['y'] == $maxNilai) {

                    $indikatorTerbaik = $item['name'];
                    break;
                }
            }
        }

        $data['summary_pengguna'] = [
            'total_responden' => $totalRespon,

            'rata_rata_global' => $totalRespon > 0
                ? round(array_sum(array_column($pieSeries, 'y')) / count($pieSeries), 2)
                : 0,

            'indikator_terbaik' => $indikatorTerbaik
        ];

        return view('admin/dashboard', $data);
    }
}
