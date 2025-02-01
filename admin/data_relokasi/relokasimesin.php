<?php
session_start();


$judul = "Data Pengajuan Relokasi Mesin";
include('../layout/header.php');
require_once('../../config.php');

$result = mysqli_query($connection, "SELECT * FROM relokasi_mesin ORDER BY id DESC");

?>



<!-- Page body -->
<div class="page-body">
    <div class="container-xl">

        <a href=" <?= base_url('admin/data_relokasi/report.php') ?> " class="btn btn-primary"> <span class="text"> <i class="fas fa-download"></i> Export PDF </span> </a>

        <table class="table table-bordered mt-3">
            <tr class="text-center">
                <th>No.</th>
                <th>Tanggal</th>
                <th>Kota</th>
                <th>keterangan</th>
                <th>File</th>
                <th>Status Pengajuan</th>
            </tr>

            <?php if (mysqli_num_rows($result) === 0) { ?>
                <tr>
                    <td colspan="7">Data Relokasi Mesin Masih Kosong</td>
                </tr>
            <?php } else { ?>
                <?php $no = 1;
                while ($data = mysqli_fetch_array($result)) : ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= date('d F Y', strtotime($data['tanggal'])) ?></td>
                        <td><?= $data['kota'] ?></td>
                        <td><?= $data['keterangan'] ?></td>
                        <td class="text-center">
                            <a target="_blank" href="<?= base_url('assets/file_relokasimesin/' . $data['file']) ?>" class="badge badge-pill bg-primary">
                                Download
                            </a>
                        </td>
                        <td class="text-center">
                            <?php if ($data['status_pengajuan'] == 'PENDING') : ?>
                                <a class="badge badge-pill bg-warning" href="<?= base_url('admin/data_relokasi/detail.php?id=' . $data['id']) ?>">PENDING</a>
                            <?php elseif ($data['status_pengajuan'] == 'REJECTED') : ?>
                                <a class="badge badge-pill bg-danger" href="<?= base_url('admin/data_relokasi/detail.php?id=' . $data['id']) ?>">REJECTED</a>
                            <?php else : ?>
                                <a class="badge badge-pill bg-success" href="<?= base_url('admin/data_relokasi/detail.php?id=' . $data['id']) ?>">APPROVED</a>
                            <?php endif ?>
                        </td>

                    </tr>

                <?php endwhile ?>
            <?php } ?>

        </table>
    </div>
</div>

<?php include('../layout/footer.php'); ?>