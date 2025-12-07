<?php
require_once '/home/reparare/clientes.repararelpc.es/dompdf/autoload.inc.php';
use Dompdf\Dompdf;
use Dompdf\Options;
$row = json_decode($_GET["row"], true);

function accesorios($row) {
    $acc = '';
					if(   $row["bateria"]=="1"   ) { $acc .= "Bateria"; }
					if(   $row["funda"]=="1"   ) { if(   $acc!=''   ) { $acc .= ", "; } $acc .= "Funda"; }
					if(   $row["cargador"]=="1"   ) { if(   $acc!=''   ) { $acc .= ", "; } $acc .= "Cargador"; }
					if(   $acc!=''   ) { $acc .= ", "; } 
					$acc .= $row["otro"];
					
					return $acc;
}

function fecha($row){
    $f = explode(" ",$row["fecha_entrada"]);
				$f = explode("-",$f[0]);
				
				if(   ($f[0]+0)>0   ) {
						$f =  $f[2]."-".$f[1]."-".$f[0];
				} else {
						$f =  "N/A";
				}
				return $f;
}

function orden($row){
    $orden = "";
    foreach($row as $key => $value) {
        $orden.= $key. ": " . $value . "\n"; 
    }
    return $orden;
}

$options = new Options();
$options->set('isRemoteEnabled', true);
$dompdf = new Dompdf($options);
$dompdf->loadHtml("
<!DOCTYPE HTML> <html>
<head>
<style>
* {
    margin-top: 0px;
    margin-bottom: 0px;
}
p {
    font-family: 'arial';
    font-size:24px;
    text-align:center;
    margin-top: 4px;
    margin-bottom: 4px;
}
.margin {
    margin-left: 90px;
    margin-right: 90px;
}
.margin-img {
    margin-top:40px;
    margin-left:10px;
}
img {
    text-align:center;
    margin-top:8px;
    margin-bottom:8px;
}
.img {
    width: 200px;
    heigth: auto;
    margin: 0px;
    padding: 0px;
}
hr {
    margin-top: 4px;
    margin-bottom: 4px;
}
.contenedor {
    display: flex;
    justify-content: center;
    align-items:center;
    text-align: center;
}
</style>
</head>
<body>
<div class='contenedor'>
<img src='https://clientes.repararelpc.es/img/logo.jpg' alt='Logo'>
<hr>
<p><b>Cliente:</b> ". $row["name"] ."</p>
<p><b>Dirección:</b> ". $row["address"] ."</p>
<p><b>Fecha:</b> ". fecha($row) ."</p>
<p><b>Accesorios:</b> ". accesorios($row) ."</p>
<p><b>Número de orden:</b> ". $row["AID"] ."</p>
<p><b>Teléfono:</b> ". $row["phone"] ."</p>
<hr>
<img src='https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=Repararelpc.es\n". orden($row) ." title='Link to Google.com' />
</div>
</body>
</html>");
$dompdf->set_paper(array(0,0,400,600));
$dompdf->render();
$dompdf->stream();

/**
 * <hr>
<div class='margin-img'>
<img class='img' src='https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=Repararelpc.es\n". orden($row) ." title='Link to Google.com' />
<img class='img' src='https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=Repararelpc.es\n". orden($row) ." title='Link to Google.com' />
</div>
*/