<?php

        $hola = json_decode($_POST["aEnviar"]);
        $respuesta;
        include("db_connection.php");
        foreach($hola as $valor) {
                $respuesta = $valor[0];
                $checador = $valor[0];
                $tipo = $valor[1];
                $fechaHora = $valor[2];
                $checadorCheca = $valor[4];
                $periodo = $valor[5];
$query = "INSERT INTO tr_reportenomina VALUES('', '$checador', '$tipo', '$fechaHora', '','$checadorCheca', '$periodo')";
                if (!$result = mysqli_query($con, $query)) {
                        exit(mysqli_error($con));
                }
        }
        print json_encode($respuesta);
?>