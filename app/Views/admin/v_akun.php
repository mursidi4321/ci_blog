<div class="card-header">
    <i class="fas fa-table me-1"></i>
    <?php echo $templateJudul ?>
</div>
<div class="card-body">
    <?php
    $session = \Config\Services::session();
    if ($session->getFlashdata('warning')) {
    ?>
        <div class="alert alert-warning">
            <ul>
                <?php foreach ($session->getFlashdata('warning') as $val) {
                ?>
                    <li><?php echo $val ?></li>
                <?php
                } ?>
            </ul>
        </div>
    <?php
    }
    if ($session->getFlashdata('success')) {
    ?>
        <div class="alert alert-success"><?php echo $session->getFlashdata('success') ?></div>
    <?php
    }
    ?>
    <form action="" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="input_nama_lengkap" class="form-label">Nama Lengkap</label>
            <input type="text" class="form-control" name="nama_lengkap" id="input_nama_lengkap" value="<?php echo (isset($nama_lengkap)) ? $nama_lengkap : null ?>">

        </div>
        <div class="col-lg-6 mb-3">
            <h5>Ganti Password</h5>
        </div>
        <div class="mb-3">
            <label for="input_password_lama" class="form-label">Password Lama</label>
            <input id="input_password_lama" type="password" class="form-control" name="password_lama" />
        </div>
        <div class="row mb-3">
            <div class="col-lg-6">
                <label for="input_password_baru" class="form-label">Password Baru</label>
                <input id="input_password_baru" type="password" class="form-control" name="password_baru" />
            </div>
            <div class="col-lg-6">
                <label for="input_konfirmasi_password_baru" class="form-label">Konfirmasi Password Baru</label>
                <input id="input_konfirmasi_password_baru" type="password" class="form-control" name="konfirmasi_password_baru" />
            </div>
        </div>

        <div>
            <input type="submit" name="submit" value="Simpan Data" class="btn btn-primary">

        </div>
    </form>
</div>