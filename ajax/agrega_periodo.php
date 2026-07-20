<?php
        $respuesta=array();

        $fechas = $_POST["fechas"];
        $fechaInicio = $_POST["fechaInicio"];
        $fechaFin = $_POST["fechaFin"];
        include("db_connection.php");
        $queryNuevo = "INSERT INTO tc_periodosnomina VALUES(NULL,'$fechaInicio', '$fechaFin')";
            if (!$resultNuevo = mysqli_query($con, $queryNuevo)) {
                exit(mysqli_error($con));
            }

        $queryPeriodoMayor = "SELECT MAX(idPeriodo) AS periodo FROM  tc_periodosnomina";
            if (!$resultPeriodoMayor = mysqli_query($con, $queryPeriodoMayor)) {
                exit(mysqli_error($con));
            }
            while($rowPeriodoMayor = mysqli_fetch_array($resultPeriodoMayor)){
                $idPeriodo = $rowPeriodoMayor["periodo"];
            }

        foreach ($fechas as $valor) {
            $queryPre = "INSERT INTO tc_diasperiodonomina VALUES (DEFAULT, '$valor', '$idPeriodo')";
            if (!$resultPre = mysqli_query($con, $queryPre)) {
                exit(mysqli_error($con));
            }
        }
        
        
        
 
        
    print json_encode($idPeriodo);
?>