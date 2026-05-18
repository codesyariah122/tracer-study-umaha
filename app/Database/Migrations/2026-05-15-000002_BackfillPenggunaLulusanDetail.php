<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class BackfillPenggunaLulusanDetail extends Migration
{
    public function up()
    {
        if (
            !$this->db->tableExists('pengguna_lulusan') ||
            !$this->db->tableExists('pengguna_lulusan_detail')
        ) {
            return;
        }

        $this->db->query("
            INSERT INTO pengguna_lulusan_detail (
                pengguna_id,
                alumni_id,
                nama_pegawai_dinilai,
                asal_program_studi_pegawai,
                tahun_lulus_pegawai,
                etika_kerja,
                keahlian_profesional,
                penguasaan_bahasa_asing,
                teknologi_informasi,
                komunikasi,
                kerjasama,
                pengembangan_diri,
                harapan_lulusan_umaha,
                saran_umum,
                created_at,
                updated_at
            )
            SELECT
                pengguna_lulusan.id,
                pengguna_lulusan.alumni_id,
                COALESCE(pengguna_lulusan.nama_pegawai_dinilai, alumni.nama),
                COALESCE(pengguna_lulusan.asal_program_studi_pegawai, prodi.nama_prodi),
                COALESCE(pengguna_lulusan.tahun_lulus_pegawai, alumni.tahun_lulus),
                pengguna_lulusan.etika_kerja,
                pengguna_lulusan.keahlian_profesional,
                pengguna_lulusan.penguasaan_bahasa_asing,
                pengguna_lulusan.teknologi_informasi,
                pengguna_lulusan.komunikasi,
                pengguna_lulusan.kerjasama,
                pengguna_lulusan.pengembangan_diri,
                pengguna_lulusan.harapan_lulusan_umaha,
                pengguna_lulusan.saran_umum,
                pengguna_lulusan.created_at,
                NOW()
            FROM pengguna_lulusan
            LEFT JOIN alumni ON alumni.id = pengguna_lulusan.alumni_id
            LEFT JOIN prodi ON prodi.kode_prodi = alumni.program_studi
            WHERE pengguna_lulusan.alumni_id IS NOT NULL
            AND NOT EXISTS (
                SELECT 1
                FROM pengguna_lulusan_detail
                WHERE pengguna_lulusan_detail.pengguna_id = pengguna_lulusan.id
            )
        ");
    }

    public function down()
    {
        if (!$this->db->tableExists('pengguna_lulusan_detail')) {
            return;
        }

        $this->db->query("
            DELETE pengguna_lulusan_detail
            FROM pengguna_lulusan_detail
            JOIN pengguna_lulusan
                ON pengguna_lulusan.id = pengguna_lulusan_detail.pengguna_id
            WHERE pengguna_lulusan_detail.created_at = pengguna_lulusan.created_at
        ");
    }
}
