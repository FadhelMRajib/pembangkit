<?php
session_start();
require_once '../../config.php';

// Buat koneksi
$connection = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

// Cek koneksi
if (!$connection) {
  die("Koneksi gagal: " . mysqli_connect_error());
}

// Modifikasi query untuk UP3 spesifik dengan perbaikan nama Pangkalan Bun
$query_up3_specific = "
    SELECT up3.nama_up3, COUNT(uld.id_uld) AS jumlah_uld
    FROM uld
    JOIN up3 ON uld.id_up3 = up3.id_up3
    WHERE up3.nama_up3 IN ('KOTA BARU', 'KUALA KAPUAS', 'PALANGKA RAYA', 'PANGKALAN BUN', 'PANGKALANBUUN')
    GROUP BY up3.nama_up3
";
$result_up3_specific = mysqli_query($connection, $query_up3_specific);

// Array untuk menyimpan jumlah ULD per UP3 spesifik
$up3SpecificData = [];
while ($row = mysqli_fetch_assoc($result_up3_specific)) {
  // Normalisasi nama Pangkalan Bun
  if ($row['nama_up3'] == 'PANGKALANBUUN') {
    $row['nama_up3'] = 'PANGKALAN BUN';
  }
  $up3SpecificData[] = [
    'nama_up3' => $row['nama_up3'],
    'jumlah_uld' => $row['jumlah_uld']
  ];
}

// Cek login dan role
if (!isset($_SESSION["login"])) {
  header("Location: ../../auth/login.php?pesan=belum_login");
} else if ($_SESSION["role"] != 'pegawai') {
  header("Location: ../../auth/login.php?pesan=tolak_akses");
}

$judul = "Home";
include('../layout/header.php');
?>

<style>
  .card-img-top {
    height: 200px;
    /* Atur tinggi gambar sesuai kebutuhan */
    overflow: hidden;
  }

  .card-img-top img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }

  .card-title {
    font-size: 1rem;
    font-weight: bold;
    margin: 0;
  }

  .card .text-secondary {
    font-size: 0.9rem;
  }

  /* ... CSS lainnya ... */

  .hover-zoom {
    transition: transform 0.3s ease-in-out;
  }

  .hover-zoom:hover {
    transform: scale(1.1);
  }

  .card {
    overflow: hidden;
  }
</style>

<div class="page-body">
  <div class="container-xl">

    <!-- Bagian untuk tampilan lokasi UP3 dengan gambar -->
    <div class="row row-cards">
      <?php foreach ($up3SpecificData as $up3) : ?>
        <?php
        $nama_up3 = $up3['nama_up3'];
        $jumlah_uld = $up3['jumlah_uld'];

        // Menentukan gambar berdasarkan nama UP3
        $gambar = '';
        switch (strtoupper($nama_up3)) {
          case 'KOTA BARU':
            $gambar = 'kotabaru.JPG';
            break;
          case 'KUALA KAPUAS':
            $gambar = 'kuala_kapuas.jpg';
            break;
          case 'PALANGKA RAYA':
            $gambar = 'palangkaraya2.jpg';
            break;
          case 'PANGKALAN BUN':
          case 'PANGKALANBUUN':
            $gambar = 'pangkalanbun.jpg';
            break;
          default:
            $gambar = 'default.jpg';
            break;
        }
        ?>
        <div class="col-sm-6 col-lg-3">
          <div class="card">
            <img src="<?= base_url('assets/img/' . $gambar) ?>"
              alt="<?= htmlspecialchars($nama_up3) ?>"
              class="hover-zoom"
              style="width: 100%; height: 250px; object-fit: cover;">
            <div class="card-body text-center p-2">
              <h4><?= strtoupper(htmlspecialchars($nama_up3)) ?></h4>
              <div class="text-secondary"><?= htmlspecialchars($jumlah_uld) ?> ULD</div>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>

  <?= include('../layout/footer.php') ?>