<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class FinalisasiPenggunaLulusanMultiAlumni extends Migration
{
    public function up()
    {
        if (!$this->db->tableExists('pengguna_lulusan_detail')) {
            $this->forge->addField([
                'id' => [
                    'type'           => 'INT',
                    'constraint'     => 11,
                    'unsigned'       => true,
                    'auto_increment' => true,
                ],
                'pengguna_id' => [
                    'type'       => 'INT',
                    'constraint' => 11,
                    'unsigned'   => true,
                    'null'       => true,
                ],
                'alumni_id' => [
                    'type'       => 'INT',
                    'constraint' => 11,
                    'unsigned'   => true,
                    'null'       => true,
                ],
            ]);

            $this->forge->addKey('id', true);
            $this->forge->addKey('pengguna_id');
            $this->forge->addKey('alumni_id');
            $this->forge->createTable('pengguna_lulusan_detail');
        }

        $fields = [
            'nama_pegawai_dinilai' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'asal_program_studi_pegawai' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'tahun_lulus_pegawai' => [
                'type'       => 'INT',
                'constraint' => 4,
                'null'       => true,
            ],
            'etika_kerja' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'null'       => true,
            ],
            'keahlian_profesional' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'null'       => true,
            ],
            'penguasaan_bahasa_asing' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'null'       => true,
            ],
            'teknologi_informasi' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'null'       => true,
            ],
            'komunikasi' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'null'       => true,
            ],
            'kerjasama' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'null'       => true,
            ],
            'pengembangan_diri' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'null'       => true,
            ],
            'harapan_lulusan_umaha' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'saran_umum' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ];

        foreach ($fields as $name => $definition) {
            if (!$this->db->fieldExists($name, 'pengguna_lulusan_detail')) {
                $this->forge->addColumn('pengguna_lulusan_detail', [
                    $name => $definition,
                ]);
            }
        }
    }

    public function down()
    {
        $fields = [
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
            'created_at',
            'updated_at',
        ];

        foreach ($fields as $field) {
            if ($this->db->fieldExists($field, 'pengguna_lulusan_detail')) {
                $this->forge->dropColumn('pengguna_lulusan_detail', $field);
            }
        }
    }
}
