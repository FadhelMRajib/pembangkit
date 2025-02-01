<?php
session_start();
require_once('../../config.php');

// Cek apakah koneksi database tersedia
if (!$connection) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

// Cek apakah ini adalah request download
$is_download = isset($_GET['download']) && $_GET['download'] === 'true';

// Jika request download, atur header untuk file Excel
if ($is_download) {
    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=Data_Usulan.xls");
    header("Pragma: no-cache");
    header("Expires: 0");
    ob_clean(); // Bersihkan output buffer
    flush(); // Flush system output buffer
}

// Bangun query untuk usulan sebelum
$queryBefore = "SELECT * FROM usulan_sebelum";
$resultBefore = mysqli_query($connection, $queryBefore);

// Bangun query untuk usulan sesudah
$queryAfter = "SELECT * FROM usulan_sesudah";
$resultAfter = mysqli_query($connection, $queryAfter);

// Style untuk Excel
$excel_style = $is_download ? 'style="font-family: Calibri;"' : '';
$header_style = $is_download ? 'style="background-color: #ADD8E6; font-family: Calibri; font-weight: bold;"' : '';
$title_style = $is_download ? 'style="font-family: Calibri; color: #4F81BD; font-size: 14pt;"' : '';
?>

<!DOCTYPE html>
<html>

<head>
    <title>Laporan Data Usulan</title>
    <?php if (!$is_download): ?>
        <style>
            /* ... style sebelumnya tetap sama ... */
            body {
                font-family: Calibri, Arial, sans-serif;
                margin: 20px;
            }

            .header {
                text-align: center;
                margin-bottom: 20px;
            }

            .action-buttons {
                margin-bottom: 20px;
            }

            .btn {
                display: inline-block;
                padding: 10px 20px;
                margin-right: 10px;
                font-size: 16px;
                font-weight: bold;
                color: #ffffff;
                text-decoration: none;
                border-radius: 5px;
                transition: background-color 0.3s, transform 0.2s;
            }

            .btn-back {
                background-color: #6c757d;
                /* Grey */
            }

            .btn-back:hover {
                background-color: #5a6268;
                transform: scale(1.05);
            }

            .btn-download {
                background-color: #28a745;
                /* Green */
            }

            .btn-download:hover {
                background-color: #218838;
                transform: scale(1.05);
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
                background-color: #ADD8E6;
                font-weight: bold;
            }

            /* ... style lainnya tetap sama ... */
        </style>
    <?php endif; ?>
</head>

