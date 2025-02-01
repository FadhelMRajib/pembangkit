<?php
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
$pdf->Cell(190, 10, 'Data User', 0, 1, 'C');
$pdf->Ln(10); // Baris kosong

// Header tabel
$pdf->SetFont('Arial', 'B', 12);

// Mengatur lebar kolom
$col1Width = 10;   // Lebar kolom No.
$col2Width = 40;   // Lebar kolom NIP
$col3Width = 50;   // Lebar kolom Nama
$col4Width = 30;   // Lebar kolom Username
$col5Width = 30;   // Lebar kolom Jabatan
$col6Width = 30;   // Lebar kolom Role

// Total lebar tabel
$totalWidth = $col1Width + $col2Width + $col3Width + $col4Width + $col5Width + $col6Width;

// Mengatur posisi untuk header agar berada di tengah
$pdf->SetX((210 - $totalWidth) / 2); // 210 mm lebar A4
$pdf->Cell($col1Width, 10, 'No.', 1, 0, 'C');
$pdf->Cell($col2Width, 10, 'NIP', 1, 0, 'C');
$pdf->Cell($col3Width, 10, 'Nama', 1, 0, 'C');
$pdf->Cell($col4Width, 10, 'Username', 1, 0, 'C');
$pdf->Cell($col5Width, 10, 'Jabatan', 1, 0, 'C');
$pdf->Cell($col6Width, 10, 'Role', 1, 0, 'C');
$pdf->Ln();

// Query untuk mengambil data pengguna
$query = "
    SELECT users.id_pegawai, users.username, users.role, pegawai.nip, pegawai.nama, pegawai.jabatan 
    FROM users 
    JOIN pegawai ON users.id_pegawai = pegawai.id
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
        $pdf->Cell($col1Width, 10, $no++, 1, 0, 'C');           // Nomor urut, di tengah
        $pdf->Cell($col2Width, 10, $row['nip'], 1, 0, 'L');     // NIP, rata kiri
        $pdf->Cell($col3Width, 10, $row['nama'], 1, 0, 'L');    // Nama, rata kiri
        $pdf->Cell($col4Width, 10, $row['username'], 1, 0, 'L'); // Username, rata kiri
        $pdf->Cell($col5Width, 10, $row['jabatan'], 1, 0, 'L'); // Jabatan, rata kiri
        $pdf->Cell($col6Width, 10, $row['role'], 1, 0, 'C');    // Role, di tengah
        $pdf->Ln();
    }
} else {
    // Jika tidak ada data, tampilkan pesan
    $pdf->SetFont('Arial', '', 12);
    $pdf->SetX((210 - $totalWidth) / 2); // Mengatur posisi ke tengah kertas
    $pdf->Cell($totalWidth, 10, 'Tidak ada data.', 1, 0, 'C');
    $pdf->Ln();
}

// Output file PDF inline untuk preview
$pdf->Output('I', 'Laporan_User.pdf'); // 'I' untuk tampilan inline
