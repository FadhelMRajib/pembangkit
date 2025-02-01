<?php
// Direktori file
$fileDir = '../../assets/file_relokasimesin/';
$fileName = $_GET['file'];

// Validasi nama file dan pastikan file ada
$filePath = realpath($fileDir . $fileName);
if (strpos($filePath, realpath($fileDir)) !== 0 || !file_exists($filePath)) {
    die("File tidak valid atau tidak ditemukan.");
}

// Kirim file ke browser untuk diunduh
header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="' . basename($filePath) . '"');
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');
header('Content-Length: ' . filesize($filePath));
readfile($filePath);
exit;
