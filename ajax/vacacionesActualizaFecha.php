<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
        $respuesta=array();
        // include Database connection file 
        $fechaDiasActualiza = $_POST["fechaDiasActualiza"];
    
        include("db_connection.php");
        $queryVacacionesActualiza = "CALL cursor_vacaciones_fecha_especifica('$fechaDiasActualiza')";
        if (!$queryVacacionesActualiza = mysqli_query($con, $queryVacacionesActualiza)) {
                exit(mysqli_error($con));
        }
        $respuesta=array();
        
    print json_encode($respuesta);
?>