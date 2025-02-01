<?php
require('../../fpdf/fpdf.php');
require_once('../../config.php');

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Cek apakah parameter id_up3 ada dan tidak kosong
if (isset($_GET['id_up3']) && !empty($_GET['id_up3'])) {
    $id_up3 = $_GET['id_up3'];

    // Buat instance FPDF
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 16);

    // Tambahkan logo di kanan atas (lebar 20 mm, tinggi otomatis sesuai proporsi)
    $pdf->Image('../../assets/img/Logo_PLN.png', 10, 10, 30); // Ganti dengan path logo Anda

    // Judul halaman
    $pdf->Cell(190, 10, 'Data ULD', 0, 1, 'C');
    $pdf->Ln(10); // Baris kosong

    // Header tabel
    $pdf->SetFont('Arial', 'B', 12);

    // Mengatur lebar kolom
    $col1Width = 10;   // Lebar kolom No.
    $col2Width = 120;  // Lebar kolom Nama ULD

    // Total lebar tabel
    $totalWidth = $col1Width + $col2Width;

    // Mengatur posisi untuk header agar berada di tengah
    $pdf->SetX((210 - $totalWidth) / 2); // 210 mm lebar A4
    $pdf->Cell($col1Width, 10, 'No.', 1, 0, 'C');
    $pdf->Cell($col2Width, 10, 'Nama ULD', 1, 0, 'C');
    $pdf->Ln();

    // Query untuk mengambil data ULD berdasarkan id_up3
    $query = "
        SELECT * FROM uld 
        WHERE id_up3 = '$id_up3' 
        ORDER BY nama_uld ASC
    ";
    $result = mysqli_query($connection, $query);

    // Cek jika data tersedia
    if (mysqli_num_rows($result) > 0) {
        $no = 1;
        while ($row = mysqli_fetch_assoc($result)) {
            // Tampilkan data di tabel
            $pdf->SetFont('Arial', '', 12);

            // Mengatur posisi untuk setiap baris agar berada di tengah
            $pdf->SetX((210 - $totalWidth) / 2); // Mengatur posisi ke tengah kertas
            $pdf->Cell($col1Width, 10, $no++, 1, 0, 'C'); // Nomor urut
            $pdf->Cell($col2Width, 10, htmlspecialchars($row['nama_uld']), 1, 0, 'L'); // Nama ULD
            $pdf->Ln();
        }
    } else {
        // Jika tidak ada data, tampilkan pesan
        $pdf->SetFont('Arial', '', 12);
        $pdf->SetX((210 - $totalWidth) / 2); // Mengatur posisi ke tengah kertas
        $pdf->Cell($col1Width + $col2Width, 10, 'Tidak ada data.', 1, 0, 'C');
        $pdf->Ln();
    }

    // Output file PDF inline untuk preview
    $pdf->Output('I', 'Laporan_ULD.pdf'); // 'I' untuk tampilan inline

} else {
    // Jika id_up3 tidak ada, tampilkan pesan error
    echo "<p>Error: ID UP3 tidak ditemukan atau tidak valid.</p>";
    exit;
}
