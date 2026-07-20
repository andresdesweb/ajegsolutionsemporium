<?php
        $respuesta=array();
        // include Database connection file 
        $idEmpleado = $_POST["idEmpleado"];
        include("db_connection.php");
        $respuesta=array();
 
        //$query = "DELETE FROM tc_empleados WHERE idEmpleado = '$idEmpleado'";
        $query = "UPDATE tc_empleados SET isActive = 1 WHERE idEmpleado = '$idEmpleado'";
        if (!$result = mysqli_query($con, $query)) {
            exit(mysqli_error($con));
        }
    
    //print json_encode($respuesta);
?>