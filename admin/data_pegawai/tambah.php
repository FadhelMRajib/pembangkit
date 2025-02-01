<?php

session_start();
ob_start();

if (!isset($_SESSION["login"])) {
    header("Location: ../../auth/login.php?pesan=belum_login");
} else if ($_SESSION["role"] != 'admin') {
    header("Location: ../../auth/login.php?pesan=tolak_akses");
}

$judul = "Tambah Pegawai";
include('../layout/header.php');
require_once('../../config.php');

if (isset($_POST['submit'])) {


    $ambilnip = mysqli_query($connection, "SELECT nip FROM pegawai ORDER BY nip DESC LIMIT 1");

    if (mysqli_num_rows($ambilnip) > 0) {
        $row = mysqli_fetch_assoc($ambilnip);
        $nip_db = $row['nip'];
        $nip_db = explode("-", $nip_db);
        $no_baru = (int)$nip_db[1] + 1;
        $nip_baru = "PEG-" . str_pad($no_baru, 4, 0, STR_PAD_LEFT);
    } else {
        $nip_baru = "PEG-0001";
    }




    $nip = $nip_baru;
    $nama = htmlspecialchars($_POST['nama']);
    $jenis_kelamin = htmlspecialchars($_POST['jenis_kelamin']);
    $alamat = htmlspecialchars($_POST['alamat']);
    $no_handphone = htmlspecialchars($_POST['no_handphone']);
    $jabatan = htmlspecialchars($_POST['jabatan']);
    $username = htmlspecialchars($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = htmlspecialchars($_POST['role']);
    $status = htmlspecialchars($_POST['status']);

    if (isset($_FILES['foto'])) {
        $file = $_FILES['foto'];
        $nama_file = $file['name'];
        $file_tmp = $file['tmp_name'];
        $ukuran_file = $file['size'];
        $file_direktori = "../../assets/img/foto_pegawai/" . $nama_file;

        $ambil_ekstensi = pathinfo($nama_file, PATHINFO_EXTENSION);
        $ekstensi_diizinkan = ["jpg", "png", "jpeg"];
        $max_ukuran_file = 10 * 1024 * 1024;

        move_uploaded_file($file_tmp, $file_direktori);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (empty($nama)) {
            $pesan_kesalahan[] = "<i class='fa-solid fa-check'></i> Nama Wajib diIsi";
        }
        if (empty($jenis_kelamin)) {
            $pesan_kesalahan[] = "<i class='fa-solid fa-check'></i> Jenis Kelamin Wajib diIsi";
        }

        if (empty($alamat)) {
            $pesan_kesalahan[] = "<i class='fa-solid fa-check'></i> Alamat Wajib diIsi";
        }
        if (empty($no_handphone)) {
            $pesan_kesalahan[] = "<i class='fa-solid fa-check'></i> No. Handphone Wajib diIsi";
        }
        if (empty($jabatan)) {
            $pesan_kesalahan[] = "<i class='fa-solid fa-check'></i> Jabatan Wajib diIsi";
        }
        if (empty($username)) {
            $pesan_kesalahan[] = "<i class='fa-solid fa-check'></i> Username Wajib diIsi";
        }
        if (empty($role)) {
            $pesan_kesalahan[] = "<i class='fa-solid fa-check'></i> Role Wajib diIsi";
        }
        if (empty($status)) {
            $pesan_kesalahan[] = "<i class='fa-solid fa-check'></i> Status Wajib diIsi";
        }
        if (empty($password)) {
            $pesan_kesalahan[] = "<i class='fa-solid fa-check'></i> Password Wajib diIsi";
        }
        if ($_POST['password'] != $_POST['ulangi_password']) {
            $pesan_kesalahan[] = "<i class='fa-solid fa-check'></i> Password Tidak cocok";
        }
        if (!in_array(strtolower($ambil_ekstensi), $ekstensi_diizinkan)) {
            $pesan_kesalahan[] = "<i class='fa-solid fa-check'></i> Hanya file JPG, JPEG, dan PNG Yang diPerbolehkan";
        }
        if ($ukuran_file > $max_ukuran_file) {
            $pesan_kesalahan[] = "<i class='fa-solid fa-check'></i> Ukuran File Melebihi 10MB";
        }


        if (!empty($pesan_kesalahan)) {
            $_SESSION['validasi'] = implode("<br>", $pesan_kesalahan);
        } else {
            $pegawai = mysqli_query($connection, " INSERT INTO pegawai(nip, nama, 
            jenis_kelamin, alamat, no_handphone, jabatan, foto) VALUES ('$nip','$nama',
            '$jenis_kelamin','$alamat','$no_handphone','$jabatan','$nama_file')");

            $id_pegawai = mysqli_insert_id($connection);
            $user = mysqli_query($connection, "INSERT INTO users(id_pegawai, username, 
            password, status, role) VALUES ('$id_pegawai','$username',
            '$password','$status','$role')");

            $_SESSION['berhasil'] = 'Data Berhasil diSimpan';
            header("Location: pegawai.php");
            exit;
        }
    }
}
?>

<!-- Page body -->
<div class="page-body">
    <div class="container-xl">

        <form action="<?= base_url('admin/data_pegawai/tambah.php') ?>" method="POST" enctype="multipart/form-data">

            <div class="row">

                <div class="col-md-6">
                    <div class="card">

                        <div class="card-body">

                            <div class="mb-3">
                                <label for="">Nama</label>
                                <input type="text" class="form-control" name="nama" value="<?php
                                                                                            if (isset($_POST['nama'])) echo $_POST['nama'] ?>">
                            </div>

                            <div class="mb-3">
                                <label for="">Jenis Kelamin</label>
                                <select name="jenis_kelamin" class="form-control">
                                    <option value="">--Pilih Jenis Kelamin--</option>
                                    <option <?php if (isset($_POST['jenis_kelamin']) && $_POST['jenis_kelamin'] == 'Laki-laki') {
                                                echo 'selected';
                                            } ?> value="Laki-laki">Laki-laki</option>
                                    <option <?php if (isset($_POST['jenis_kelamin']) && $_POST['jenis_kelamin'] == 'Perempuan') {
                                                echo 'selected';
                                            } ?> value="Perempuan">Perempuan</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="">Alamat</label>
                                <input type="text" class="form-control" name="alamat" value="<?php
                                                                                                if (isset($_POST['alamat'])) echo $_POST['alamat'] ?>">
                            </div>

                            <div class="mb-3">
                                <label for="">No. Handphone</label>
                                <input type="text" class="form-control" name="no_handphone" value="<?php
                                                                                                    if (isset($_POST['no_handphone'])) echo $_POST['no_handphone'] ?>">
                            </div>

                            <div class="mb-3">
                                <label for="">Jabatan</label>
                                <select name="jabatan" class="form-control">
                                    <option value="">--Pilih Jabatan--</option>

                                    <?php
                                    $ambil_jabatan = mysqli_query($connection, "SELECT * FROM jabatan ORDER BY jabatan ASC");

                                    while ($jabatan = mysqli_fetch_assoc($ambil_jabatan)) {
                                        $nama_jabatan = $jabatan['jabatan'];

                                        if (isset($_POST['jabatan']) && $_POST['jabatan'] == $nama_jabatan) {
                                            echo '<option value="' . $nama_jabatan . '" selected="selected">' . $nama_jabatan .
                                                '</option>';
                                        } else {
                                            echo '<option value="' . $nama_jabatan . '">' . $nama_jabatan .
                                                '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="">Status</label>
                                <select name="status" class="form-control">
                                    <option value="">--Pilih Status--</option>
                                    <option <?php if (isset($_POST['status']) && $_POST['status'] == 'Aktif') {
                                                echo 'selected';
                                            } ?> value="Aktif">Aktif</option>
                                    <option <?php if (isset($_POST['status']) && $_POST['status'] == 'Tidak Aktif') {
                                                echo 'selected';
                                            } ?> value="Tidak Aktif">Tidak Aktif</option>
                                </select>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="">Username</label>
                                <input type="text" class="form-control" name="username" value="<?php
                                                                                                if (isset($_POST['username'])) echo $_POST['username'] ?>">
                            </div>

                            <div class="mb-3">
                                <label for="">Password</label>
                                <input type="password" class="form-control" name="password">
                            </div>

                            <div class="mb-3">
                                <label for="">Ulangi Password</label>
                                <input type="password" class="form-control" name="ulangi_password">
                            </div>

                            <div class="mb-3">
                                <label for="">Role</label>
                                <select name="role" class="form-control">
                                    <option value="">--Pilih Role--</option>
                                    <option <?php if (isset($_POST['role']) && $_POST['role'] == 'admin') {
                                                echo 'selected';
                                            } ?> value="admin">Admin</option>
                                    <option <?php if (isset($_POST['role']) && $_POST['role'] == 'pegawai') {
                                                echo 'selected';
                                            } ?> value="pegawai">Pegawai</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="">Foto</label>
                                <input type="file" class="form-control" name="foto">
                            </div>

                            <button type="submit" class="btn btn-primary" name="submit"> Simpan </button>

                        </div>
                    </div>
                </div>
        </form>
    </div>
</div>
</div>
</div>

<?php include('../layout/footer.php'); ?>