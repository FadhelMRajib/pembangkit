<?php
require('../../fpdf/fpdf.php');
require_once('../../config.php');

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Buat instance FPDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);

// Tambahkan logo di kanan atas (lebar 20 mm, tinggi otomatis sesuai proporsi)
$pdf->Image('../../assets/img/Logo_PLN.png', 10, 10, 30); // Ganti dengan path logo kanan Anda, dengan lebar 20mm

// Judul halaman
$pdf->Cell(190, 10, 'Data UP3', 0, 1, 'C');
$pdf->Ln(10); // Baris kosong

// Header tabel
$pdf->SetFont('Arial', 'B', 12);

// Mengatur lebar kolom
$col1Width = 10;   // Lebar kolom No.
$col2Width = 120;  // Lebar kolom Nama UP3
$col3Width = 30;   // Lebar kolom Jumlah ULD

// Total lebar tabel
$totalWidth = $col1Width + $col2Width + $col3Width;

// Mengatur posisi untuk header agar berada di tengah
$pdf->SetX((210 - $totalWidth) / 2); // 210 mm lebar A4
$pdf->Cell($col1Width, 10, 'No.', 1, 0, 'C');
$pdf->Cell($col2Width, 10, 'Nama UP3', 1, 0, 'C');
$pdf->Cell($col3Width, 10, 'Jumlah ULD', 1, 0, 'C');
$pdf->Ln();

// Query untuk mengambil data UP3 dan menghitung jumlah ULD per UP3
$query = "
    SELECT up3.nama_up3, COUNT(uld.id_uld) AS jumlah_uld
    FROM up3
    LEFT JOIN uld ON up3.id_up3 = uld.id_up3
    GROUP BY up3.id_up3
    ORDER BY up3.nama_up3 ASC
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
        $pdf->Cell($col1Width, 10, $no++, 1, 0, 'C'); // Nomor urut, di tengah
        $pdf->Cell($col2Width, 10, $row['nama_up3'], 1, 0, 'L'); // Nama UP3, rata kiri
        $pdf->Cell($col3Width, 10, $row['jumlah_uld'], 1, 0, 'C'); // Jumlah ULD, di tengah
        $pdf->Ln();
    }
} else {
    // Jika tidak ada data, tampilkan pesan
    $pdf->SetFont('Arial', '', 12);
    $pdf->SetX((210 - $totalWidth) / 2); // Mengatur posisi ke tengah kertas
    $pdf->Cell($col1Width + $col2Width + $col3Width, 10, 'Tidak ada data.', 1, 0, 'C');
    $pdf->Ln();
}

// Output file PDF inline untuk preview
$pdf->Output('I', 'Laporan_UP3.pdf'); // 'I' untuk tampilan inline
