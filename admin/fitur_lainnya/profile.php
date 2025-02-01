<?php
session_start();

$judul = "Profile";
include('../layout/header.php');
require_once('../../config.php');

$id = $_SESSION['id'];
$result = mysqli_query($connection, "SELECT users.id_pegawai, users.username, users.status, users.role, 
        pegawai.* FROM users JOIN pegawai ON users.id_pegawai = pegawai.id WHERE pegawai.id=$id");
?>

<?php while ($pegawai = mysqli_fetch_array($result)): ?>
    <!-- Page body -->
    <div class="page-body">
        <div class="container-xl">

            <div class="row">
                <!-- Bagian Foto Profil -->
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body text-center">
                            <!-- Foto profil -->
                            <img src="<?= base_url('assets/img/foto_pegawai/' . $pegawai['foto']) ?>"
                                alt="Foto Profil"
                                class="img-thumbnail mb-4"
                                style="width: 340px; height: 340px; object-fit: cover; border: 4px solid #3498db;">
                            <h3 class="card-title"><?= $pegawai['nama'] ?></h3>
                            <p class="text-muted"><?= $pegawai['jabatan'] ?></p>
                        </div>
                    </div>
                </div>

                <!-- Bagian Detail Profil -->
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Detail Profil</h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped">
                                <tbody>
                                    <tr>
                                        <td><strong>Nama</strong></td>
                                        <td><?= $pegawai['nama'] ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Jenis Kelamin</strong></td>
                                        <td><?= $pegawai['jenis_kelamin'] ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Alamat</strong></td>
                                        <td><?= $pegawai['alamat'] ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>No. Handphone</strong></td>
                                        <td><?= $pegawai['no_handphone'] ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Jabatan</strong></td>
                                        <td><?= $pegawai['jabatan'] ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Username</strong></td>
                                        <td><?= $pegawai['username'] ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Role</strong></td>
                                        <td><?= ucfirst($pegawai['role']) ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Status</strong></td>
                                        <td>
                                            <?php if ($pegawai['status'] == 'Aktif'): ?>
                                                <span class="badge bg-success">Aktif</span>
                                            <?php else: ?>
                                                <span class="badge bg-danger">Nonaktif</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
<?php endwhile; ?>

<?php include('../layout/footer.php'); ?>