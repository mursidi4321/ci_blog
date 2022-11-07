<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PostModel;


class Article extends BaseController
{
    function __construct()
    {
        $this->validation = \Config\Services::validation();
        $this->m_posts = new PostModel();
        helper('global_fungsi_helper');
        $this->halaman_controller = 'article';
        $this->halaman_label = ' Artikel';
    }

    function index()
    {
        $data = [];
        // proses delete post
        if ($this->request->getVar('aksi') == 'hapus' && $this->request->getVar('post_id')) {
            $dataPost = $this->m_posts->getPost($this->request->getVar('post_id'));
            if ($dataPost['post_id']) {
                // menghapus thumbnailnya
                @unlink(LOKASI_UPLOAD . "/" . $dataPost['post_thumbnail']);
                $aksi = $this->m_posts->deletePost($this->request->getVar('post_id')); // hapus data lewat model
                if ($aksi == true) {
                    session()->setFlashdata('success', 'Data berhasil dihapus');
                } else {
                    session()->setFlashdata('warning', ['Gagal menghapus data']);
                }
            }
            return redirect()->to('admin/' . $this->halaman_controller);
        }
        // Proses tampil data
        $data = [
            'templateJudul' => "Halaman " . $this->halaman_label
        ];

        $post_type = $this->halaman_controller;
        $jumlahBaris = 5;
        $katakunci = $this->request->getVar('katakunci');
        $group_dataset = 'dt';

        $hasil = $this->m_posts->listPost($post_type, $jumlahBaris, $katakunci, $group_dataset);

        $data['record'] = $hasil['record'];
        $data['pager'] = $hasil['pager'];
        $data['katakunci'] = $katakunci;

        $currentPage = $this->request->getVar('page_dt');
        $data['nomor'] = nomor($currentPage, $jumlahBaris);

        echo view('admin/V_template_header', $data);
        echo view('admin/V_article', $data);
        echo view('admin/V_template_footer');
    }

    function tambah()
    {
        $data = array();
        if ($this->request->getMethod() == 'post') {
            $data = $this->request->getVar();
            $rules = [
                'post_title' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Judul harus diisi'
                    ]
                ],
                'post_content' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Konten harus diisi'
                    ]
                ],
                'post_thumbnail' => [
                    'rules' => 'is_image[post_thumbnail]',
                    'errors' => [
                        'is_image' => 'Hanya gambar yang boleh diupload'
                    ]
                ]
            ];
            $file = $this->request->getFile('post_thumbnail');
            if (!$this->validate($rules)) {
                session()->setFlashdata('warning', $this->validation->getErrors());
            } else {
                $post_thumbnail = '';
                if ($file->getName()) {
                    $post_thumbnail = $file->getRandomName();
                }
                $record = [
                    'username' => session()->get('akun_username'),
                    'post_title' => $this->request->getVar('post_title'),
                    'post_status' => $this->request->getVar('post_status'),
                    'post_thumbnail' => $post_thumbnail,
                    'post_description' => $this->request->getVar('post_description'),
                    'post_content' => $this->request->getVar('post_content')

                ];
                $post_type = $this->halaman_controller;
                $aksi = $this->m_posts->insertPost($record, $post_type);
                if ($aksi != false) {
                    $page_id = $aksi;
                    if ($file->getName()) {
                        $lokasi_direktori = LOKASI_UPLOAD; // diambil dari constant.php
                        $file->move($lokasi_direktori, $post_thumbnail);
                    }
                    session()->setFlashdata('success', 'Data berhasil disimpan');
                    return redirect()->to('admin/' . $this->halaman_controller . '/tambah');
                } else {
                    session()->setFlashdata('warning', ['Gagal memasukkan data']);
                    return redirect()->to('admin/' . $this->halaman_controller . '/tambah');
                }
            }
        }

        $data['templateJudul'] = 'Halaman Tambah' . $this->halaman_label;
        echo view('admin/V_template_header', $data);
        echo view('admin/V_article_tambah', $data);
        echo view('admin/V_template_footer');
    }

    function edit($post_id)
    {
        $data = [];
        $dataPost = $this->m_posts->getPost($post_id);

        if (empty($dataPost)) {
            return redirect()->to('admin/' . $this->halaman_controller);
        }
        $data = $dataPost;

        if ($this->request->getMethod() == 'post') {
            $data = $this->request->getVar();
            $rules = [
                'post_title' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Judul harus diisi'
                    ]
                ],
                'post_content' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Konten harus diisi'
                    ]
                ],
                'post_thumbnail' => [
                    'rules' => 'is_image[post_thumbnail]',
                    'errors' => [
                        'is_image' => 'Hanya gambar yang boleh diupload'
                    ]
                ]
            ];
            $file = $this->request->getFile('post_thumbnail');
            if (!$this->validate($rules)) {
                session()->setFlashdata('warning', $this->validation->getErrors());
            } else {
                $post_thumbnail = $dataPost['post_thumbnail'];
                if ($file->getName()) {
                    $post_thumbnail = $file->getRandomName();
                }
                $record = [
                    'username' => session()->get('akun_username'),
                    'post_title' => $this->request->getVar('post_title'),
                    'post_status' => $this->request->getVar('post_status'),
                    'post_thumbnail' => $post_thumbnail,
                    'post_description' => $this->request->getVar('post_description'),
                    'post_content' => $this->request->getVar('post_content'),
                    'post_id' => $post_id // untuk primary key fungsi edit
                ];

                $post_type = $this->halaman_controller;
                $aksi = $this->m_posts->updatePost($record, $post_type);

                $page_id = $aksi;
                if ($aksi != false) {
                    if ($file->getName()) {
                        if ($dataPost['post_thumbnail']) {
                            @unlink(LOKASI_UPLOAD . "/" . $dataPost['post_thumbnail ']);
                        }

                        $lokasi_direktori = LOKASI_UPLOAD; // diambil dari constant.php
                        $file->move($lokasi_direktori, $post_thumbnail);
                    }
                    session()->setFlashdata('success', 'Data berhasil Diupdate');
                    return redirect()->to('admin/' . $this->halaman_controller . '/edit/' . $page_id);
                } else {
                    session()->setFlashdata('warning', ['Gagal update data']);
                    return redirect()->to('admin/' . $this->halaman_controller . '/edit/' . $page_id);
                }
            }
        }

        $data['templateJudul'] = 'Halaman Edit' . $this->halaman_label;


        echo view('admin/V_template_header', $data);
        echo view('admin/V_article_tambah', $data);
        echo view('admin/V_template_footer');
    }
}
