<?php
session_start();

$judul = "Data Semua Mesin";
include('../layout/header.php');
require_once('../../config.php');

// Pencarian dan pagination
$search = isset($_GET['nama_mesin']) ? mysqli_real_escape_string($connection, $_GET['nama_mesin']) : '';
$filter_sistem = isset($_GET['filter_sistem']) ? mysqli_real_escape_string($connection, $_GET['filter_sistem']) : '';
$filter_up3 = isset($_GET['filter_up3']) ? mysqli_real_escape_string($connection, $_GET['filter_up3']) : '';
$filter_uld = isset($_GET['filter_uld']) ? mysqli_real_escape_string($connection, $_GET['filter_uld']) : '';

$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Ambil data UP3 dari database
$up3_query = "SELECT id_up3, nama_up3 FROM up3";
$up3_result = mysqli_query($connection, $up3_query);

// Ambil data ULD dari database
$uld_query = "SELECT id_uld, nama_uld FROM uld";
$uld_result = mysqli_query($connection, $uld_query);

// Query untuk menghitung total data dengan prepared statement
$count_query = "SELECT COUNT(*) AS total FROM mesin m LEFT JOIN uld u ON m.id_uld = u.id_uld WHERE 1=1";
$params = array();

if (!empty($search)) {
  $count_query .= " AND m.nama_mesin LIKE ?";
  $params[] = "%$search%";
}
if (!empty($filter_sistem)) {
  $count_query .= " AND m.sistem = ?";
  $params[] = $filter_sistem;
}
if (!empty($filter_up3)) {
  $count_query .= " AND m.id_up3 = ?";
  $params[] = $filter_up3;
}
if (!empty($filter_uld)) {
  $count_query .= " AND m.id_uld = ?";
  $params[] = $filter_uld;
}

$stmt = mysqli_prepare($connection, $count_query);
if (!empty($params)) {
  $types = str_repeat('s', count($params));
  mysqli_stmt_bind_param($stmt, $types, ...$params);
}
mysqli_stmt_execute($stmt);
$count_result = mysqli_stmt_get_result($stmt);
$total_rows = mysqli_fetch_assoc($count_result)['total'];
$total_pages = ceil($total_rows / $limit);

// Query untuk mengambil data mesin dengan JOIN ke tabel ULD
$query = "SELECT m.*, u.nama_uld FROM mesin m 
          LEFT JOIN uld u ON m.id_uld = u.id_uld 
          WHERE 1=1";

if (!empty($search)) {
  $query .= " AND m.nama_mesin LIKE ?";
}
if (!empty($filter_sistem)) {
  $query .= " AND m.sistem = ?";
}
if (!empty($filter_up3)) {
  $query .= " AND m.id_up3 = ?";
}
if (!empty($filter_uld)) {
  $query .= " AND m.id_uld = ?";
}
$query .= " ORDER BY m.nama_mesin ASC LIMIT ? OFFSET ?";

$stmt = mysqli_prepare($connection, $query);
if (!empty($params)) {
  $params[] = $limit;
  $params[] = $offset;
  $types = str_repeat('s', count($params) - 2) . 'ii';
  mysqli_stmt_bind_param($stmt, $types, ...$params);
} else {
  mysqli_stmt_bind_param($stmt, 'ii', $limit, $offset);
}
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
?>

