<?php
session_start();

$judul = "Data Usulan Sebelum diubah";
include('../layout/header.php');
require_once('../../config.php');

// Pencarian dan pagination
$search = isset($_GET['kode_usulan']) ? $_GET['kode_usulan'] : '';
$filter_status = isset($_GET['filter_status']) ? $_GET['filter_status'] : '';

$limit = 5; // Jumlah data per halaman
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Query untuk menghitung total data
$count_query = "SELECT COUNT(*) AS total FROM usulan_sebelum WHERE 1=1";
if (!empty($search)) {
    $count_query .= " AND kode_bhnbakar LIKE '%$search%'";
}
if (!empty($filter_status)) {
    $count_query .= " AND status = '$filter_status'";
}
$count_result = mysqli_query($connection, $count_query);
$total_rows = mysqli_fetch_assoc($count_result)['total'];
$total_pages = ceil($total_rows / $limit);

// Query untuk mengambil data usulan
$query = "
    SELECT * FROM usulan_sebelum 
    WHERE 1=1
";
if (!empty($search)) {
    $query .= " AND kode_bhnbakar LIKE '%$search%'";
}
if (!empty($filter_status)) {
    $query .= " AND status = '$filter_status'";
}
$query .= " ORDER BY id ASC LIMIT $limit OFFSET $offset";
$result = mysqli_query($connection, $query);
?>

<!-- Page body -->
<div class="page-body">
    <div class="container-xl">
        <div class="row">
            <div class="col-md-6">
                <a href="<?= base_url('admin/data_usulan/usulansebelum_tambah.php') ?>" class="btn btn-primary">
                    <span class="text"><i class="fa-solid fa-circle-plus"></i> Tambah Data</span>
                </a>
            </div>

            <!-- <div class="col-md-6 d-flex justify-content-end">
                Form pencarian dan filter -->
            <!-- <form action="" method="GET" class="d-flex">
                    <select name="filter_status" class="form-control me-2">
                        <option value="">Semua Status</option>
                        <option value="Isolated" <?= isset($_GET['filter_status']) && $_GET['filter_status'] == 'Isolated' ? 'selected' : '' ?>>Isolated</option>
                        <option value="Interkoneksi" <?= isset($_GET['filter_status']) && $_GET['filter_status'] == 'Interkoneksi' ? 'selected' : '' ?>>Interkoneksi</option>
                    </select>

                    <input type="text" class="form-control me-2" name="kode_usulan" placeholder="Cari Kode Usulan" value="<?= htmlspecialchars($search); ?>" style="width: 200px;">
                    <button type="submit" class="btn btn-primary">Search</button>
                </form>
            </div> -->
        </div>

        <div class="row row-deck row-cards mt-2">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <tr class="text-center">
                        <th>No.</th>
                        <th>Kode Ranting</th>
                        <th>Ranting</th>
                        <th>Kode Sentral</th>
                        <th>Sentral</th>
                        <th>Mesin</th>
                        <th>Kode Mesin</th>
                        <th>Sistem</th>
                        <th>Provinsi</th>
                        <th>Merek</th>
                        <th>Tipe</th>
                        <th>Seri</th>
                        <th>Merek Generator</th>
                        <th>Nama Trafo</th>
                        <th>Tegangan</th>
                        <th>Kapasitas</th>
                        <th>Tahun</th>
                        <th>Kode Bahan Bakar</th>
                        <th>Kode Pembangkit</th>
                        <th>Status</th>
                        <th>Kode Status</th>
                        <th>Kode Jenis Bahan Bakar</th>
                        <th>Jenis Tegangan</th>
                        <th>Daya Terpasang</th>
                        <th>Daya Mampu</th>
                        <th>Kondisi</th>
                        <th>Kode Kondisi</th>
                        <th>Mutasi</th>
                        <th>Kode Mutasi</th>
                        <th>Keterangan</th>
                        <th>Aksi</th>
                    </tr>

                    <?php if (mysqli_num_rows($result) === 0): ?>
                        <tr>
                            <td colspan="15" class="text-center">Data Tidak Ditemukan</td>
                        </tr>
                    <?php else: ?>
                        <?php $no = $offset + 1;
                        while ($usulan = mysqli_fetch_array($result)): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $usulan['kode_ranting'] ?></td>
                                <td style="white-space: nowrap; overflow: hidden; max-width: 300px;"><?= $usulan['ranting'] ?></td>
                                <td><?= $usulan['kode_sentral'] ?></td>
                                <td style="white-space: nowrap; overflow: hidden; max-width: 300px;"><?= $usulan['sentral'] ?></td>
                                <td style="white-space: nowrap; overflow: hidden; max-width: 300px;"><?= $usulan['mesin'] ?></td>
                                <td><?= $usulan['kode_mesin'] ?></td>
                                <td style="white-space: nowrap; overflow: hidden; max-width: 300px;"><?= $usulan['sistem'] ?></td>
                                <td><?= $usulan['provinsi'] ?></td>
                                <td><?= $usulan['merek'] ?></td>
                                <td style="white-space: nowrap; overflow: hidden; max-width: 300px;"><?= $usulan['tipe'] ?></td>
                                <td><?= $usulan['seri'] ?></td>
                                <td><?= $usulan['merek_generator'] ?></td>
                                <td><?= $usulan['nama_trafo'] ?></td>
                                <td><?= $usulan['tegangan'] ?></td>
                                <td><?= $usulan['kapasitas'] ?></td>
                                <td><?= $usulan['tahun'] ?></td>
                                <td><?= $usulan['kode_bhnbakar'] ?></td>
                                <td><?= $usulan['kode_pembangkit'] ?></td>
                                <td><?= $usulan['status'] ?></td>
                                <td><?= $usulan['kode_status'] ?></td>
                                <td><?= $usulan['kode_jenis_bhnbakar'] ?></td>
                                <td><?= $usulan['jenis_teg'] ?></td>
                                <td><?= $usulan['daya_terpasang'] ?></td>
                                <td><?= $usulan['daya_mampu'] ?></td>
                                <td><?= $usulan['kondisi'] ?></td>
                                <td><?= $usulan['kode_kondisi'] ?></td>
                                <td><?= $usulan['mutasi'] ?></td>
                                <td><?= $usulan['kode_mutasi'] ?></td>
                                <td><?= $usulan['keterangan'] ?></td>
                                <td class="text-center">
                                    <a href="<?= base_url('admin/data_usulan/usulansebelum_edit.php?id=' . $usulan['id']) ?>" class="badge bg-primary">Edit</a>
                                    <a href="<?= base_url('admin/data_usulan/hapus.php?id=' . $usulan['id']) ?>" class="badge bg-danger tombol-hapus">Hapus</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php endif; ?>
                </table>
            </div>

            <!-- Pagination -->
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-end">
                    <?php if ($page > 1): ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=<?= $page - 1 ?>&kode_usulan=<?= $search ?>&filter_status=<?= $filter_status ?>" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                        <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                            <a class="page-link" href="?page=<?= $i ?>&kode_usulan=<?= $search ?>&filter_status=<?= $filter_status ?>"><?= $i ?></a>
                        </li>
                    <?php endfor; ?>

                    <?php if ($page < $total_pages): ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=<?= $page + 1 ?>&kode_usulan=<?= $search ?>&filter_status=<?= $filter_status ?>" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </div>
</div>

<?php include('../layout/footer.php'); ?>