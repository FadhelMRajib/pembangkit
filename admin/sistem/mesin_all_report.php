<?php
session_start();
require_once('../../config.php');

// Ambil parameter filter dari URL
$id_up3 = isset($_GET['export_up3']) ? $_GET['export_up3'] : '';
$id_uld = isset($_GET['export_uld']) ? $_GET['export_uld'] : '';
$sistem = isset($_GET['export_sistem']) ? $_GET['export_sistem'] : '';

// Cek apakah ini adalah request download
$is_download = isset($_GET['download']) && $_GET['download'] == 'true';

// Set header sesuai dengan jenis request
if ($is_download) {
    header("Content-type: application/vnd-ms-excel");
    header("Content-Disposition: attachment; filename=Data_Mesin_Filtered.xls");
}

// Bangun query berdasarkan filter dengan urutan kustom
$query = "
    SELECT 
        mesin.*,
        uld.nama_uld,
        up3.nama_up3
    FROM mesin 
    JOIN uld ON mesin.id_uld = uld.id_uld 
    JOIN up3 ON mesin.id_up3 = up3.id_up3
    WHERE 1=1
";

if (!empty($id_up3)) {
    $query .= " AND mesin.id_up3 = '$id_up3'";
}
if (!empty($id_uld)) {
    $query .= " AND mesin.id_uld = '$id_uld'";
}
if (!empty($sistem)) {
    $query .= " AND mesin.sistem = '$sistem'";
}

// Menambahkan ORDER BY dengan urutan kustom menggunakan CASE
$query .= " ORDER BY 
    CASE 
        WHEN up3.nama_up3 LIKE '%Banjarmasin%' THEN 1
        WHEN up3.nama_up3 LIKE '%Kuala Kapuas%' THEN 2
        WHEN up3.nama_up3 LIKE '%Palangka Raya%' THEN 3
        WHEN up3.nama_up3 LIKE '%Pangkalan Bun%' THEN 4
        WHEN mesin.sistem = 'IPP' THEN 5
        WHEN mesin.sistem = 'EXCESS' THEN 6
        ELSE 7
    END,
    nama_mesin ASC";

$result = mysqli_query($connection, $query);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Laporan Data Mesin</title>
    <?php if (!$is_download): ?>
        <style>
            body {
                font-family: Arial, sans-serif;
                margin: 20px;
            }

            .header {
                text-align: center;
                margin-bottom: 20px;
            }

            .download-btn {
                background-color: #4CAF50;
                border: none;
                color: white;
                padding: 10px 20px;
                text-align: center;
                text-decoration: none;
                display: inline-block;
                font-size: 16px;
                margin: 4px 2px;
                cursor: pointer;
                border-radius: 4px;
            }

            .preview-container {
                margin: 20px 0;
                overflow-x: auto;
            }

            .preview-table {
                border-collapse: collapse;
                width: 100%;
                margin-top: 20px;
                text-align: center;
            }

            .preview-table th,
            .preview-table td {
                border: 1px solid #ddd;
                padding: 8px;
            }

            .preview-table th {
                background-color: #FFFF00;
                font-weight: bold;
            }

            .preview-table tr:nth-child(even) {
                background-color: #f2f2f2;
            }

            .preview-table tr:hover {
                background-color: #ddd;
            }

            .action-buttons {
                margin: 20px 0;
                text-align: right;
            }

            .back-btn {
                background-color: #f44336;
                color: white;
                padding: 10px 20px;
                text-decoration: none;
                border-radius: 4px;
                margin-right: 10px;
            }

            @media print {
                .action-buttons {
                    display: none;
                }
            }
        </style>
    <?php endif; ?>
</head>

<body>
    <?php if (!$is_download): ?>
        <div class="action-buttons">
            <a href="mesin.php" class="back-btn">Kembali</a>
            <a href="<?php echo $_SERVER['REQUEST_URI'] . '&download=true'; ?>" class="download-btn">
                Download Excel
            </a>
        </div>
    <?php endif; ?>

    <div class="header">
        <h3>LAPORAN DATA MESIN</h3>
        <h3>PT PLN (PERSERO) UNIT INDUK WILAYAH KALIMANTAN SELATAN DAN TENGAH</h3>
        <?php if (!empty($id_up3) || !empty($id_uld) || !empty($sistem)): ?>
            <h4>
                <?php
                if (!empty($id_up3)) {
                    $up3_name = mysqli_fetch_assoc(mysqli_query($connection, "SELECT nama_up3 FROM up3 WHERE id_up3 = '$id_up3'"))['nama_up3'];
                    echo "UP3: $up3_name ";
                }
                if (!empty($id_uld)) {
                    $uld_name = mysqli_fetch_assoc(mysqli_query($connection, "SELECT nama_uld FROM uld WHERE id_uld = '$id_uld'"))['nama_uld'];
                    echo "| Sentral: $uld_name ";
                }
                if (!empty($sistem)) {
                    echo "| Sistem: $sistem";
                }
                ?>
            </h4>
        <?php endif; ?>
    </div>

    <div class="preview-container">
        <table <?php echo $is_download ? 'border="1"' : 'class="preview-table"'; ?>>
            <thead>
                <tr style="background-color: #FFFF00;">
                    <th>No.</th>
                    <th>UP3</th>
                    <th>Sentral</th>
                    <th>Nama Mesin</th>
                    <th>Kode Mesin</th>
                    <th>Sistem</th>
                    <th>Merk Mesin</th>
                    <th>Type Mesin</th>
                    <th>Seri Mesin</th>
                    <th>Merk Generator</th>
                    <th>Nama Trafo</th>
                    <th>Tegangan (kV)</th>
                    <th>Kapasitas (MW)</th>
                    <th>Tahun Operasi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                while ($row = mysqli_fetch_array($result)):
                ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $row['nama_up3'] ?></td>
                        <td><?= $row['nama_uld'] ?></td>
                        <td><?= $row['nama_mesin'] ?></td>
                        <td><?= $row['kode_mesin'] ?></td>
                        <td><?= $row['sistem'] ?></td>
                        <td><?= $row['merek_mesin'] ?></td>
                        <td><?= $row['tipe_mesin'] ?></td>
                        <td><?= $row['seri_mesin'] ?></td>
                        <td><?= $row['merek_generator'] ?></td>
                        <td><?= $row['nama_trafo'] ?></td>
                        <td><?= $row['tegangan'] ?></td>
                        <td><?= $row['kapasitas'] ?></td>
                        <td><?= $row['tahun_operasi'] ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <div style="text-align: right;">
        <p>Banjarmasin, <?= date('d F Y') ?></p>
        <br><br><br>
        <p>(_________________________)</p>
        <p>NIP.</p>
    </div>
</body>

</html>