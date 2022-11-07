<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PostModel;


class Socials extends BaseController
{
    function __construct()
    {
        $this->validation = \Config\Services::validation();
        $this->m_posts = new PostModel();
        helper('global_fungsi_helper');
        $this->halaman_controller = 'socials';
        $this->halaman_label = ' Socials';
    }

    function index()
    {
        $data = [];
        if ($this->request->getMethod() == 'post') {
            // kombinasi nama dan value
            // nama = set_sosial_twitter  dan value = link twitter
            $konfigurasi_name = 'set_socials_twitter';
            $dataSimpan = [
                'konfigurasi_value' => $this->request->getVar('set_socials_twitter')
            ];
            konfigurasi_set($konfigurasi_name, $dataSimpan);

            $konfigurasi_name = 'set_socials_facebook';
            $dataSimpan = [
                'konfigurasi_value' => $this->request->getVar('set_socials_facebook')
            ];
            konfigurasi_set($konfigurasi_name, $dataSimpan);

            $konfigurasi_name = 'set_socials_github';
            $dataSimpan = [
                'konfigurasi_value' => $this->request->getVar('set_socials_github')
            ];
            konfigurasi_set($konfigurasi_name, $dataSimpan);

            session()->setFlashdata('success', 'Data Berhasil disimpan');
            return redirect()->to('admin/' . $this->halaman_controller);
        }

        $konfigurasi_name = 'set_socials_twitter';

        $dataTwitter = konfigurasi_get($konfigurasi_name)['konfigurasi_value'];
        $konfigurasi_name = 'set_socials_facebook';
        $dataFacebook = konfigurasi_get($konfigurasi_name)['konfigurasi_value'];
        $konfigurasi_name = 'set_socials_github';
        $dataGithub = konfigurasi_get($konfigurasi_name)['konfigurasi_value'];



        $data = [
            'templateJudul' => "Halaman " . $this->halaman_label,
            'set_socials_twitter' => $dataTwitter,
            'set_socials_facebook' => $dataFacebook,
            'set_socials_github' => $dataGithub
        ];
        echo view('admin/V_template_header', $data);
        echo view('admin/V_socials', $data);
        echo view('admin/V_template_footer');
    }
}
