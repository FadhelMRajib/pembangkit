<?php
session_start();

$judul = "Data UP3";
include('../layout/header.php');
require_once('../../config.php');

// Ambil input pencarian jika ada
$search = isset($_GET['nama_up3']) ? $_GET['nama_up3'] : '';

// Pagination configuration
$limit = 7; // Jumlah data per halaman
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Halaman saat ini
$offset = ($page - 1) * $limit; // Offset untuk query SQL

// Query untuk menghitung total data
$count_query = "SELECT COUNT(*) AS total FROM up3";
if (!empty($search)) {
  $count_query .= " WHERE nama_up3 LIKE '%$search%'";
}
$count_result = mysqli_query($connection, $count_query);
$total_rows = mysqli_fetch_assoc($count_result)['total'];
$total_pages = ceil($total_rows / $limit); // Total halaman

// Query untuk mengambil data UP3 sesuai halaman dan pencarian
if (!empty($search)) {
  // Jika ada pencarian, gunakan LIKE untuk mencari berdasarkan nama_up3
  $result = mysqli_query($connection, "SELECT * FROM up3 WHERE nama_up3 LIKE '%$search%' ORDER BY nama_up3 ASC LIMIT $limit OFFSET $offset");
} else {
  // Jika tidak ada pencarian, ambil semua data dan urutkan dari A-Z
  $result = mysqli_query($connection, "SELECT * FROM up3 ORDER BY nama_up3 ASC LIMIT $limit OFFSET $offset");
}
?>

<!-- Page body -->
<div class="page-body">
  <div class="container-xl">
    <div class="row">
      <div class="col-md-4">
        <a href="<?= base_url('admin/sistem/up3_tambah.php') ?>" class="btn btn-primary"><span class="text"><i class="fa-solid fa-circle-plus"></i> Tambah Data</span></a>

        <a href=" <?= base_url('admin/sistem/up3_report.php') ?> " class="btn btn-primary"> <span class="text"> <i class="fas fa-download"></i> Export PDF </span> </a>
      </div>

      <div class="col-md-8 d-flex justify-content-end"">
        <!-- Form Pencarian -->
        <form action="" method=" GET" class="d-flex">
        <input type="text" class="form-control me-2" name="nama_up3" placeholder="Cari Nama UP3" value="<?= htmlspecialchars($search); ?>">
        <button type="submit" class="btn btn-primary">Search</button>
        </form>
      </div>
    </div>

    <div class="row row-deck row-cards mt-2">
      <table class="table table-bordered">
        <tr class="text-center">
          <th>No.</th>
          <th>Nama UP3</th>
          <th>Aksi</th>
        </tr>

        <?php if (mysqli_num_rows($result) === 0): ?>
          <tr>
            <td colspan="3">Data Tidak Ditemukan, Silahkan Tambahkan Data Baru</td>
          </tr>
        <?php else : ?>
          <?php $no = $offset + 1; // Mengatur nomor urut sesuai halaman
          while ($up3 = mysqli_fetch_array($result)): ?>
            <tr class="text-center">
              <td><?= $no++ ?></td>
              <td><?= htmlspecialchars($up3['nama_up3']) ?></td>
              <td class="text-center">
                <!-- Tambahkan id_up3 sebagai parameter di URL -->
                <a href="<?= base_url('admin/sistem/uld.php?id_up3=' . $up3['id_up3']) ?>" class="badge bg-success">Pilih</a>
                <a href="<?= base_url('admin/sistem/up3_hapus.php?id=' . $up3['id_up3']) ?>" class="badge bg-danger tombol-hapus">Hapus</a>
              </td>

            </tr>
          <?php endwhile ?>
        <?php endif; ?>
      </table>
    </div>

    <!-- Pagination Links -->
    <div class="row">
      <div class="col-12 text-end">
        <nav aria-label="Page navigation">
          <ul class="pagination justify-content-end">
            <?php if ($page > 1): ?>
              <li class="page-item">
                <a class="page-link" href="?page=<?= $page - 1 ?>&nama_up3=<?= $search ?>" aria-label="Previous">
                  <span aria-hidden="true">&laquo;</span>
                </a>
              </li>
            <?php endif; ?>

            <!-- Links to individual pages -->
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
              <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                <a class="page-link" href="?page=<?= $i ?>&nama_up3=<?= $search ?>"><?= $i ?></a>
              </li>
            <?php endfor; ?>

            <?php if ($page < $total_pages): ?>
              <li class="page-item">
                <a class="page-link" href="?page=<?= $page + 1 ?>&nama_up3=<?= $search ?>" aria-label="Next">
                  <span aria-hidden="true">&raquo;</span>
                </a>
              </li>
            <?php endif; ?>
          </ul>
        </nav>
      </div>
    </div>

  </div>
</div>

<?= include('../layout/footer.php') ?>