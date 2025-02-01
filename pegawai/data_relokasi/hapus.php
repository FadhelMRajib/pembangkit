<?php

session_start();
require_once('../../config.php');
$id = $_GET['id'];

$result = mysqli_query($connection, "DELETE FROM relokasi_mesin WHERE id=$id");

$_SESSION['berhasil'] = 'Data Berhasil diHapus';
header("Location: relokasimesin.php");

exit;

include('../layout/footer.php');
