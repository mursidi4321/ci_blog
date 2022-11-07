<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\AdminModel;


class Akun extends BaseController
{
    function __construct()
    {
        $this->validation = \Config\Services::validation();
        $this->m_admin = new AdminModel();
        helper('global_fungsi_helper');
        $this->halaman_controller = 'akun';
        $this->halaman_label = ' Akun';
    }

    function index()
    {
        $data = [];
        if ($this->request->getMethod() == 'post') {
            $data = $this->request->getVar();

            $nama_lengkap = $this->request->getVar('nama_lengkap');
            $password_lama = $this->request->getVar('password_lama');
            $password_baru = $this->request->getVar('password_baru');
            $konfirmasi_password_baru = $this->request->getVar('konfirmasi_password_baru');

            $aturan = [
                'nama_lengkap' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Nama lengkap harus diisi'
                    ]
                ]
            ];
            if ($password_baru != '') {
                $aturan = [
                    'password_lama' => [
                        'rules' => 'required|check_old_password[password_lama]',
                        'errors' => [
                            'required' => 'Password lama harus diisi',
                            'check_old_password' => 'Password lama tidak sesuai'
                        ]

                    ],
                    'password_baru' => [
                        'rules' => 'min_length[4]|alpha_numeric',
                        'errors' => [
                            'min_length' => 'Password minimal 4 karakter',
                            'alpha_numeric' => 'Angka, nomer dan karakter'
                        ]
                    ],
                    'konfirmasi_password_baru' => [
                        'rules' => 'matches[password_baru]',
                        'errors' => [
                            'matches' => 'Konfirmasi password baru tidak sesuai'
                        ]
                    ]
                ];
            }
            if (!$this->validate($aturan)) {
                session()->setFlashdata('warning', $this->validation->getErrors());
            } else {
                $dataUpdate = [
                    'email' => session()->get('akun_email'),
                    'nama_lengkap' => $nama_lengkap
                ];
                $this->m_admin->updateData($dataUpdate);

                /**
                 * Update sessionnya
                 */
                $sesi = [
                    'akun_nama_lengkap' => $nama_lengkap
                ];
                session()->set($sesi);

                // Update password jika diupadte
                if ($password_baru != '') {
                    $password_baru = password_hash($password_baru, PASSWORD_DEFAULT);
                    $dataUpdate = [
                        'email' => session()->get('akun_email'),
                        'password' => $password_baru
                    ];
                    $this->m_admin->updateData($dataUpdate);

                    // Update cookies juga jika remember me diaktifkan / cookies
                    helper("cookie");
                    if (get_cookie('cookie_password')) {
                        setcookie('cookie_username', session()->get('akun_username'), 3600 * 24 * 30);
                        setcookie('cookie_password', $password_baru, 3600 * 24 * 30);
                    }
                }
                session()->setFlashdata('success', 'Data berhasil diupdate');
            }
            return redirect()->to('admin/' . $this->halaman_controller)->withCookies();
        }

        $username = session()->get('akun_username');
        $dataPost = $this->m_admin->getData($username);

        $data = $dataPost;
        $data['templateJudul'] = 'Halaman Edit' . $this->halaman_label;

        echo view('admin/V_template_header', $data);
        echo view('admin/V_akun', $data);
        echo view('admin/V_template_footer');
    }
}
