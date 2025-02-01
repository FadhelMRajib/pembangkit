<?php

session_start();
require_once('../../config.php');

$id = $_GET['id'];

$result = mysqli_query($connection, "DELETE FROM mesin WHERE id_mesin = $id");

$_SESSION['berhasil'] = "Data Berhasil diHapus";
header("Location: mesin.php");
exit;

include('../layout/footer.php');
