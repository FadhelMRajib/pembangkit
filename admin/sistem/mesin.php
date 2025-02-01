<?php
session_start();

$judul = "Data Mesin";
include('../layout/header.php');
require_once('../../config.php');

// Ambil id_up3 dan id_uld dari URL
$id_up3 = isset($_GET['id_up3']) ? $_GET['id_up3'] : '';
$id_uld = isset($_GET['id_uld']) ? $_GET['id_uld'] : '';

// Pencarian dan pagination
$search = isset($_GET['nama_mesin']) ? $_GET['nama_mesin'] : '';
$filter_sistem = isset($_GET['filter_sistem']) ? $_GET['filter_sistem'] : '';

$limit = 5; // Jumlah data per halaman
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Query untuk menghitung total data
$count_query = "SELECT COUNT(*) AS total FROM mesin WHERE id_up3 = '$id_up3' AND id_uld = '$id_uld'";
if (!empty($search)) {
  $count_query .= " AND nama_mesin LIKE '%$search%'";
}
if (!empty($filter_sistem)) {
  $count_query .= " AND sistem = '$filter_sistem'";
}
$count_result = mysqli_query($connection, $count_query);
$total_rows = mysqli_fetch_assoc($count_result)['total'];
$total_pages = ceil($total_rows / $limit);

// Query untuk mengambil data mesin berdasarkan filter sistem dan pencarian
$query = "
    SELECT mesin.*, uld.nama_uld 
    FROM mesin 
    JOIN uld ON mesin.id_uld = uld.id_uld 
    WHERE mesin.id_up3 = '$id_up3' AND mesin.id_uld = '$id_uld'
";
if (!empty($search)) {
  $query .= " AND mesin.nama_mesin LIKE '%$search%'";
}
if (!empty($filter_sistem)) {
  $query .= " AND mesin.sistem = '$filter_sistem'";
}
// Mengurutkan nama mesin dari A sampai Z
$query .= " ORDER BY nama_mesin ASC LIMIT $limit OFFSET $offset";
$result = mysqli_query($connection, $query);
?>

