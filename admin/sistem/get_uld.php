<?php
require_once('../../config.php');

$id_up3 = isset($_GET['id_up3']) ? $_GET['id_up3'] : '';

$query = "SELECT id_uld, nama_uld FROM uld WHERE id_up3 = '$id_up3' ORDER BY nama_uld";
$result = mysqli_query($connection, $query);

$uld_list = [];
while($row = mysqli_fetch_assoc($result)) {
    $uld_list[] = $row;
}

header('Content-Type: application/json');
echo json_encode($uld_list);