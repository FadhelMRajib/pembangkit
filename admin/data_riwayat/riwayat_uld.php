<?php
session_start();

$judul = "Riwayat ULD";
include('../layout/header.php');
require_once('../../config.php');

// Cek apakah parameter id_up3 ada
if (isset($_GET['id_up3'])) {
    $id_up3 = $_GET['id_up3'];

    // Cek apakah ada pencarian nama ULD dan sistem
    $search = isset($_GET['nama_uld']) ? $_GET['nama_uld'] : '';
    $filter_sistem = isset($_GET['sistem']) ? $_GET['sistem'] : '';

    // Pagination configuration
    $limit = 5; // Jumlah data per halaman
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $offset = ($page - 1) * $limit;

    // Query untuk menghitung total data riwayat
    $count_query = "SELECT COUNT(*) AS total 
                  FROM riwayat_uld 
                  INNER JOIN uld ON riwayat_uld.id_uld = uld.id_uld 
                  WHERE uld.id_up3 = '$id_up3'";
    if (!empty($search)) {
        $count_query .= " AND uld.nama_uld LIKE '%$search%'";
    }
    if (!empty($filter_sistem)) {
        $count_query .= " AND uld.sistem = '$filter_sistem'";
    }
    $count_result = mysqli_query($connection, $count_query);
    $total_rows = mysqli_fetch_assoc($count_result)['total'];
    $total_pages = ceil($total_rows / $limit);

    // Query untuk mendapatkan data riwayat ULD dengan join
    $query = "SELECT riwayat_uld.*, uld.nama_uld, uld.sistem 
            FROM riwayat_uld 
            INNER JOIN uld ON riwayat_uld.id_uld = uld.id_uld 
            WHERE uld.id_up3 = '$id_up3'";
    if (!empty($search)) {
        $query .= " AND uld.nama_uld LIKE '%$search%'";
    }
    if (!empty($filter_sistem)) {
        $query .= " AND uld.sistem = '$filter_sistem'";
    }
    $query .= " ORDER BY riwayat_uld.tanggal DESC LIMIT $limit OFFSET $offset";

    $result = mysqli_query($connection, $query);
} else {
    // Jika id_up3 tidak ada, tampilkan pesan error atau alihkan ke halaman sebelumnya
    echo "<p>ID UP3 tidak ditemukan.</p>";
    exit;
}
?>

<!-- Page body -->
<div class="page-body">
    <div class="container-xl">
        <div class="row">
            <div class="col-md-8">
                <h3>Riwayat ULD</h3>
            </div>
            <div class="col-md-4 d-flex justify-content-end">
                <!-- Form Pencarian dan Filter -->
                <form action="" method="GET" class="d-flex">
                    <!-- Filter Sistem -->
                    <select name="sistem" class="form-control me-2">
                        <option value="">-- Pilih Sistem --</option>
                        <option value="Isolated" <?= ($filter_sistem == 'Isolated') ? 'selected' : '' ?>>Isolated</option>
                        <option value="Interkoneksi" <?= ($filter_sistem == 'Interkoneksi') ? 'selected' : '' ?>>Interkoneksi</option>
                        <option value="Disconnected" <?= ($filter_sistem == 'Disconnected') ? 'selected' : '' ?>>Disconnected</option>
                    </select>

                    <input type="hidden" name="id_up3" value="<?= $id_up3; ?>">
                    <input type="text" class="form-control me-2" name="nama_uld" placeholder="Search by ULD name" value="<?= htmlspecialchars($search); ?>">

                    <button type="submit" class="btn btn-primary">Search</button>
                </form>
            </div>
        </div>

        <div class="row row-deck row-cards mt-2">
            <table class="table table-bordered">
                <tr class="text-center">
                    <th>No.</th>
                    <th>Nama ULD</th>
                    <th>Sistem</th>
                    <th>Aksi</th>
                    <th>Tanggal</th>
                </tr>

                <?php if (mysqli_num_rows($result) === 0): ?>
                    <tr>
                        <td colspan="5">Data Riwayat Kosong</td>
                    </tr>
                <?php else : ?>
                    <?php $no = $offset + 1; // Mengatur nomor urut sesuai halaman
                    while ($uld = mysqli_fetch_array($result)): ?>
                        <tr class="text-center">
                            <td><?= $no++ ?></td>
                            <td><?= htmlspecialchars($uld['nama_uld']) ?></td>
                            <td><?= htmlspecialchars($uld['sistem']) ?></td>
                            <td><?= htmlspecialchars($uld['aksi']) ?></td>
                            <td><?= htmlspecialchars(date('d-m-Y', strtotime($uld['tanggal']))) ?></td>
                        </tr>
                    <?php endwhile ?>
                <?php endif; ?>
            </table>
        </div>

        <!-- Pagination Links -->
        <div class="row">
            <div class="col-12">
                <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-end">
                        <?php if ($page > 1): ?>
                            <li class="page-item">
                                <a class="page-link" href="?id_up3=<?= $id_up3 ?>&page=<?= $page - 1 ?>&nama_uld=<?= $search ?>&sistem=<?= $filter_sistem ?>" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                        <?php endif; ?>

                        <!-- Loop through all pages -->
                        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                            <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                                <a class="page-link" href="?id_up3=<?= $id_up3 ?>&page=<?= $i ?>&nama_uld=<?= $search ?>&sistem=<?= $filter_sistem ?>"><?= $i ?></a>
                            </li>
                        <?php endfor; ?>

                        <?php if ($page < $total_pages): ?>
                            <li class="page-item">
                                <a class="page-link" href="?id_up3=<?= $id_up3 ?>&page=<?= $page + 1 ?>&nama_uld=<?= $search ?>&sistem=<?= $filter_sistem ?>" aria-label="Next">
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