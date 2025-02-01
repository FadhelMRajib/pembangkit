<?php 
session_start();
ob_start();


$judul = "Tambah Data Jabatan";
include('../layout/header.php');
require_once('../../config.php');

if(isset($_POST['submit'])) {
    $jabatan = htmlspecialchars($_POST['jabatan']);

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if(empty($jabatan)) {
            $pesan_kesalahan = "Nama Jabatan Wajib diIsi";
        }
        if(!empty($pesan_kesalahan)){
            $_SESSION['validasi'] = $pesan_kesalahan;
        }else{
            $result = mysqli_query($connection, "INSERT INTO jabatan(jabatan) VALUES('$jabatan')");
            $_SESSION['berhasil'] = "Data Berhasil diSimpan";
            header("Location: jabatan.php");
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

                <form action="<?= base_url('admin/data_jabatan/tambah.php') ?>" method="POST">
                    <div class="mb-3">
                        <label for="">Nama Jabatan</label>
                        <input type="text" class="form-control" name="jabatan">
                    </div>

                    <button type="sumbit" class="btn btn-primary" name="submit">SIMPAN</button>
                </form>

                </div>
            </div>
          </div>
        </div>
        
<?= include('../layout/footer.php') ?>