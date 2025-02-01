<?php
session_start();


$judul = "Data Jabatan";
include('../layout/header.php');
require_once('../../config.php');

$result = mysqli_query($connection, "SELECT * FROM jabatan ORDER BY id DESC")

?>

<!-- Page body -->
<div class="page-body">
  <div class="container-xl">

    <a href="<?= base_url('admin/data_jabatan/tambah.php') ?>" class="btn btn-primary"><span class="text"><i class="fa-solid fa-circle-plus"></i> Tambah Data</span></a>

    <a href=" <?= base_url('admin/data_jabatan/report.php') ?> " class="btn btn-primary"> <span class="text"> <i class="fas fa-download"></i> Export PDF </span> </a>

    <div class="row row-deck row-cards mt-2">

      <table class="table table-bordered">
        <tr class="text-center">
          <th>No.</th>
          <th>Nama Jabatan</th>
          <th>Aksi</th>
        </tr>

        <?php if (mysqli_num_rows($result) === 0): ?>
          <tr>
            <td colspan="3">Data Masih Kosong, Silahkan Tambahkan Data Baru</td>
          </tr>
        <?php else : ?>

          <?php $no = 1;
          while ($jabatan = mysqli_fetch_array($result)): ?>

            <tr class="text-center">
              <td><?= $no++ ?></td>
              <td><?= $jabatan['jabatan'] ?></td>
              <td class="text-center">
                <a href="<?= base_url('admin/data_jabatan/edit.php?id=' . $jabatan['id']) ?>" class="badge bg-primary">Edit</a>
                <a href="<?= base_url('admin/data_jabatan/hapus.php?id=' . $jabatan['id']) ?>" class="badge bg-danger tombol-hapus">Hapus</a>
              </td>
            </tr>

          <?php endwhile ?>

        <?php endif; ?>

      </table>

    </div>
  </div>
</div>

<?= include('../layout/footer.php') ?>