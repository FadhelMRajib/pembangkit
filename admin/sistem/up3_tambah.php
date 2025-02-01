<?php 
session_start();
ob_start();


$judul = "Tambah Data UP3";
include('../layout/header.php');
require_once('../../config.php');

if(isset($_POST['submit'])) {
    $nama_up3 = htmlspecialchars($_POST['nama_up3']);

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if(empty($nama_up3)) {
            $pesan_kesalahan = "Nama up3 Wajib diIsi";
        }
        if(!empty($pesan_kesalahan)){
            $_SESSION['validasi'] = $pesan_kesalahan;
        }else{
            $result = mysqli_query($connection, "INSERT INTO up3(nama_up3) VALUES('$nama_up3')");
            $_SESSION['berhasil'] = "Data Berhasil diSimpan";
            header("Location: up3.php");
            exit;
        }
    }
}

?>

        <!-- Page body -->
        <div class="page-body">
          <div class="container-xl">
            <div class="card col-md-6">
                <div class="card-body">

                <form action="<?= base_url('admin/sistem/up3_tambah.php?') ?>" method="POST">
                    <div class="mb-3">
                        <label for="">Nama UP3</label>
                        <input type="text" class="form-control" name="nama_up3">
                    </div>

                    <button type="sumbit" class="btn btn-primary" name="submit">SIMPAN</button>
                </form>

                </div>
            </div>
          </div>
        </div>
        
<?= include('../layout/footer.php') ?>