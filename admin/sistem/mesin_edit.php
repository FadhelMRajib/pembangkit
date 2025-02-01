<?php 
session_start();
ob_start();

$judul = "Edit Data Mesin";
include('../layout/header.php');
require_once('../../config.php');

// Cek apakah ada parameter ID mesin yang dikirim melalui URL
if (!isset($_GET['id'])) {
    $_SESSION['validasi'] = 'ID Mesin tidak ditemukan!';
    header("Location: up3.php");
    exit;
}

$id_mesin = $_GET['id'];

// Ambil data mesin yang akan diedit berdasarkan ID
$mesin_query = mysqli_query($connection, "SELECT * FROM mesin WHERE id_mesin = '$id_mesin'");
$mesin_data = mysqli_fetch_assoc($mesin_query);

// Ambil data UP3 dan ULD dari database
$up3_query = mysqli_query($connection, "SELECT * FROM up3");
$uld_query = mysqli_query($connection, "SELECT * FROM uld");

if (isset($_POST['submit'])) {
    // Ambil data dari form
    $up3 = htmlspecialchars($_POST['up3']);
    $uld = htmlspecialchars($_POST['uld']);
    $sistem = htmlspecialchars($_POST['sistem']);
    $nama_mesin = htmlspecialchars($_POST['nama_mesin']);
    $kode_mesin = htmlspecialchars($_POST['kode_mesin']);
    $merek_mesin = htmlspecialchars($_POST['merek_mesin']);
    $tipe_mesin = htmlspecialchars($_POST['tipe_mesin']);
    $seri_mesin = htmlspecialchars($_POST['seri_mesin']);
    $merek_generator = htmlspecialchars($_POST['merek_generator']);
    $nama_trafo = htmlspecialchars($_POST['nama_trafo']);
    $tegangan = htmlspecialchars($_POST['tegangan']);
    $kapasitas = htmlspecialchars($_POST['kapasitas']);
    $tahun_operasi = htmlspecialchars($_POST['tahun_operasi']);

    $pesan_kesalahan = [];

    // Validasi form
    if (empty($up3)) {
        $pesan_kesalahan[] = "<i class='fa-solid fa-check'></i> UP3 Wajib diisi";
    }
    if (empty($uld)) {
        $pesan_kesalahan[] = "<i class='fa-solid fa-check'></i> ULD Wajib diisi";
    }
    if (empty($sistem)) {
        $pesan_kesalahan[] = "<i class='fa-solid fa-check'></i> Sistem Wajib diisi";
    }
    if (empty($nama_mesin)) {
        $pesan_kesalahan[] = "<i class='fa-solid fa-check'></i> Nama Mesin Wajib diisi";
    }
    if (empty($kode_mesin)) {
        $pesan_kesalahan[] = "<i class='fa-solid fa-check'></i> Kode Mesin Wajib diisi";
    }
    if (empty($merek_mesin)) {
        $pesan_kesalahan[] = "<i class='fa-solid fa-check'></i> Merek Mesin Wajib diisi";
    }
    if (empty($seri_mesin)) {
        $pesan_kesalahan[] = "<i class='fa-solid fa-check'></i> Seri Mesin Wajib diisi";
    }
    if (empty($merek_generator)) {
        $pesan_kesalahan[] = "<i class='fa-solid fa-check'></i> Merek Generator Wajib diisi";
    }
    if (empty($nama_trafo)) {
        $pesan_kesalahan[] = "<i class='fa-solid fa-check'></i> Nama Trafo Wajib diisi";
    }
    if (empty($tegangan)) {
        $pesan_kesalahan[] = "<i class='fa-solid fa-check'></i> Tegangan Wajib diisi";
    }
    if (empty($kapasitas)) {
        $pesan_kesalahan[] = "<i class='fa-solid fa-check'></i> Kapasitas Wajib diisi";
    }
    if (empty($tahun_operasi)) {
        $pesan_kesalahan[] = "<i class='fa-solid fa-check'></i> Tahun Operasi Wajib diisi";
    }

    // Jika ada kesalahan validasi, tampilkan pesan
    if (!empty($pesan_kesalahan)) {
        $_SESSION['validasi'] = implode("<br>", $pesan_kesalahan);
    } else {
        // Update ke database
        $update_mesin = mysqli_query($connection, "UPDATE mesin SET 
            id_up3 = '$up3', 
            id_uld = '$uld', 
            sistem = '$sistem', 
            nama_mesin = '$nama_mesin', 
            kode_mesin = '$kode_mesin', 
            merek_mesin = '$merek_mesin', 
            tipe_mesin = '$tipe_mesin', 
            seri_mesin = '$seri_mesin', 
            merek_generator = '$merek_generator', 
            nama_trafo = '$nama_trafo', 
            tegangan = '$tegangan', 
            kapasitas = '$kapasitas', 
            tahun_operasi = '$tahun_operasi' 
            WHERE id_mesin = '$id_mesin'");

        // Jika berhasil
        if ($update_mesin) {
            $_SESSION['berhasil'] = 'Data Berhasil diUpdate';
            header("Location: up3.php");
            exit;
        } else {
            // Jika gagal, tampilkan pesan error
            $_SESSION['validasi'] = "Gagal mengupdate data mesin: " . mysqli_error($connection);
        }
    }
}
?>

<!-- Page body -->
<div class="page-body">
    <div class="container-xl">
        <form action="<?= base_url('admin/sistem/mesin_edit.php?id=' . $id_mesin) ?>" method="POST" enctype="multipart/form-data">
            <div class="row">
                <!-- Kolom Kiri -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="up3">UP3</label>
                                <select name="up3" id="up3" class="form-control">
                                    <option value="">--Pilih UP3--</option>
                                    <?php while ($row_up3 = mysqli_fetch_assoc($up3_query)) : ?>
                                        <option value="<?= $row_up3['id_up3'] ?>" <?= isset($mesin_data['id_up3']) && $mesin_data['id_up3'] == $row_up3['id_up3'] ? 'selected' : '' ?>>
                                            <?= $row_up3['nama_up3'] ?>
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="uld">ULD</label>
                                <select name="uld" id="uld" class="form-control">
                                    <option value="">--Pilih ULD--</option>
                                    <?php while ($row_uld = mysqli_fetch_assoc($uld_query)) : ?>
                                        <option value="<?= $row_uld['id_uld'] ?>" <?= isset($mesin_data['id_uld']) && $mesin_data['id_uld'] == $row_uld['id_uld'] ? 'selected' : '' ?>>
                                            <?= $row_uld['nama_uld'] ?>
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="">Sistem</label>
                                <select name="sistem" class="form-control">
                                    <option value="">--Pilih Sistem--</option>
                                    <option <?php if(isset($mesin_data['sistem']) && $mesin_data['sistem'] == 'Isolated') echo 'selected'; ?> value="Isolated">Isolated</option>
                                    <option <?php if(isset($mesin_data['sistem']) && $mesin_data['sistem'] == 'Interkoneksi') echo 'selected'; ?> value="Interkoneksi">Interkoneksi</option>
                                    <option <?php if(isset($mesin_data['sistem']) && $mesin_data['sistem'] == 'Dsiconnected') echo 'selected'; ?> value="Disconnected">Disconnected</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="nama_mesin">Nama Mesin</label>
                                <input type="text" class="form-control" name="nama_mesin" value="<?= $mesin_data['nama_mesin'] ?>">
                            </div>

                            <div class="mb-3">
                                <label for="">Kode Mesin</label>
                                <input type="text" class="form-control" name="kode_mesin" value="<?php if(isset($mesin_data['kode_mesin'])) echo $mesin_data['kode_mesin']; ?>">
                            </div>

                            <div class="mb-3">
                                <label for="">Merek Mesin</label>
                                <input type="text" class="form-control" name="merek_mesin" value="<?php if(isset($mesin_data['merek_mesin'])) echo $mesin_data['merek_mesin']; ?>">
                            </div>

                            <div class="mb-3">
                                <label for="">Tipe Mesin</label>
                                <input type="text" class="form-control" name="tipe_mesin" value="<?php if(isset($mesin_data['tipe_mesin'])) echo $mesin_data['tipe_mesin']; ?>">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kolom Kanan -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="">Seri Mesin</label>
                                <input type="text" class="form-control" name="seri_mesin" value="<?php if(isset($mesin_data['seri_mesin'])) echo $mesin_data['seri_mesin']; ?>">
                            </div>

                            <div class="mb-3">
                                <label for="">Merek Generator</label>
                                <input type="text" class="form-control" name="merek_generator" value="<?php if(isset($mesin_data['merek_generator'])) echo $mesin_data['merek_generator']; ?>">
                            </div>

                            <div class="mb-3">
                                <label for="">Nama Trafo</label>
                                <input type="text" class="form-control" name="nama_trafo" value="<?php if(isset($mesin_data['nama_trafo'])) echo $mesin_data['nama_trafo']; ?>">
                            </div>

                            <div class="mb-3">
                                <label for="">Tegangan</label>
                                <input type="text" class="form-control" name="tegangan" value="<?php if(isset($mesin_data['tegangan'])) echo $mesin_data['tegangan']; ?>">
                            </div>

                            <div class="mb-3">
                                <label for="">Kapasitas</label>
                                <input type="text" class="form-control" name="kapasitas" value="<?php if(isset($mesin_data['kapasitas'])) echo $mesin_data['kapasitas']; ?>">
                            </div>

                            <div class="mb-3">
                                <label for="">Tahun Operasi</label>
                                <input type="text" class="form-control" name="tahun_operasi" value="<?php if(isset($mesin_data['tahun_operasi'])) echo $mesin_data['tahun_operasi']; ?>">
                            </div>

                            <button type="submit" class="btn btn-primary" name="submit">SIMPAN PERUBAHAN</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<?= include('../layout/footer.php') ?>
