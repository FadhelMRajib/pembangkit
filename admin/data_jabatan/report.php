<?php
// Import library FPDF
require('../../fpdf/fpdf.php');
require_once('../../config.php');

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Buat instance FPDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);

// Tambahkan logo di kanan atas (lebar 30 mm, tinggi otomatis sesuai proporsi)
$pdf->Image('../../assets/img/Logo_PLN.png', 10, 10, 30); // Path logo PLN di kanan atas

// Judul halaman
$pdf->Cell(190, 10, 'Data Jabatan', 0, 1, 'C');
$pdf->Ln(10); // Baris kosong

// Header tabel
$pdf->SetFont('Arial', 'B', 12);

// Mengatur lebar kolom
$col1Width = 20;   // Lebar kolom No.
$col2Width = 130;  // Lebar kolom Nama Jabatan
$totalWidth = $col1Width + $col2Width;

// Mengatur posisi tabel agar berada di tengah kertas
$pdf->SetX((210 - $totalWidth) / 2);
$pdf->Cell($col1Width, 10, 'No.', 1, 0, 'C');           // Header kolom No.
$pdf->Cell($col2Width, 10, 'Nama Jabatan', 1, 0, 'C');  // Header kolom Nama Jabatan
$pdf->Ln();

// Query untuk mengambil data jabatan
$connection = mysqli_connect('localhost', 'root', '', 'db_pembangkit'); // Sesuaikan nama database Anda
if (!$connection) {
    die('Koneksi ke database gagal: ' . mysqli_connect_error());
}

$query = "SELECT * FROM jabatan ORDER BY id DESC";
$result = mysqli_query($connection, $query);

// Cek jika data tersedia
if (mysqli_num_rows($result) > 0) {
    $no = 1;
    while ($row = mysqli_fetch_assoc($result)) {
        // Tampilkan data di tabel
        $pdf->SetFont('Arial', '', 12);

        // Mengatur posisi untuk setiap baris agar berada di tengah kertas
        $pdf->SetX((210 - $totalWidth) / 2);
        $pdf->Cell($col1Width, 10, $no++, 1, 0, 'C');           // Nomor urut, di tengah
        $pdf->Cell($col2Width, 10, $row['jabatan'], 1, 0, 'L'); // Nama Jabatan, rata kiri
        $pdf->Ln();
    }
} else {
    // Jika tidak ada data, tampilkan pesan
    $pdf->SetFont('Arial', '', 12);
    $pdf->SetX((210 - $totalWidth) / 2);
    $pdf->Cell($totalWidth, 10, 'Data Masih Kosong.', 1, 0, 'C');
    $pdf->Ln();
}

// Output file PDF inline untuk preview
$pdf->Output('I', 'Laporan_Jabatan.pdf'); // 'I' untuk tampilan inline
