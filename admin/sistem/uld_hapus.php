<?php 

session_start();
require_once('../../config.php');

$id = $_GET['id'];

$result = mysqli_query($connection, "DELETE FROM uld WHERE id_uld = $id");

$_SESSION['berhasil'] = "Data Berhasil diHapus";
header("Location: up3.php");
exit;   

 include('../layout/footer.php');