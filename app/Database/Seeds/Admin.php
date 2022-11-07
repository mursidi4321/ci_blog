<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Admin extends Seeder
{
    public function run()
    {
        //
        $data = array(
            'username' => 'admin',
            'password' => password_hash('1234', PASSWORD_DEFAULT),
            'nama_lengkap' => 'Mursidi Omahengendi',
            'email' => 'mursidi@gmail.com',
        );
        $this->db->table('admin')->insert($data);
    }
}
