<?php
$servidor = 'localhost';
$usuario = 'reparare_dbfactu';
$contrasena = 'Forex123!!';
$database = 'reparare_dbfact';

$web = 'http://clientes.repararelpc.es/'; /*   URL de tu sitio web con barra / al final   */

$db = mysqli_connect($servidor,$usuario,$contrasena,$database);
//mysqli_query($db, "SET character_set_results = 'utf8'");
mysqli_query($db, "SET NAMES 'utf8'"); //Codificacion, Importante
?>