<?php
session_start();

if (!isset($_SESSION["login"])) {
    header("Location: ../../auth/login.php?pesan=belum_login");
    exit;
} else if ($_SESSION["role"] != 'admin') {
    header("Location: ../../auth/login.php?pesan=tolak_akses");
    exit;
}

$judul = "Detail Pegawai";
include('../layout/header.php');
require_once('../../config.php');

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$result = mysqli_query($connection, "SELECT users.id_pegawai, users.username, users.password, users.status, users.role, 
          pegawai.* FROM users JOIN pegawai ON users.id_pegawai = pegawai.id WHERE pegawai.id=$id ");
?>

<?php while ($pegawai = mysqli_fetch_array($result)) : ?>

    <!-- Page body -->
    <div class="page-body">
        <div class="container-xl">
            <div class="row">
                <!-- Kolom Kiri: Tabel Informasi -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-4">Informasi Pegawai</h4>
                            <table class="table table-striped">
                                <tr>
                                    <td><strong>Nama</strong></td>
                                    <td>: <?= htmlspecialchars($pegawai['nama']) ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Jenis Kelamin</strong></td>
                                    <td>: <?= htmlspecialchars($pegawai['jenis_kelamin']) ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Alamat</strong></td>
                                    <td>: <?= htmlspecialchars($pegawai['alamat']) ?></td>
                                </tr>
                                <tr>
                                    <td><strong>No. Handphone</strong></td>
                                    <td>: <?= htmlspecialchars($pegawai['no_handphone']) ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Jabatan</strong></td>
                                    <td>: <?= htmlspecialchars($pegawai['jabatan']) ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Username</strong></td>
                                    <td>: <?= htmlspecialchars($pegawai['username']) ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Role</strong></td>
                                    <td>: <?= htmlspecialchars($pegawai['role']) ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Status</strong></td>
                                    <td>: <?= htmlspecialchars($pegawai['status']) ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Kolom Kanan: Foto Pegawai -->
                <div class="col-md-6 d-flex justify-content-center align-items-center">
                    <div>
                        <img src="<?= base_url('assets/img/foto_pegawai/' . htmlspecialchars($pegawai['foto'])) ?>"
                            alt="Foto Pegawai"
                            class="img-fluid rounded shadow-sm"
                            style="max-width: 320px; height: auto;">
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php endwhile; ?>

<?php include('../layout/footer.php'); ?>