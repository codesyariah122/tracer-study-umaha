<?php

namespace App\Models;

use CodeIgniter\Model;

class PenggunaLulusanDetailModel extends Model
{
    protected $table = 'pengguna_lulusan_detail';

    protected $primaryKey = 'id';

    protected $allowedFields = [
        'pengguna_id',
        'alumni_id',
        'nama_pegawai_dinilai',
        'asal_program_studi_pegawai',
        'tahun_lulus_pegawai',
        'etika_kerja',
        'keahlian_profesional',
        'penguasaan_bahasa_asing',
        'teknologi_informasi',
        'komunikasi',
        'kerjasama',
        'pengembangan_diri',
        'harapan_lulusan_umaha',
        'saran_umum',
    ];

    protected $useTimestamps = true;
}
