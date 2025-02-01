<?php
require('../../fpdf/fpdf.php');
require_once('../../config.php');

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Buat instance FPDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);

// Tambahkan logo di kiri atas (lebar 30 mm)
$pdf->Image('../../assets/img/Logo_PLN.png', 10, 10, 30);

// Judul laporan
$pdf->Cell(190, 10, 'Laporan Data Relokasi Mesin', 0, 1, 'C');
$pdf->Ln(10); // Baris kosong

// Header tabel
$pdf->SetFont('Arial', 'B', 12);

// Mengatur lebar kolom
$col1Width = 10;  // No
$col2Width = 40;  // Tanggal (Diperlebar)
$col3Width = 50;  // Kota
$col4Width = 90;  // Keterangan (Sedikit dipersempit)

$totalWidth = $col1Width + $col2Width + $col3Width + $col4Width;

// Mengatur posisi untuk header agar berada di tengah
$pdf->SetX((210 - $totalWidth) / 2);
$pdf->Cell($col1Width, 10, 'No.', 1, 0, 'C');
$pdf->Cell($col2Width, 10, 'Tanggal', 1, 0, 'C');
$pdf->Cell($col3Width, 10, 'Kota', 1, 0, 'C');
$pdf->Cell($col4Width, 10, 'Keterangan', 1, 0, 'C');
$pdf->Ln();

// Query untuk mengambil data relokasi mesin
$query = "SELECT * FROM relokasi_mesin ORDER BY id DESC";
$result = mysqli_query($connection, $query);

// Cek jika ada data
if (mysqli_num_rows($result) > 0) {
    $no = 1;
    while ($row = mysqli_fetch_assoc($result)) {
        $pdf->SetFont('Arial', '', 12);

        // Menghitung tinggi baris berdasarkan konten
        $keteranganHeight = $pdf->GetStringWidth($row['keterangan']) / $col4Width * 10;

        // Gunakan nilai tinggi maksimum (minimal 10)
        $rowHeight = max(10, $keteranganHeight);

        // Baris untuk No, Tanggal, dan Kota
        $pdf->SetX((210 - $totalWidth) / 2);
        $pdf->Cell($col1Width, $rowHeight, $no++, 1, 0, 'C');                         // No
        $pdf->Cell($col2Width, $rowHeight, date('d F Y', strtotime($row['tanggal'])), 1, 0, 'C'); // Tanggal
        $pdf->Cell($col3Width, $rowHeight, $row['kota'], 1, 0, 'L');                 // Kota

        // Keterangan menggunakan MultiCell
        $xPos = $pdf->GetX();
        $yPos = $pdf->GetY();
        $pdf->MultiCell($col4Width, 10, $row['keterangan'], 1, 'L');
        $pdf->SetXY($xPos + $col4Width, $yPos); // Kembali ke posisi awal

        $pdf->Ln();
    }
} else {
    // Jika tidak ada data
    $pdf->SetFont('Arial', '', 12);
    $pdf->SetX((210 - $totalWidth) / 2);
    $pdf->Cell($totalWidth, 10, 'Data Relokasi Mesin Masih Kosong.', 1, 0, 'C');
    $pdf->Ln();
}

// Output file PDF inline
$pdf->Output('I', 'Laporan_Relokasi_Mesin.pdf');
