<?php

namespace App\Models;


use CodeIgniter\Model as CodeIgniterModel;

class KonfigurasiModel extends CodeIgniterModel
{
    protected $table = 'konfigurasi';
    protected $primaryKey = 'id';
    protected $allowedFields = ['konfigurasi_name', 'konfigurasi_value'];

    // Untuk ambil data
    public function getData($parameter)
    {
        $builder = $this->table($this->table);
        $builder->where($parameter);
        $query = $builder->get()->getRowArray();
        return $query;
    }

    // untuk simpan dan update data
    public function updateData($data)
    {
        helper('global_fungsi_helper');
        $builder = $this->table($this->table);

        foreach ($data as $key => $value) {
            $data[$key] = purify($value);
        }
        if ($builder->save($data)) {
            return true;
        } else {
            return false;
        }
    }

    // public function saveData($data)
    // {
    //     helper('global_fungsi_helper');
    //     $builder = $this->table($this->table);

    //     foreach ($data as $key => $value) {
    //         $data[$key] = purify($value);
    //     }
    //     if ($builder->save($data)) {
    //         return true;
    //     } else {
    //         return false;
    //     }
    // }
}
