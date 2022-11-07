<?php
/*
* Masukkan variable
*/
$halaman = "article";
?>


<div class="card-header">
    <i class="fas fa-table me-1"></i>

    <?php echo $templateJudul ?>
</div>
<div class="card-body">
    <div class="row mb-3">
        <div class="col-lg-3 pb-1 pt-1">
            <form action="" method="get">
                <input type="text" value="<?= $katakunci ?>" placeholder="Kata kunci..." name="katakunci" class="form-control">
            </form>
        </div>
        <div class="col-lg-9 pb-1 pt-1 text-end">
            <a href="<?= site_url("admin/$halaman/tambah") ?>" class="btn btn-primary"> + Tambah</a>
        </div>
    </div>
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
    <table class="table table-bordered">
        <thead>
            <tr>
                <th class="col-1">No.</th>
                <th class="col-6">Judul</th>
                <th class="col-3">Tangal</th>
                <th class="col-2 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($record as $value) {
                $post_id = $value['post_id'];
                $link_edit = site_url("admin/$halaman/edit/" . $post_id);
                $link_delete = site_url("admin/$halaman/?aksi=hapus&post_id=$post_id")

            ?>
                <tr>
                    <td><?php echo $nomor++ ?></td>
                    <td><?php echo $value['post_title'] ?></td>
                    <td><?php echo tanggal_indonesia($value['post_time']) ?></td>
                    <td>
                        <a href="<?= $link_edit ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="<?= $link_delete ?>" onclick="return confirm('Yakin akan hapus data ini?')" class="btn btn-danger btn-sm">Del</a>
                    </td>
                </tr>
            <?php }
            ?>
        </tbody>
    </table>
    <?php echo $pager->links('dt', 'datatable') ?>
</div>