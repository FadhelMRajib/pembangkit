<?php
ob_start();
session_start();

if (!isset($_SESSION["login"])) {
    header("Location: ../../auth/login.php?pesan=belum_login");
} else if ($_SESSION["role"] != 'pegawai') {
    header("Location: ../../auth/login.php?pesan=tolak_akses");
}

$judul = 'Relokasi Mesin';
include('../layout/header.php');
include_once("../../config.php");

// Perbaikan query - menggunakan id_pegawai bukan id
$id = $_SESSION['id'];
$result = mysqli_query($connection, "SELECT * FROM relokasi_mesin WHERE id_pegawai = '$id' ORDER BY id DESC");

?>

<!-- Page body -->
<div class="page-body">
    <div class="container-xl">
        <a href="<?= base_url('pegawai/data_relokasi/pengajuan_relokasi.php') ?>" class="btn btn-primary">
            Tambah Data
        </a>
        <table class="table table-bordered mt-3">
            <tr class="text-center">
                <th>No.</th>
                <th>Tanggal</th>
                <th>Kota</th>
                <th>Keterangan</th>
                <th>File</th>
                <th>Status Pengajuan</th>
                <th>Aksi</th>
            </tr>

            <?php if (mysqli_num_rows($result) === 0) { ?>
                <tr>
                    <td colspan="7" class="text-center">Data Relokasi Mesin Masih Kosong</td>
                </tr>
            <?php } else { ?>
                <?php $no = 1;
                while ($data = mysqli_fetch_array($result)) : ?>
                    <tr class="text-center">
                        <td><?= $no++ ?></td>
                        <td><?= date('d F Y', strtotime($data['tanggal'])) ?></td>
                        <td><?= $data['kota'] ?></td>
                        <td><?= $data['keterangan'] ?></td>
                        <td>
                            <a target="_blank" href="<?= base_url('assets/file_relokasimesin/' . $data['file']) ?>" class="badge badge-pill bg-primary">
                                Download
                            </a>
                        </td>
                        <td><?= $data['status_pengajuan'] ?></td>
                        <td>
                            <a href="edit.php?id=<?= $data['id'] ?>" class="badge badge-pill bg-success">Update</a>
                            <a href="hapus.php?id=<?= $data['id'] ?>" class="badge badge-pill bg-danger tombol-hapus">Hapus</a>
                        </td>
                    </tr>
                <?php endwhile ?>
            <?php } ?>
        </table>
    </div>
</div>

<?php include('../layout/footer.php'); ?>