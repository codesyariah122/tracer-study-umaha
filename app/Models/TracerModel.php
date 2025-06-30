<?php

namespace App\Models;

use CodeIgniter\Model;

class TracerModel extends Model
{
    protected $table = 'tracer_study';
    protected $allowedFields = [
        'alumni_id',
        'tahun_pengisian',
        'status_pekerjaan',
        'institusi_bekerja',
        'posisi_pekerjaan',
        'tahun_mulai_bekerja',
        'gaji_pertama',
        'tempat_kerja_kabupaten',
        'sektor_tempat_kerja',
        'sesuai_bidang',
        'dapat_kerja_sebelum_lulus',
        'cara_mendapat_kerja',
        'kepuasan_etika',
        'kepuasan_keahlian_bidan_ilmu',
        'kepuasan_bahasa_asing',
        'kepuasan_teknologi_informasi',
        'kepuasan_komunikasi',
        'kepuasan_kerjasama',
        'kepuasan_pengembangan_diri',
        'relevansi_kurikulum',
        'saran_kurikulum',
        'tahun_lulus',
        'tahun_masuk'
    ];
}