<!-- Page body -->
<div class="page-body">
  <div class="container-xl">

    <div class="row">
      <div class="col-md-6">
        <a href="<?= base_url('admin/sistem/mesin_tambah.php') ?>" class="btn btn-primary">
          <span class="text"><i class="fa-solid fa-circle-plus"></i> Tambah Data</span>
        </a>

        <!-- Ubah button Export Excel menjadi trigger modal -->
        <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exportExcelModal">
          <span class="text"> <i class="fas fa-download"></i> Export Excel </span>
        </a>

        <!-- Tambahkan Modal untuk Filter Export Excel -->
        <div class="modal fade" id="exportExcelModal" tabindex="-1" aria-labelledby="exportExcelModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exportExcelModalLabel">Filter Data Mesin</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <form action="mesin_reportEXCEL.php" method="GET">
                <div class="modal-body">
                  <!-- Filter UP3 -->
                  <div class="mb-3">
                    <label for="export_up3" class="form-label">Pilih UP3</label>
                    <select name="export_up3" id="export_up3" class="form-select" onchange="loadULD(this.value)">
                      <option value="">Semua UP3</option>
                      <?php
                      $query_up3 = "SELECT * FROM up3 ORDER BY nama_up3";
                      $result_up3 = mysqli_query($connection, $query_up3);
                      while ($up3 = mysqli_fetch_array($result_up3)) {
                        echo "<option value='" . $up3['id_up3'] . "'>" . $up3['nama_up3'] . "</option>";
                      }
                      ?>
                    </select>
                  </div>

                  <!-- Filter ULD/Sentral -->
                  <div class="mb-3">
                    <label for="export_uld" class="form-label">Pilih Sentral</label>
                    <select name="export_uld" id="export_uld" class="form-select">
                      <option value="">Semua Sentral</option>
                    </select>
                  </div>

                  <!-- Filter Sistem -->
                  <div class="mb-3">
                    <label for="export_sistem" class="form-label">Pilih Sistem</label>
                    <select name="export_sistem" id="export_sistem" class="form-select">
                      <option value="">Semua Sistem</option>
                      <option value="Isolated">Isolated</option>
                      <option value="Interkoneksi">Interkoneksi</option>
                      <option value="Disconnected">Disconnected</option>
                    </select>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                  <button type="submit" class="btn btn-primary">Export Excel</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-6 d-flex justify-content-end">
        <!-- Dropdown filter untuk sistem dan form pencarian ke pojok kanan -->
        <form action="" method="GET" class="d-flex">
          <input type="hidden" name="id_up3" value="<?= $id_up3; ?>">
          <input type="hidden" name="id_uld" value="<?= $id_uld; ?>">

          <select name="filter_sistem" class="form-control me-2">
            <option value="">Semua Sistem</option>
            <option value="Isolated" <?= isset($_GET['filter_sistem']) && $_GET['filter_sistem'] == 'Isolated' ? 'selected' : '' ?>>Isolated</option>
            <option value="Interkoneksi" <?= isset($_GET['filter_sistem']) && $_GET['filter_sistem'] == 'Interkoneksi' ? 'selected' : '' ?>>Interkoneksi</option>
            <option value="Disconnected" <?= isset($_GET['filter_sistem']) && $_GET['filter_sistem'] == 'Disconnected' ? 'selected' : '' ?>>Disconnected</option>
          </select>

          <input type="text" class="form-control me-2" name="nama_mesin" placeholder="Cari Nama Mesin" value="<?= htmlspecialchars($search); ?>" style="width: 200px;"> <!-- Memperpanjang input pencarian -->

          <button type="submit" class="btn btn-primary">Search</button>
        </form>
      </div>
    </div>

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
                <td style="white-space: nowrap; overflow: hidden; max-width: 300px;"><?= $mesin['nama_uld'] ?></td> <!-- Menampilkan Nama ULD sebagai Sentral -->
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

      <!-- Tambahkan Script untuk Dynamic ULD Dropdown -->
      <script>
        function loadULD(id_up3) {
          const uldSelect = document.getElementById('export_uld');
          uldSelect.innerHTML = '<option value="">Semua Sentral</option>';

          if (id_up3) {
            fetch(`get_uld.php?id_up3=${id_up3}`)
              .then(response => response.json())
              .then(data => {
                data.forEach(uld => {
                  const option = document.createElement('option');
                  option.value = uld.id_uld;
                  option.textContent = uld.nama_uld;
                  uldSelect.appendChild(option);
                });
              });
          }
        }
      </script>

      <!-- Pagination Links -->
      <nav aria-label="Page navigation">
        <ul class="pagination justify-content-end">
          <?php if ($page > 1): ?>
            <li class="page-item">
              <a class="page-link" href="?id_up3=<?= $id_up3 ?>&id_uld=<?= $id_uld ?>&page=<?= $page - 1 ?>&nama_mesin=<?= $search ?>&filter_sistem=<?= $filter_sistem ?>" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
              </a>
            </li>
          <?php endif; ?>

          <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <li class="page-item <?= $i == $page ? 'active' : '' ?>">
              <a class="page-link" href="?id_up3=<?= $id_up3 ?>&id_uld=<?= $id_uld ?>&page=<?= $i ?>&nama_mesin=<?= $search ?>&filter_sistem=<?= $filter_sistem ?>"><?= $i ?></a>
            </li>
          <?php endfor; ?>

          <?php if ($page < $total_pages): ?>
            <li class="page-item">
              <a class="page-link" href="?id_up3=<?= $id_up3 ?>&id_uld=<?= $id_uld ?>&page=<?= $page + 1 ?>&nama_mesin=<?= $search ?>&filter_sistem=<?= $filter_sistem ?>" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
              </a>
            </li>
          <?php endif; ?>
        </ul>
      </nav>
    </div>
  </div>
</div>

<?= include('../layout/footer.php') ?>