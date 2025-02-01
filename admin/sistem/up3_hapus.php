<?php 

session_start();
require_once('../../config.php');

$id = $_GET['id'];

$result = mysqli_query($connection, "DELETE FROM up3 WHERE id_up3 = $id");

$_SESSION['berhasil'] = "Data Berhasil diHapus";
header("Location: up3.php");
exit;   

 include('../layout/footer.php');