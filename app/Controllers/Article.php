<?php

namespace App\Controllers;

use App\Models\PostModel;

class Article extends BaseController
{
    function __construct()
    {
        $this->m_posts = new PostModel();
        helper('global_fungsi_helper');
    }
    public function index($seo_title)
    {
        $data = [];

        $dataHalaman = $this->m_posts->getDataBySeo($seo_title, true);
        if (!isset($dataHalaman)) {
            return redirect()->to('');
        }

        $data = [
            'judulHalaman' => 'Artikel',
            'type' => $dataHalaman['post_type'],
            'judul' => $dataHalaman['post_title'],
            'thumbnail' => $dataHalaman['post_thumbnail'],
            'deskripsi' => $dataHalaman['post_description'],
            'konten' => $dataHalaman['post_content'],
            'penulis' => $dataHalaman['username'],
            'tanggal' => $dataHalaman['post_time'],
        ];


        echo view('depan/v_template_header', $data);
        echo view('depan/v_article', $data);
        echo view('depan/v_template_footer');
    }
}
