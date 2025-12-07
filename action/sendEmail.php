<?php
header('Content-Type: application/json; charset=utf-8');
require '../PHPMailer/PHPMailerAutoload.php';

$cid = $_POST['cid'];
$aid = $_POST['aid'];

$mail = new PHPMailer;
$mail->setFrom('ivan@repararelpc.es', 'RepararelPC.es'); /* De */
$mail->addAddress( 'ivan@repararelpc.es' ); /* Para */
$mail->Subject = iconv('UTF-8', 'windows-1252', "Solicitud de factura" );
//$mail->IsHTML(true);
$mail->msgHTML( iconv('UTF-8', 'windows-1252', 'El cliente con ID: '.$cid.' ha solicitado una factura para la reparación con número de orden: '.$aid) );

if ($mail->send()) {
    echo json_encode(["status" => 1]);
}
else {
    echo json_encode(["status" => 0]);
}