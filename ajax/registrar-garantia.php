<?php
header('Content-Type: application/json; charset=utf-8');
session_start();
require( '../config.php' );

$orden = $_POST['orden'];
$problema = $_POST['problema'];
$date = date('Y-m-d H:i:s');

if (isset($_SESSION['ID']) && isset($problema) && isset($orden)) {
    $nuevaGarantia = "INSERT INTO garantias VALUES (NULL,'".$orden."','".$problema."',0,'".$date."');";
    $resultado = mysqli_query($db, $nuevaGarantia);
    if ($resultado) {
        if (mysqli_affected_rows($db) > 0) {
            echo json_encode(["message" => "La inserción de datos fue exitosa.", "orden" => mysqli_insert_id($db) ]);
        } else {
            echo json_encode(["message" => "La consulta se ejecutó correctamente, pero no se insertaron filas."]);
        }
    } else {
        echo json_encode(["message" => "Error en la consulta: " . mysqli_error($db)]);
    }
}
