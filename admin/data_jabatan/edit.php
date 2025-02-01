<?php 
session_start();
ob_start();


$judul = "Edit Data Jabatan";
include('../layout/header.php');
require_once('../../config.php');

if(isset($_POST['update'])) {
    $id = $_POST['id'];
    $jabatan = htmlspecialchars($_POST['jabatan']);

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if(empty($jabatan)) {
            $pesan_kesalahan = "Nama Jabatan Wajib diIsi";
        }
        if(!empty($pesan_kesalahan)){
            $_SESSION['validasi'] = $pesan_kesalahan;
        }else{
            $result = mysqli_query($connection, "UPDATE jabatan SET jabatan='$jabatan' WHERE id=$id");
            $_SESSION['berhasil'] = "Data Berhasil diUpdate";
            header("Location: jabatan.php");
            exit;
        }
    }
}

// $id = $_GET['id'];
$id = isset($_GET['id']) ? $_GET['id'] : $_POST['id'];
$result = mysqli_query($connection, "SELECT * FROM jabatan WHERE id = $id");

while($jabatan = mysqli_fetch_array($result)){
    $nama_jabatan = $jabatan['jabatan'];

}

?>

        <!-- Page body -->
        <div class="page-body">
          <div class="container-xl">
            <div class="card col-md-6">
                <div class="card-body">

                <form action="<?= base_url('admin/data_jabatan/edit.php') ?>" method="POST">
                    <div class="mb-3">
                        <label for="">Nama Jabatan</label>
                        <input type="text" class="form-control" name="jabatan" value="<?= $nama_jabatan ?>">
                    </div>

                    <input type="hidden" value="<?= $id ?>" name="id">
                    <button type="sumbit" class="btn btn-primary" name="update">UPDATE</button>
                </form>

                </div>
            </div>
          </div>
        </div>
        
<?= include('../layout/footer.php') ?>