<?php

namespace App\Controllers;

use App\Models\AlumniModel;
use CodeIgniter\Controller;

class Auth extends BaseController
{
    public function login()
    {
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $alumniModel = new \App\Models\AlumniModel();
        $alumni = $alumniModel->where('email', $email)->first();

        if ($alumni && password_verify($password, $alumni['password'])) {
            session()->set([
                'alumni_id'   => $alumni['id'],
                'alumni_nama' => $alumni['nama'],
                'email'       => $alumni['email'],
                'logged_in'   => true,
            ]);
            return $this->response->setJSON([
                'success' => true,
                'redirect' => base_url('alumni/dashboard')
            ]);
        }

        return $this->response->setJSON(['success' => false, 'message' => 'Email atau Password salah']);
    }


    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('/'));
    }
}
