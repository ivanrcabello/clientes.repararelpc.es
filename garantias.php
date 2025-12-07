<?php
session_start();
header('Content-Type: application/json; charset=utf-8');
require("config.php");
$status = $_GET['status'];
$norden = $_GET['ngarantia'];

if (isset($_SESSION['user'])) {
    if (isset($norden)) {
    	$consulta = "SELECT garantias.*, articulos.CID FROM garantias LEFT JOIN articulos ON garantias.AID = articulos.AID WHERE articulos.CID = ".$_SESSION['ID']." AND id=".$norden;
    }
    else if (isset($status)) {
    	$consulta = "SELECT garantias.*, articulos.CID FROM garantias LEFT JOIN articulos ON garantias.AID = articulos.AID WHERE articulos.CID = ".$_SESSION['ID']." AND status=".$status;
    }
    else {
        $consulta = "SELECT garantias.*, articulos.CID FROM garantias LEFT JOIN articulos ON garantias.AID = articulos.AID WHERE articulos.CID = ".$_SESSION['ID'];
    }
    $result = mysqli_query($db, $consulta);
    $rows = array();
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }
    }
    echo json_encode(["data" => $rows]);
}
