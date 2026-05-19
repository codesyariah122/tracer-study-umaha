<?php

// app/Controllers/Home.php
namespace App\Controllers;

use App\Models\{TahunModel, SettingsModel, LandingModel};
use CodeIgniter\Controller;

class Home extends BaseController
{
    public function index()
    {
        $tahunModel = new TahunModel();
        $landing      = new LandingModel();
        $data['tahun_list'] = $tahunModel->getTahunUnik(); // ini benar
        $periodeModel = new \App\Models\PeriodeModel();
        $settingModel = new SettingsModel();
        $data['pdfLink'] = $settingModel->getValue('panduan_tracer') ?? '#';
        $data['landing'] = [
            'title'       => $landing->getValue('judul')      ?? 'Tracer Study UMAHA',
            'subtitle'    => $landing->getValue('subjudul')   ?? 'Jembatan antara kampus ...',
            'description' => $landing->getValue('konten') ??
                'Dukung pengembangan kurikulum ...'
        ];

        // -------- social links ----------
        $data['social_links'] = $landing->getSocialLinks();

        $data['menuItems'] = [
            [
                'icon' => 'bi-people-fill',
                'text' => 'KUESIONER TRACER STUDY',
                'link' => '#',
                'modal' => true
            ],
            [
                'icon' => 'bi-person-fill-check',
                'text' => 'KUESIONER PENGGUNA LULUSAN',
                'link' => base_url('/kuesioner/pengguna')
            ],
            [
                'icon' => 'bi-mortarboard-fill',
                'text' => 'REKAPITULASI DATA TRACER STUDY',
                'link' => base_url('/laporan/alumni')
            ],
            [
                'icon' => 'bi-building-check',
                'text' => 'REKAPITULASI DATA PENGGUNA LULUSAN',
                'link' => base_url('/laporan/pengguna')
            ],
        ];

        foreach ($data['menuItems'] as &$item) {
            // hapus prefix 'bi-' jika perlu, sesuaikan nama file
            $iconFileName = str_replace('bi-', '', $item['icon']);
            $item['background'] = iconToBackground($iconFileName);
        }
        $data['periode_list'] = $periodeModel->orderBy('tahun', 'DESC')->findAll();

        // =====================================================
        // Grafik Distribusi Skor Kuesioner Pengguna Lulusan
        // =====================================================
        $detailModel = new \App\Models\PenggunaLulusanDetailModel();

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
            // Query: hitung jumlah skor 1..5 per indikator
            $select = [];
            foreach ($indikator as $field => $label) {
                for ($score = 1; $score <= 5; $score++) {
                    $alias = $field . '_skor_' . $score;
                    $select[] = "SUM(CASE WHEN {$field} = {$score} THEN 1 ELSE 0 END) AS {$alias}";
                }
            }

            $row = $detailModel->select(implode(",\n", $select), false)
                ->first();

            $warna = [
                '#ef4444',
                '#f97316',
                '#eab308',
                '#22c55e',
                '#16a34a',
            ];

            $labels = array_values($indikator);

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
        // Pie Chart - Rata-rata Penilaian Pengguna Lulusan
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
                    'y'    => $nilai
                ];
            }
        }

        $data['kuesioner_pengguna_pie'] = [
            'hasData' => $totalRespon > 0,
            'series'  => $pieSeries
        ];

        // =====================================================
        // Statistik Ringkas
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

        return view('home', $data);
    }
}
