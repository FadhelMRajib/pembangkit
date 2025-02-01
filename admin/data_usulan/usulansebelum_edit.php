<?php
session_start();
$judul = "Edit Data Usulan";
include('../layout/header.php');
require_once('../../config.php');

// Ambil ID dari parameter URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Ambil data berdasarkan ID
$query = "SELECT * FROM usulan_sebelum WHERE id = ?";
$stmt = mysqli_prepare($connection, $query);
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$data = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

// Jika data tidak ditemukan
if (!$data) {
    echo "<script>
        alert('Data tidak ditemukan!');
        window.location.href = 'usulan_sebelum.php';
    </script>";
    exit;
}

// Fields yang akan digunakan
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

// Fungsi untuk sanitasi input
function sanitize_input($input)
{
    return htmlspecialchars(trim($input));
}

// Proses update atau simpan data
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $input_data = [];
    foreach ($fields as $field) {
        $input_data[$field] = isset($_POST[$field]) ? sanitize_input($_POST[$field]) : '';
    }

    // Update Data Usulan
    if (isset($_POST['edit_usulan'])) {
        $setFields = implode(', ', array_map(fn($field) => "$field = ?", $fields));
        $query = "UPDATE usulan_sebelum SET $setFields WHERE id = ?";
        $stmt = mysqli_prepare($connection, $query);

        if ($stmt) {
            $params = array_values($input_data);
            $params[] = $id;
            $types = str_repeat('s', count($fields)) . 'i';

            mysqli_stmt_bind_param($stmt, $types, ...$params);
            if (mysqli_stmt_execute($stmt)) {
                echo "<script>
                    alert('Data berhasil diperbarui!');
                    window.location.href = 'usulan_sebelum.php';
                </script>";
            } else {
                echo "<script>alert('Gagal memperbarui data!');</script>";
            }
            mysqli_stmt_close($stmt);
        }
    }

    // Simpan Data ke Usulan Sesudah
    if (isset($_POST['simpan_usulan'])) {
        $placeholders = implode(', ', array_fill(0, count($fields), '?'));
        $query = "INSERT INTO usulan_sesudah (" . implode(', ', $fields) . ") VALUES ($placeholders)";
        $stmt = mysqli_prepare($connection, $query);

        if ($stmt) {
            $params = array_values($input_data);
            $types = str_repeat('s', count($fields));

            mysqli_stmt_bind_param($stmt, $types, ...$params);
            if (mysqli_stmt_execute($stmt)) {
                echo "<script>
                    alert('Data berhasil disimpan ke usulan sesudah!');
                    window.location.href = 'usulan_sesudah.php';
                </script>";
            } else {
                echo "<script>alert('Gagal menyimpan data ke usulan sesudah!');</script>";
            }
            mysqli_stmt_close($stmt);
        }
    }
}

?>

<div class="page-body">
    <div class="container-xl">
        <div class="row row-cards">
            <div class="col-12">
                <form class="card" method="POST">
                    <div class="card-body">
                        <div class="row">
                            <?php foreach (array_chunk($fields, 10) as $chunk): ?>
                                <div class="col-md-4">
                                    <?php foreach ($chunk as $field): ?>
                                        <div class="mb-3">
                                            <label class="form-label"><?= ucwords(str_replace('_', ' ', $field)) ?></label>
                                            <input type="text" class="form-control" name="<?= $field ?>" value="<?= $data[$field] ?>" required>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <a href="usulan_sebelum.php" class="btn btn-secondary me-2">Kembali</a>
                        <button type="submit" class="btn btn-primary" name="edit_usulan">Edit Usulan</button>
                        <button type="submit" class="btn btn-primary" name="simpan_usulan">Simpan Usulan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include('../layout/footer.php'); ?>