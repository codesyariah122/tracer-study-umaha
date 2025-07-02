<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\KuesionerFieldModel;

class KuesionerFields extends BaseController
{
    protected $fieldModel;

    public function __construct()
    {
        $this->fieldModel = new KuesionerFieldModel();
    }

    public function index()
    {
        $data['fields'] = $this->fieldModel->orderBy('step')->orderBy('order')->findAll();
        return view('admin/kuesioner_fields/index', $data);
    }

    public function create()
    {
        return view('admin/kuesioner_fields/create');
    }

    public function store()
    {
        $post = $this->request->getPost();

        // Validasi sederhana
        if (!$this->validate([
            'field_name' => 'required|alpha_dash|is_unique[kuesioner_fields.field_name]',
            'label'      => 'required',
            'type'       => 'required',
            'step'       => 'required|in_list[1,2]',
            'order'      => 'required|numeric',
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }


        // Jika tipe select wajib isi options
        if ($post['type'] === 'select') {
            if (empty($post['source_table']) && empty($post['options'])) {
                return redirect()->back()->withInput()->with('error', 'Options wajib diisi jika Source Table kosong untuk tipe select');
            }

            if (!empty($post['options'])) {
                $decoded = json_decode($post['options'], true);
                if (json_last_error() !== JSON_ERROR_NONE || !is_array($decoded)) {
                    return redirect()->back()->withInput()->with('error', 'Options harus berupa JSON array yang valid');
                }
            }
        }

        $this->fieldModel->save([
            'field_name' => $post['field_name'],
            'label'      => $post['label'],
            'header'       => $post['header'] ?? null,
            'type'       => $post['type'],
            'options'    => $post['options'] ?? null,
            'required'   => isset($post['required']) ? true : false,
            'step'       => $post['step'],
            'order'      => $post['order'],
            'source_table' => $post['source_table'] ?? null,
        ]);

        return redirect()->to('/admin/kuesionerfields')->with('success', 'Field berhasil ditambahkan');
    }

    // Tambah fungsi edit, update, delete sesuai kebutuhan
}
