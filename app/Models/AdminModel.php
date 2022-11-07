<?php

namespace App\Models;


use CodeIgniter\Model as CodeIgniterModel;

class AdminModel extends CodeIgniterModel
{
    protected $table = 'admin';
    protected $primaryKey = 'email';
    protected $allowedFields = ['username', 'password', 'nama_lengkap', 'token'];

    // Untuk ambil data
    public function getData($parameter)
    {
        $builder = $this->table($this->table);
        $builder->where('username=', $parameter);
        $builder->orwhere('email=', $parameter);
        $query = $builder->get();
        return $query->getRowArray();
    }

    // untuk simpan dan update data
    public function updateData($data)
    {
        $builder = $this->table($this->table);
        if ($builder->save($data)) {
            return true;
        } else {
            return false;
        }
    }
}
