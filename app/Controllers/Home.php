<?php

// app/Controllers/Home.php
namespace App\Controllers;

use App\Models\{TahunModel, SettingsModel};
use CodeIgniter\Controller;

class Home extends BaseController
{
    public function index()
    {
        $tahunModel = new TahunModel();
        $data['tahun_list'] = $tahunModel->getTahunUnik(); // ini benar
        $periodeModel = new \App\Models\PeriodeModel();
        $settingModel = new SettingsModel();
        $data['pdfLink'] = $settingModel->getValue('panduan_tracer') ?? '#';
        $data['menuItems'] = [
            [
                'icon' => 'bi-people-fill',
                'text' => 'KUESIONER TRACER STUDY',
                'link' => '#',
                'modal' => true
            ],
            [
                'icon' => 'bi-person-check-fill',
                'text' => 'KUESIONER PENGGUNA LULUSAN',
                'link' => base_url('/kuesioner/pengguna')
            ],
            [
                'icon' => 'bi-mortarboard-fill',
                'text' => 'REKAPITULASI DATA TRACER STUDY',
                'link' => base_url('/laporan/alumni')
            ],
            [
                'icon' => 'bi-building',
                'text' => 'REKAPITULASI DATA PENGGUNA LULUSAN',
                'link' => base_url('/laporan/pengguna')
            ],
        ];
        $data['periode_list'] = $periodeModel->orderBy('tahun', 'DESC')->findAll();
        return view('home', $data);
    }
}
