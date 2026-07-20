<?php
include("db_connection.php");
$tacos = $_GET["tacos"];
$tacosdorados = $_GET["tacosdorados"];
$tacoqueso = $_GET["tacoqueso"];
$tacodoradoqueso = $_GET["tacodoradoqueso"];
$torta = $_GET["torta"];
$tortilechera = $_GET["tortilechera"];
$lecheraharina = $_GET["lecheraharina"];
$lecheramaiz = $_GET["lecheramaiz"];
$volcan = $_GET["volcan"];
$quesaharina = $_GET["quesaharina"];
$quesamaiz = $_GET["quesamaiz"];
$refresco1 = $_GET["refresco1"];
$refresco2 = $_GET["refresco2"];
$refresco3 = $_GET["refresco3"];
$horchata1 = $_GET["horchata1"];
$horchata2 = $_GET["horchata2"];
$agua1 = $_GET["agua1"];
$jugo = $_GET["jugo"];
$quesamaizdoble = $_GET["quesamaizdoble"];
$plato = $_GET["plato"];
$cafe = $_GET["cafe"];
$jugolitro = $_GET["jugolitro"];
$tacoharina = $_GET["tacoharina"];
$combodorado = $_GET["combodorado"];
$lecheraharinadoble = $_GET["lecheraharinadoble"];
$lecheraharinadobletortilla = $_GET["lecheraharinadobletortilla"];
$modalidad = $_GET["modalidad"];
if ($modalidad == 1) {
	$modalidadtexto = "Para llevar";
}
else if($modalidad == 2){
	$modalidadtexto = "Para comer aquí";
}
$lugar = $_GET["lugar"];
$boing = $_GET["boing"];
$combo = $_GET["combo"];
$totaltortilechera = $tortilechera * 49;
$totallecheraharina = $lecheraharina * 44;
$totallecheramaiz = $lecheramaiz * 44;
$totalvolcan = $volcan * 35;
$totalquesaharina = $quesaharina * 19;
$totalquesamaiz = $quesamaiz * 15;
$totalrefresco1 = $refresco1 * 19;
$totalrefresco2 = $refresco2 * 16;
$totalrefresco3 = $refresco3 * 11;
$totalhorchata1 = $horchata1 * 21;
$totalhorchata2 = $horchata2 * 35;
$totalagua1 = $agua1 * 12;
$totaltacoqueso = $tacoqueso * 27;
$totaltacos = $tacos * 21;
$totaltacodorado = $tacosdorados * 22;
$totaltacodoradoqueso = $tacodoradoqueso * 28;
$totaltorta = $torta * 44;
$totalboing = $boing * 19;
$totalcombo = $combo * 94;
$totaljugo = $jugo * 19;

$totalquesamaizdoble = $quesamaizdoble * 20;
$totalplato = $plato * 65;
$totalcafe = $cafe * 12;
$totaljugolitro = $jugolitro * 40;
$totaltacoharina = $tacoharina * 25;
$totalcombodorado = $combodorado * 98;
$totallecheraharinadoble = $lecheraharinadoble * 72;
$totallecheraharinadobletortilla = $lecheraharinadobletortilla * 47;
$totalFinal = $totaltacos + $totaltacodorado + $totaltacoqueso + $totaltacodoradoqueso + $totaltorta + $totaltortilechera + $totallecheraharina + $totallecheramaiz + $totalvolcan + $totalquesaharina + $totalquesamaiz + $totalrefresco1 + $totalrefresco2 + $totalrefresco3 + $totalhorchata1 + $totalhorchata2 + $totalagua1 +$totalboing + $totalcombo + $totaljugo + $totalquesamaizdoble + $totalplato + $totalcafe + $totaljugolitro + $totaltacoharina + $totalcombodorado + $totallecheraharinadoble + $totallecheraharinadobletortilla;
$query = "INSERT INTO tr_orden VALUES('','$tacos','$tacosdorados','$tacoqueso','$tacodoradoqueso','$torta', '$tortilechera', '$lecheraharina', '$lecheramaiz', '$volcan', '$quesaharina', '$quesamaiz', '$refresco1', '$refresco2', '$refresco3', '$horchata1', '$horchata2', '$agua1', '$boing','$combo','$jugo','$quesamaizdoble','$plato','$cafe','$jugolitro','$tacoharina','$combodorado','$lecheraharinadoble','$lecheraharinadobletortilla','$totalFinal', '$modalidadtexto', '$lugar',NOW(),1)";
if (!$result = mysqli_query($con, $query)) {
        exit(mysqli_error($con));
    }
?>