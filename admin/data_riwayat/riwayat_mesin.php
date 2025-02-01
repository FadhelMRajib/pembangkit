<?php
session_start();

$judul = "Riwayat Mesin";
include('../layout/header.php');
require_once('../../config.php');

// Pencarian dan pagination
$search = isset($_GET['nama_mesin']) ? mysqli_real_escape_string($connection, $_GET['nama_mesin']) : '';
$filter_sistem = isset($_GET['sistem']) ? mysqli_real_escape_string($connection, $_GET['sistem']) : '';
$filter_tahun = isset($_GET['tahun_operasi']) ? mysqli_real_escape_string($connection, $_GET['tahun_operasi']) : '';

$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Query untuk menghitung total data
$count_query = "SELECT COUNT(*) AS total FROM riwayat_mesin WHERE 1=1";
$params = array();

if (!empty($search)) {
    $count_query .= " AND nama_mesin LIKE ?";
    $params[] = "%$search%";
}
if (!empty($filter_sistem)) {
    $count_query .= " AND sistem = ?";
    $params[] = $filter_sistem;
}
if (!empty($filter_tahun)) {
    $count_query .= " AND tahun_operasi = ?";
    $params[] = $filter_tahun;
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

// Query untuk mendapatkan data riwayat
$query = "SELECT * FROM riwayat_mesin WHERE 1=1";

if (!empty($search)) {
    $query .= " AND nama_mesin LIKE ?";
}
if (!empty($filter_sistem)) {
    $query .= " AND sistem = ?";
}
if (!empty($filter_tahun)) {
    $query .= " AND tahun_operasi = ?";
}
$query .= " ORDER BY id DESC LIMIT ? OFFSET ?";

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
        <div class="row">
            <div class="col-md-6 d-flex justify-content-end">
                <form action="" method="GET" class="d-flex">
                    <input type="text" class="form-control me-2" name="nama_mesin" placeholder="Cari Nama Mesin" value="<?= htmlspecialchars($search); ?>">
                    <select name="sistem" class="form-control me-2">
                        <option value="">-- Pilih Sistem --</option>
                        <option value="Isolated" <?= ($filter_sistem == 'Isolated') ? 'selected' : '' ?>>Isolated</option>
                        <option value="Interkoneksi" <?= ($filter_sistem == 'Interkoneksi') ? 'selected' : '' ?>>Interkoneksi</option>
                    </select>
                    <input type="text" class="form-control me-2" name="tahun_operasi" placeholder="Tahun Operasi" value="<?= htmlspecialchars($filter_tahun); ?>">
                    <button type="submit" class="btn btn-primary">Search</button>
                </form>
            </div>
        </div>

        <div class="row row-deck row-cards mt-2">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr class="text-center">
                            <th>No.</th>
                            <th>Sistem</th>
                            <th>Nama Mesin</th>
                            <th>Kode Mesin</th>
                            <th>Merek Mesin</th>
                            <th>Tipe Mesin</th>
                            <th>Seri Mesin</th>
                            <th>Merek Generator</th>
                            <th>Nama Trafo</th>
                            <th>Tegangan</th>
                            <th>Kapasitas</th>
                            <th>Tahun Operasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (mysqli_num_rows($result) === 0): ?>
                            <tr>
                                <td colspan="12" class="text-center">Data Tidak Ditemukan</td>
                            </tr>
                        <?php else: ?>
                            <?php $no = $offset + 1; ?>
                            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= htmlspecialchars($row['sistem']) ?></td>
                                    <td><?= htmlspecialchars($row['nama_mesin']) ?></td>
                                    <td><?= htmlspecialchars($row['kode_mesin']) ?></td>
                                    <td><?= htmlspecialchars($row['merek_mesin']) ?></td>
                                    <td><?= htmlspecialchars($row['tipe_mesin']) ?></td>
                                    <td><?= htmlspecialchars($row['seri_mesin']) ?></td>
                                    <td><?= htmlspecialchars($row['merek_generator']) ?></td>
                                    <td><?= htmlspecialchars($row['nama_trafo']) ?></td>
                                    <td><?= htmlspecialchars($row['tegangan']) ?></td>
                                    <td><?= htmlspecialchars($row['kapasitas']) ?></td>
                                    <td><?= htmlspecialchars($row['tahun_operasi']) ?></td>
                                </tr>
                            <?php endwhile; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="d-flex justify-content-end mt-4">
            <nav aria-label="Page navigation">
                <ul class="pagination">
                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                        <li class="page-item <?= ($page == $i) ? 'active' : '' ?>">
                            <a class="page-link" href="?page=<?= $i ?><?= !empty($search) ? '&nama_mesin=' . urlencode($search) : '' ?><?= !empty($filter_sistem) ? '&sistem=' . urlencode($filter_sistem) : '' ?><?= !empty($filter_tahun) ? '&tahun_operasi=' . urlencode($filter_tahun) : '' ?>">
                                <?= $i ?>
                            </a>
                        </li>
                    <?php endfor; ?>
                </ul>
            </nav>
        </div>
    </div>
</div>

<?php include('../layout/footer.php'); ?>