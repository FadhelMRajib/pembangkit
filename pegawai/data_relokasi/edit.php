<?php
ob_start();
session_start();

if (!isset($_SESSION["login"])) {
    header("Location: ../../auth/login.php?pesan=belum_login");
} else if ($_SESSION["role"] != 'pegawai') {
    header("Location: ../../auth/login.php?pesan=tolak_akses");
}

$judul = 'Edit Pengajuan Relokasi Mesin';
include('../layout/header.php');
include_once("../../config.php");

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $kota = $_POST['kota'];
    $keterangan = $_POST['keterangan'];
    $tanggal = $_POST['tanggal'];

    if ($_FILES['file_baru']['error'] === 4) {
        $file_lama = $_POST['file_lama'];
    } else {
        $file = $_FILES['file_baru'];
        $nama_file = $file['name'];
        $file_tmp = $file['tmp_name'];
        $ukuran_file = $file['size'];
        $file_direktori = "../../assets/file_relokasimesin/" . $nama_file;

        $ambil_ekstensi = pathinfo($nama_file, PATHINFO_EXTENSION);
        $ekstensi_diizinkan = ["jpg", "png", "jpeg", "pdf"];
        $max_ukuran_file = 10 * 1024 * 1024;

        move_uploaded_file($file_tmp, $file_direktori);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (empty($kota)) {
            $pesan_kesalahan[] = "<i class='fa-solid fa-check'></i> Kota Wajib diIsi";
        }
        if (empty($keterangan)) {
            $pesan_kesalahan[] = "<i class='fa-solid fa-check'></i> Keterangan Wajib diIsi";
        }
        if (empty($tanggal)) {
            $pesan_kesalahan[] = "<i class='fa-solid fa-check'></i> Tanggal Wajib diIsi";
        }

        if ($_FILES['file_baru']['error'] != 4) {
            if (!in_array(strtolower($ambil_ekstensi), $ekstensi_diizinkan)) {
                $pesan_kesalahan[] = "<i class='fa-solid fa-check'></i> Hanya file JPG, JPEG, PNG, dan PDF Yang diPerbolehkan";
            }
            if ($ukuran_file > $max_ukuran_file) {
                $pesan_kesalahan[] = "<i class='fa-solid fa-check'></i> Ukuran File Melebihi 10MB";
            }
        }


        if (!empty($pesan_kesalahan)) {
            $_SESSION['validasi'] = implode("<br>", $pesan_kesalahan);
        } else {
            $result = mysqli_query($connection, "UPDATE relokasi_mesin SET keterangan='$keterangan', 
            kota='$kota', tanggal='$tanggal', file='$nama_file' WHERE id = $id");

            $_SESSION['berhasil'] = 'Data Berhasil diUpdate';
            header("Location: relokasimesin.php");
            exit;
        }
    }
}

$id = $_GET['id'];
$result = mysqli_query($connection, "SELECT * FROM  relokasi_mesin WHERE id=$id");
while ($data = mysqli_fetch_array($result)) {
    $keterangan = $data['keterangan'];
    $kota = $data['kota'];
    $file = $data['file'];
    $tanggal = $data['tanggal'];
}

?>

<!-- Page body -->
<div class="page-body">
    <div class="container-xl">
        <div class="card col-md-6">
            <div class="card-body">
                <form action="" method="POST" enctype="multipart/form-data">
                    <input type="hidden" value="<?= $_SESSION['id'] ?>" name="id_pegawai">

                    <div class="mb-3">
                        <label for="">Tanggal</label>
                        <input type="date" class="form-control" name="tanggal" value="<?= $tanggal ?>">
                    </div>

                    <div class="mb-3">
                        <label for="">Kota</label>
                        <input type="text" class="form-control" name="kota" value="<?= $kota ?>">
                    </div>

                    <div class="mb-3">
                        <label for="">keterangan</label>
                        <input type="text" class="form-control" name="keterangan" value="<?= $keterangan ?>">
                    </div>

                    <div class="mb-3">
                        <label for="">Surat Keterangan</label>
                        <input type="file" class="form-control" name="file_baru">
                        <input type="hidden" name="file_lama" value="<?= $file ?>">
                    </div>

                    <input type="hidden" name="id" value="<?= $_GET['id']; ?>">

                    <button type="submit" class="btn btn-primary" name="update">Update</button>

                </form>
            </div>
        </div>
    </div>
</div>

<?php include('../layout/footer.php'); ?>