<div class="page-body">
  <div class="container-xl">
    <!-- Konten utama (form dan tabel mesin) tetap sama -->
    <div class="row">
      <div class="col-md-6">
        <a href=" <?= base_url('admin/sistem/mesin_all_report.php?filter_sistem=' . $filter_sistem) ?>" class="btn btn-primary">
          <span class="text"> <i class="fas fa-download"></i> Export Excell </span>
        </a>
      </div>

      <div class="col-md-6 d-flex justify-content-end">
        <!-- Dropdown filter untuk sistem, UP3, ULD, dan form pencarian ke pojok kanan -->
        <form action="" method="GET" class="d-flex">
          <select style="width: 150px;" name="filter_sistem" class="form-control me-2 text-center">
            <option value="">--Semua Sistem--</option>
            <option value="Isolated" <?= isset($_GET['filter_sistem']) && $_GET['filter_sistem'] == 'Isolated' ? 'selected' : '' ?>>Isolated</option>
            <option value="Interkoneksi" <?= isset($_GET['filter_sistem']) && $_GET['filter_sistem'] == 'Interkoneksi' ? 'selected' : '' ?>>Interkoneksi</option>
            <option value="Disconnected" <?= isset($_GET['filter_sistem']) && $_GET['filter_sistem'] == 'Disconnected' ? 'selected' : '' ?>>Disconnected</option>
          </select>

          <!-- Dropdown Filter UP3 -->
          <select style="width: 150px;" name="filter_up3" class="form-control me-2 text-center">
            <option value="">
              --Semua UP3--
            </option>
            <?php while ($up3 = mysqli_fetch_assoc($up3_result)) : ?>
              <option value="<?= $up3['id_up3'] ?>" <?= ($filter_up3 == $up3['id_up3']) ? 'selected' : '' ?>><?= $up3['nama_up3']  ?></option>
            <?php endwhile; ?>
          </select>

          <!-- Dropdown Filter ULD -->
          <select style="width: 150px;" name="filter_uld" class="form-control me-2 text-center">
            <option value="">--Semua ULD--</option>
            <?php while ($uld = mysqli_fetch_assoc($uld_result)) : ?>
              <option value="<?= $uld['id_uld'] ?>" <?= ($filter_uld == $uld['id_uld']) ? 'selected' : '' ?>><?= $uld['nama_uld'] ?></option>
            <?php endwhile; ?>
          </select>

          <input type="text" class="form-control me-2" name="nama_mesin" placeholder="Cari Nama Mesin" value="<?= htmlspecialchars($search); ?>" style="width: 200px;"> <!-- Memperpanjang input pencarian -->

          <button type="submit" class="btn btn-primary">Search</button>
        </form>
      </div>
    </div>

    <!-- Konten Tabel tetap sama -->
    <div class="row row-deck row-cards mt-2">
      <!-- Menambahkan table-responsive agar tabel bisa digeser ke kanan/kiri -->
      <div class="table-responsive overflow-auto">
        <table class="table table-bordered">
          <tr class="text-center">
            <th>No.</th>
            <th>Sentral</th>
            <th>Nama Mesin</th>
            <th>Kode Mesin</th>
            <th>Sistem</th>
            <th>Merk</th>
            <th>Type</th>
            <th>Seri</th>
            <th>Merk Generator</th>
            <th>Nama Trafo</th>
            <th>Tegangan</th>
            <th>Kapasitas</th>
            <th>Tahun</th>
            <th>Aksi</th>
          </tr>

          <?php if (mysqli_num_rows($result) === 0): ?>
            <tr>
              <td colspan="13">Data Tidak Ditemukan, Silahkan Tambahkan Data Baru</td>
            </tr>
          <?php else : ?>
            <?php $no = $offset + 1;
            while ($mesin = mysqli_fetch_array($result)): ?>
              <tr>
                <td><?= $no++ ?></td>
                <td style="white-space: nowrap; overflow: hidden; max-width: 300px;"><?= $mesin['nama_uld'] ?? 'Tidak ada ULD' ?></td> <!-- Kolom Sentral menampilkan nama ULD -->
                <td style="white-space: nowrap; overflow: hidden; max-width: 550px;"><?= $mesin['nama_mesin'] ?></td>
                <td><?= $mesin['kode_mesin'] ?></td>
                <td><?= $mesin['sistem'] ?></td>
                <td><?= $mesin['merek_mesin'] ?></td>
                <td style="white-space: nowrap; overflow: hidden; max-width: 300px;"><?= $mesin['tipe_mesin'] ?></td>
                <td style="white-space: nowrap; overflow: hidden; max-width: 300px;"><?= $mesin['seri_mesin'] ?></td>
                <td style="white-space: nowrap; overflow: hidden; max-width: 300px;"><?= $mesin['merek_generator'] ?></td>
                <td class="text-center"><?= $mesin['nama_trafo'] ?></td>
                <td class="text-center"><?= $mesin['tegangan'] ?></td>
                <td class="text-center"><?= $mesin['kapasitas'] ?></td>
                <td class="text-center"><?= $mesin['tahun_operasi'] ?></td>
                <td class="text-center">
                  <a href="<?= base_url('admin/sistem/mesin_edit.php?id=' . $mesin['id_mesin']) ?>" class="badge bg-primary">Edit</a>
                  <a href="<?= base_url('admin/sistem/mesin_hapus.php?id=' . $mesin['id_mesin']) ?>" class="badge bg-danger tombol-hapus">Hapus</a>
                </td>
              </tr>
            <?php endwhile ?>
          <?php endif; ?>
        </table>
      </div>

      <!-- Pagination -->
      <div class="d-flex justify-content-end mt-4">
        <nav aria-label="Page navigation">
          <ul class="pagination">
            <!-- Page Numbers -->
            <?php
            // Tentukan range awal dan akhir dari nomor halaman
            $start_page = max(1, $page - 2); // Halaman awal untuk tampil
            $end_page = min($total_pages, $page + 2); // Halaman akhir untuk tampil

            for ($i = $start_page; $i <= $end_page; $i++): ?>
              <li class="page-item <?= ($page == $i) ? 'active' : '' ?>">
                <a class="page-link" href="?page=<?= $i ?><?= !empty($search) ? '&nama_mesin=' . urlencode($search) : '' ?><?= !empty($filter_sistem) ? '&filter_sistem=' . urlencode($filter_sistem) : '' ?><?= !empty($filter_up3) ? '&filter_up3=' . urlencode($filter_up3) : '' ?><?= !empty($filter_uld) ? '&filter_uld=' . urlencode($filter_uld) : '' ?>">
                  <?= $i ?>
                </a>
              </li>
            <?php endfor; ?>
          </ul>
        </nav>
      </div>

    </div>
  </div>
</div>

<?php include('../layout/footer.php'); ?>