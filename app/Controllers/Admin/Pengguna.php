<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PenggunaModel;

class Pengguna extends BaseController
{
    public function index()
    {
        $model = new PenggunaModel();

        $data['list'] = $model
            ->select('
                nama_perusahaan,
                nama_pengisi,
                jabatan_pengisi,
                email_pengisi,
                no_telp_pengisi,
                tahun_merekrut,
                COUNT(alumni_id) as total_rekrut
            ')
            ->groupBy('
                nama_perusahaan,
                nama_pengisi,
                jabatan_pengisi,
                email_pengisi,
                no_telp_pengisi,
                tahun_merekrut
            ')
            ->orderBy('tahun_merekrut', 'DESC')
            ->findAll();

        return view('admin/pengguna_index', $data);
    }
}
