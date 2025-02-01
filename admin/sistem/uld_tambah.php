<?php
session_start();
ob_start();

$judul = "Tambah Data ULD";
include('../layout/header.php');
require_once('../../config.php');

// Ambil data UP3 untuk dropdown
$up3_result = mysqli_query($connection, "SELECT * FROM up3 ORDER BY nama_up3 ASC");

if (isset($_POST['submit'])) {
  $nama_uld = htmlspecialchars($_POST['nama_uld']);
  $sistem = htmlspecialchars($_POST['sistem']);
  $id_up3 = $_POST['id_up3']; // Ambil id_up3 dari select dropdown

  // Validasi form
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($nama_uld)) {
      $pesan_kesalahan = "Nama ULD wajib diisi";
    } elseif (empty($id_up3)) {
      $pesan_kesalahan = "UP3 harus dipilih";
    }

    // Jika tidak ada kesalahan
    if (empty($pesan_kesalahan)) {
      // Masukkan data ke tabel uld
      $result = mysqli_query($connection, "INSERT INTO uld(nama_uld, sistem, id_up3) VALUES('$nama_uld', '$sistem', '$id_up3')");
      $_SESSION['berhasil'] = "Data berhasil disimpan";
      header("Location: up3.php");
      exit;
    } else {
      $_SESSION['validasi'] = $pesan_kesalahan;
    }
  }
}

?>

<!-- Page body -->
<div class="page-body">
  <div class="container-xl">
    <div class="card col-md-6">
      <div class="card-body">

        <!-- Tampilkan pesan validasi jika ada -->
        <?php if (isset($_SESSION['validasi'])): ?>
          <div class="alert alert-danger">
            <?= $_SESSION['validasi'] ?>
          </div>
          <?php unset($_SESSION['validasi']); ?>
        <?php endif; ?>

        <!-- Form Tambah ULD -->
        <form action="" method="POST">
          <div class="mb-3">
            <label for="nama_uld">Nama ULD</label>
            <input type="text" class="form-control" name="nama_uld" placeholder="Masukkan Nama ULD">
          </div>

          <div class="mb-3">
            <label for="">Sistem</label>
            <select name="sistem" class="form-control">
              <option value="">--Pilih Sistem--</option>
              <option <?php if (isset($_POST['sistem']) && $_POST['sistem'] == 'Isolated') echo 'selected'; ?> value="Isolated">Isolated</option>
              <option <?php if (isset($_POST['sistem']) && $_POST['sistem'] == 'Interkoneksi') echo 'selected'; ?> value="Interkoneksi">Interkoneksi</option>
              <option <?php if (isset($_POST['sistem']) && $_POST['sistem'] == 'Dsiconnected') echo 'selected'; ?> value="Disconnected">Disconnected</option>
            </select>
          </div>

          <div class="mb-3">
            <label for="id_up3">Pilih UP3</label>
            <select class="form-control" name="id_up3">
              <option value="">-- Pilih UP3 --</option>
              <!-- Loop untuk menampilkan pilihan UP3 -->
              <?php while ($row = mysqli_fetch_assoc($up3_result)): ?>
                <option value="<?= $row['id_up3'] ?>"><?= $row['nama_up3'] ?></option>
              <?php endwhile; ?>
            </select>
          </div>

          <button type="submit" class="btn btn-primary" name="submit">SIMPAN</button>
        </form>

      </div>
    </div>
  </div>
</div>

<?= include('../layout/footer.php') ?>