<body <?php echo $excel_style; ?>>
    <?php if (!$is_download): ?>
        <div class="action-buttons">
            <a href="usulan_sebelum.php" class="btn btn-back">
                Kembali
            </a>
            <a href="export_excel.php?download=true" class="btn btn-download">
                Download Excel
            </a>
        </div>
    <?php endif; ?>

    <div class="header">
        <h3>LAPORAN DATA USULAN</h3>
        <h3>PT PLN (PERSERO) UNIT INDUK WILAYAH KALIMANTAN SELATAN DAN TENGAH</h3>
    </div>

    <div class="preview-container">
        <h4 <?php echo $title_style; ?>>Usulan sebelum diubah</h4>
        <table border="1" <?php echo $is_download ? '' : 'class="preview-table"'; ?>>
            <thead>
                <tr>
                    <th <?php echo $header_style; ?>>No.</th>
                    <th <?php echo $header_style; ?>>Kode Ranting</th>
                    <th <?php echo $header_style; ?>>Ranting</th>
                    <th <?php echo $header_style; ?>>Kode Sentral</th>
                    <th <?php echo $header_style; ?>>Sentral</th>
                    <th <?php echo $header_style; ?>>Mesin</th>
                    <th <?php echo $header_style; ?>>Kode Mesin</th>
                    <th <?php echo $header_style; ?>>Sistem</th>
                    <th <?php echo $header_style; ?>>Provinsi</th>
                    <th <?php echo $header_style; ?>>Merek</th>
                    <th <?php echo $header_style; ?>>Tipe</th>
                    <th <?php echo $header_style; ?>>Seri</th>
                    <th <?php echo $header_style; ?>>Merek Generator</th>
                    <th <?php echo $header_style; ?>>Nama Trafo</th>
                    <th <?php echo $header_style; ?>>Tegangan</th>
                    <th <?php echo $header_style; ?>>Kapasitas</th>
                    <th <?php echo $header_style; ?>>Tahun</th>
                    <th <?php echo $header_style; ?>>Kode Bahan Bakar</th>
                    <th <?php echo $header_style; ?>>Kode Pembangkit</th>
                    <th <?php echo $header_style; ?>>Status</th>
                    <th <?php echo $header_style; ?>>Kode Status</th>
                    <th <?php echo $header_style; ?>>Kode Jenis Bahan Bakar</th>
                    <th <?php echo $header_style; ?>>Jenis Tegangan</th>
                    <th <?php echo $header_style; ?>>Daya Terpasang</th>
                    <th <?php echo $header_style; ?>>Daya Mampu</th>
                    <th <?php echo $header_style; ?>>Kondisi</th>
                    <th <?php echo $header_style; ?>>Kode Kondisi</th>
                    <th <?php echo $header_style; ?>>Mutasi</th>
                    <th <?php echo $header_style; ?>>Kode Mutasi</th>
                    <th <?php echo $header_style; ?>>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                while ($row = mysqli_fetch_array($resultBefore)):
                ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $row['kode_ranting'] ?></td>
                        <td><?= $row['ranting'] ?></td>
                        <td><?= $row['kode_sentral'] ?></td>
                        <td><?= $row['sentral'] ?></td>
                        <td><?= $row['mesin'] ?></td>
                        <td><?= $row['kode_mesin'] ?></td>
                        <td><?= $row['sistem'] ?></td>
                        <td><?= $row['provinsi'] ?></td>
                        <td><?= $row['merek'] ?></td>
                        <td><?= $row['tipe'] ?></td>
                        <td><?= $row['seri'] ?></td>
                        <td><?= $row['merek_generator'] ?></td>
                        <td><?= $row['nama_trafo'] ?></td>
                        <td><?= $row['tegangan'] ?></td>
                        <td><?= $row['kapasitas'] ?></td>
                        <td><?= $row['tahun'] ?></td>
                        <td><?= $row['kode_bhnbakar'] ?></td>
                        <td><?= $row['kode_pembangkit'] ?></td>
                        <td><?= $row['status'] ?></td>
                        <td><?= $row['kode_status'] ?></td>
                        <td><?= $row['kode_jenis_bhnbakar'] ?></td>
                        <td><?= $row['jenis_teg'] ?></td>
                        <td><?= $row['daya_terpasang'] ?></td>
                        <td><?= $row['daya_mampu'] ?></td>
                        <td><?= $row['kondisi'] ?></td>
                        <td><?= $row['kode_kondisi'] ?></td>
                        <td><?= $row['mutasi'] ?></td>
                        <td><?= $row['kode_mutasi'] ?></td>
                        <td><?= $row['keterangan'] ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <div class="preview-container">
        <h4 <?php echo $title_style; ?>>Usulan sesudah diubah</h4>
        <table border="1" <?php echo $is_download ? '' : 'class="preview-table"'; ?>>
            <thead>
                <tr>
                    <th <?php echo $header_style; ?>>No.</th>
                    <th <?php echo $header_style; ?>>Kode Ranting</th>
                    <th <?php echo $header_style; ?>>Ranting</th>
                    <th <?php echo $header_style; ?>>Kode Sentral</th>
                    <th <?php echo $header_style; ?>>Sentral</th>
                    <th <?php echo $header_style; ?>>Mesin</th>
                    <th <?php echo $header_style; ?>>Kode Mesin</th>
                    <th <?php echo $header_style; ?>>Sistem</th>
                    <th <?php echo $header_style; ?>>Provinsi</th>
                    <th <?php echo $header_style; ?>>Merek</th>
                    <th <?php echo $header_style; ?>>Tipe</th>
                    <th <?php echo $header_style; ?>>Seri</th>
                    <th <?php echo $header_style; ?>>Merek Generator</th>
                    <th <?php echo $header_style; ?>>Nama Trafo</th>
                    <th <?php echo $header_style; ?>>Tegangan</th>
                    <th <?php echo $header_style; ?>>Kapasitas</th>
                    <th <?php echo $header_style; ?>>Tahun</th>
                    <th <?php echo $header_style; ?>>Kode Bahan Bakar</th>
                    <th <?php echo $header_style; ?>>Kode Pembangkit</th>
                    <th <?php echo $header_style; ?>>Status</th>
                    <th <?php echo $header_style; ?>>Kode Status</th>
                    <th <?php echo $header_style; ?>>Kode Jenis Bahan Bakar</th>
                    <th <?php echo $header_style; ?>>Jenis Tegangan</th>
                    <th <?php echo $header_style; ?>>Daya Terpasang</th>
                    <th <?php echo $header_style; ?>>Daya Mampu</th>
                    <th <?php echo $header_style; ?>>Kondisi</th>
                    <th <?php echo $header_style; ?>>Kode Kondisi</th>
                    <th <?php echo $header_style; ?>>Mutasi</th>
                    <th <?php echo $header_style; ?>>Kode Mutasi</th>
                    <th <?php echo $header_style; ?>>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                while ($row = mysqli_fetch_array($resultAfter)):
                ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $row['kode_ranting'] ?></td>
                        <td><?= $row['ranting'] ?></td>
                        <td><?= $row['kode_sentral'] ?></td>
                        <td><?= $row['sentral'] ?></td>
                        <td><?= $row['mesin'] ?></td>
                        <td><?= $row['kode_mesin'] ?></td>
                        <td><?= $row['sistem'] ?></td>
                        <td><?= $row['provinsi'] ?></td>
                        <td><?= $row['merek'] ?></td>
                        <td><?= $row['tipe'] ?></td>
                        <td><?= $row['seri'] ?></td>
                        <td><?= $row['merek_generator'] ?></td>
                        <td><?= $row['nama_trafo'] ?></td>
                        <td><?= $row['tegangan'] ?></td>
                        <td><?= $row['kapasitas'] ?></td>
                        <td><?= $row['tahun'] ?></td>
                        <td><?= $row['kode_bhnbakar'] ?></td>
                        <td><?= $row['kode_pembangkit'] ?></td>
                        <td><?= $row['status'] ?></td>
                        <td><?= $row['kode_status'] ?></td>
                        <td><?= $row['kode_jenis_bhnbakar'] ?></td>
                        <td><?= $row['jenis_teg'] ?></td>
                        <td><?= $row['daya_terpasang'] ?></td>
                        <td><?= $row['daya_mampu'] ?></td>
                        <td><?= $row['kondisi'] ?></td>
                        <td><?= $row['kode_kondisi'] ?></td>
                        <td><?= $row['mutasi'] ?></td>
                        <td><?= $row['kode_mutasi'] ?></td>
                        <td><?= $row['keterangan'] ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <div style="text-align: right; margin-top: 20px;">
        <p>Banjarmasin, <?= date('d F Y') ?></p>
        <br><br><br>
        <p>(_________________________)</p>
        <p>NIP.</p>
    </div>
</body>

</html>