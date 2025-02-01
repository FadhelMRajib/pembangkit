<?php
session_start();
$judul = "Tambah Data Usulan";
include('../layout/header.php');
require_once('../../config.php');

// Proses form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fields = [
        'kode_ranting',
        'ranting',
        'kode_sentral',
        'sentral',
        'mesin',
        'kode_mesin',
        'sistem',
        'provinsi',
        'merek',
        'tipe',
        'seri',
        'merek_generator',
        'nama_trafo',
        'tegangan',
        'kapasitas',
        'tahun',
        'kode_bhnbakar',
        'kode_pembangkit',
        'status',
        'kode_status',
        'kode_jenis_bhnbakar',
        'jenis_teg',
        'daya_terpasang',
        'daya_mampu',
        'kondisi',
        'kode_kondisi',
        'mutasi',
        'kode_mutasi',
        'keterangan'
    ];

    // Prepare the query
    $columns = implode(', ', $fields);
    $values = implode(', ', array_fill(0, count($fields), '?'));
    $query = "INSERT INTO usulan_sebelum ($columns) VALUES ($values)";

    $stmt = mysqli_prepare($connection, $query);

    if ($stmt) {
        // Bind parameters dynamically
        $params = array_map(function ($field) {
            return $_POST[$field];
        }, $fields);

        $types = str_repeat('s', count($fields));
        mysqli_stmt_bind_param($stmt, $types, ...$params);

        if (mysqli_stmt_execute($stmt)) {
            echo "<script>
                alert('Data berhasil ditambahkan!');
                window.location.href = 'usulan_sebelum.php';
            </script>";
        } else {
            echo "<script>alert('Gagal menambahkan data!');</script>";
        }
        mysqli_stmt_close($stmt);
    }
}
?>

<!-- Page body -->
<div class="page-body">
    <div class="container-xl">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-md-12">
                <form class="card" method="POST">
                    <div class="card-body">
                        <div class="row g-3">
                            <!-- Kolom 1 -->
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Kode Ranting</label>
                                    <input type="text" class="form-control" name="kode_ranting" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Pilih Ranting</label>
                                    <select name="kode_ranting" class="form-select" required>
                                        <option value="">Pilih Kota</option>
                                        <option value="Kota Baru">Kota Baru</option>
                                        <option value="Kuala Kapuas">Kuala Kapuas</option>
                                        <option value="Palangka Raya">Palangka Raya</option>
                                        <option value="Pangkalanbuun">Pangkalanbuun</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Kode Sentral</label>
                                    <input type="text" class="form-control" name="kode_sentral" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Sentral</label>
                                    <input type="text" class="form-control" name="sentral" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Mesin</label>
                                    <input type="text" class="form-control" name="mesin" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Kode Mesin</label>
                                    <input type="text" class="form-control" name="kode_mesin" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Sistem</label>
                                    <input type="text" class="form-control" name="sistem" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Provinsi</label>
                                    <input type="text" class="form-control" name="provinsi" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Merek</label>
                                    <input type="text" class="form-control" name="merek" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Tipe</label>
                                    <input type="text" class="form-control" name="tipe" required>
                                </div>
                            </div>

                            <!-- Kolom 2 -->
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Seri</label>
                                    <input type="text" class="form-control" name="seri" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Merek Generator</label>
                                    <input type="text" class="form-control" name="merek_generator" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Nama Trafo</label>
                                    <input type="text" class="form-control" name="nama_trafo" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Tegangan</label>
                                    <input type="text" class="form-control" name="tegangan" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Kapasitas</label>
                                    <input type="text" class="form-control" name="kapasitas" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Tahun</label>
                                    <input type="number" class="form-control" name="tahun" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Kode Bahan Bakar</label>
                                    <input type="text" class="form-control" name="kode_bhnbakar" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Kode Pembangkit</label>
                                    <input type="text" class="form-control" name="kode_pembangkit" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Status</label>
                                    <input type="text" class="form-control" name="status" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Kode Status</label>
                                    <input type="text" class="form-control" name="kode_status" required>
                                </div>
                            </div>

                            <!-- Kolom 3 -->
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Kode Jenis Bahan Bakar</label>
                                    <input type="text" class="form-control" name="kode_jenis_bhnbakar" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Jenis Tegangan</label>
                                    <input type="text" class="form-control" name="jenis_teg" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Daya Terpasang</label>
                                    <input type="text" class="form-control" name="daya_terpasang" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Daya Mampu</label>
                                    <input type="text" class="form-control" name="daya_mampu" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Kondisi</label>
                                    <input type="text" class="form-control" name="kondisi" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Kode Kondisi</label>
                                    <input type="text" class="form-control" name="kode_kondisi" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Mutasi</label>
                                    <input type="text" class="form-control" name="mutasi" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Kode Mutasi</label>
                                    <input type="text" class="form-control" name="kode_mutasi" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Keterangan</label>
                                    <textarea class="form-control" name="keterangan" rows="3"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-between">
                        <a href="usulan_sebelum.php" class="btn btn-secondary">Kembali</a>
                        <button type="submit" class="btn btn-primary">Simpan Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<?php include('../layout/footer.php'); ?>