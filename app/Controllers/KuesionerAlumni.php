<?php

namespace App\Controllers;

use App\Models\AlumniModel;
use App\Models\TracerModel;
use CodeIgniter\Controller;

class KuesionerAlumni extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }
    public function index()
    {
        $id = session()->get('alumni_id');

        $builder = $this->db->table('alumni');
        $builder->select('alumni.*, prodi.nama_prodi, prodi.jenjang');
        $builder->join('prodi', 'prodi.kode_prodi = alumni.program_studi', 'left');
        $builder->where('alumni.id', $id);
        $query = $builder->get();
        $data['alumni'] = $query->getRowArray();
        return view('kuesioner_alumni', $data);
    }

    public function simpan()
    {
        $tracerModel = new \App\Models\TracerModel();

        if (!$this->validate([
            'status_pekerjaan' => 'required',
            'tahun_pengisian' => 'required|numeric',
        ])) {
            return redirect()->back()->withInput()->with('error', 'Isian wajib belum lengkap.');
        }

        $data = $this->request->getPost();
        $data['alumni_id'] = session()->get('alumni_id');
        $tracerModel->save($data);

        return redirect()->to('/')->with('success', 'Data tracer berhasil disimpan.');
    }
}
