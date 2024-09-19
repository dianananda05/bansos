<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\Files\UploadedFile;

class BansosController extends BaseController
{
    public function index()
    {
        // Mengirimkan data error, input sebelumnya, dan error jika ada
        $data = [
            'errors' => session()->getFlashdata('errors'),
            'error' => session()->getFlashdata('error'),
            'input' => session()->getFlashdata('_ci_old_input')
        ];
        return view('bansos_form', $data);
    }

    public function submit()
    {
        // Aturan validasi
        $validation = \Config\Services::validation();
        $validation->setRules([
            'nama' => 'required',
            'nik' => 'required|numeric|exact_length[16]',
            'no_kk' => 'required|numeric|exact_length[16]',
            'foto_ktp' => 'uploaded[foto_ktp]|mime_in[foto_ktp,image/jpg,image/jpeg,image/png]|max_size[foto_ktp,1024]',
            'foto_kk' => 'uploaded[foto_kk]|mime_in[foto_kk,image/jpg,image/jpeg,image/png]|max_size[foto_kk,1024]',
            'umur' => 'required|integer|greater_than_equal_to[21]',
            'jenis_kelamin' => 'required',
            'provinsi' => 'required',
            'kabupaten' => 'required',
            'kecamatan' => 'required',
            'kelurahan' => 'required',
            'alamat' => 'required|max_length[255]',
            'rt' => 'required',
            'rw' => 'required',
            'penghasilan_sebelum' => 'required|numeric',
            'penghasilan_setelah' => 'required|numeric',
            'alasan' => 'required'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        // Upload file KTP dan KK
        $fotoKTP = $this->request->getFile('foto_ktp');
        $fotoKK = $this->request->getFile('foto_kk');

        if ($fotoKTP->isValid() && !$fotoKTP->hasMoved() && $fotoKK->isValid() && !$fotoKK->hasMoved()) {
            try {
                $newNameKTP = $fotoKTP->getRandomName();
                $fotoKTP->move(WRITEPATH . 'uploads', $newNameKTP);

                $newNameKK = $fotoKK->getRandomName();
                $fotoKK->move(WRITEPATH . 'uploads', $newNameKK);
            } catch (\Exception $e) {
                log_message('error', 'File upload failed: ' . $e->getMessage());
                return redirect()->back()->withInput()->with('error', 'Gagal mengupload file. Silakan coba lagi.');
            }
        } else {
            return redirect()->back()->withInput()->with('error', 'File tidak valid. Silakan coba lagi.');
        }

        // Simulasi proses pengiriman data (untuk demo, selalu berhasil)
        $success = true;

        if ($success) {
            $data = $this->request->getPost();
            $data['foto_ktp'] = $newNameKTP;
            $data['foto_kk'] = $newNameKK;

            return view('bansos_preview', ['data' => $data]);
        } else {
            return redirect()->back()->withInput()->with('error', 'Pengiriman gagal, coba lagi.');
        }
    }
}