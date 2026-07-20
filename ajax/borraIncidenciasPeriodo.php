<?php
        $respuesta=array();
        // include Database connection file 
        $fechaDiasActualiza = $_POST["fechaDiasActualiza"];
    
        include("db_connection.php");
        $queryVacacionesActualiza = "DELETE FROM tr_incidencias WHERE fechaPase = '$fechaDiasActualiza'";
        if (!$queryVacacionesActualiza = mysqli_query($con, $queryVacacionesActualiza)) {
                exit(mysqli_error($con));
        }
        $respuesta=array();
        
    print json_encode($respuesta);
?>