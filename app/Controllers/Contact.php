<?php

namespace App\Controllers;

use App\Models\PostModel;

class Contact extends BaseController
{
    function __construct()
    {
        $this->m_posts = new PostModel();
        helper('global_fungsi_helper');
        $this->validation =  \Config\Services::validation();
    }
    public function index()
    {
        $data = [];
        if ($this->request->getMethod() == 'post') {
            $data = $this->request->getVar();

            $aturan = [
                'kontak_nama' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Nama Harus diisi'
                    ]
                ],
                'kontak_email' => [
                    'rules' => 'required|valid_email',
                    'errors' => [
                        'required' => 'Email Harus diisi',
                        'valid_email' => 'Email tidak  valid'
                    ]
                ],
                'kontak_telp' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'No Telpon harus diisi'
                    ]
                ],
                'kontak_pesan' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Pesan harus diisi'
                    ]
                ]
            ];
            if (!$this->validate($aturan)) {
                session()->setFlashdata('warning', $this->validation->getErrors());
            } else {
                $attachment = '';
                $to = EMAIL_ALAMAT;
                $title = "Dari Halaman Kontak";
                $message = "Berikut ini adalah email baru yang masuk, lebih detailnya";
                $message .= "<br>";
                $message .= "<b>Nama :</b></br>";
                $message .= $data['kontak_nama'] . "</br>";
                $message .= "<b>Email</b></br>";
                $message .= $data['kontak_email'] . "</br>";
                $message .= "<b>Telepon</b></br>";
                $message .= $data['kontak_telp'] . "</br>";
                $message .= "<b>Pesan</b></br>";
                $message .= $data['kontak_pesan'] . "</br>";
                $message .= "------------------------------------</br>";
                $message .= "Silahkan segera dibalas";

                kirim_email($attachment, $to, $title, $message);

                session()->setFlashdata('success', 'Pesan sudah kami terima, silahkan tungu balasan kami');
                return redirect()->to('contact');
            }
        }

        /**
         * Dapatkan page_id dari konfigurasi untuk halaman depan
         */
        $konfigurasi_name = 'set_halaman_kontak';
        $konfigurasi = konfigurasi_get($konfigurasi_name);
        $page_id = $konfigurasi['konfigurasi_value'];

        /**Dapatkan data dari modelPost untu id = page_id */
        $dataHalaman = $this->m_posts->getPost($page_id);
        $data['type'] = $dataHalaman['post_type'];
        $data['judul'] = $dataHalaman['post_title'];
        $data['deskripsi'] = $dataHalaman['post_description'];
        $data['thumbnail'] = $dataHalaman['post_thumbnail'];
        $data['konten'] = $dataHalaman['post_content'];

        echo view('depan/v_template_header', $data);
        echo view('depan/v_contact', $data);
        echo view('depan/v_template_footer');
    }
}
