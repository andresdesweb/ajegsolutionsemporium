<?php
        $respuesta=array();
        // include Database connection file 
        $idEmpleado = $_POST["idEmpleado"];
        include("db_connection.php");
        $respuesta=array();
 
        //$query = "DELETE FROM tc_empleados WHERE idEmpleado = '$idEmpleado'";
        $query = "UPDATE tc_empleados SET isActive = 0 WHERE idEmpleado = '$idEmpleado'";
        if (!$result = mysqli_query($con, $query)) {
            exit(mysqli_error($con));
        }

        $queryAccesos = "DELETE from tr_accesoapps WHERE idEmpleado = '$idEmpleado'";
        if (!$resultAccesos = mysqli_query($con, $queryAccesos)) {
            exit(mysqli_error($con));
        }

        $queryPermisos = "DELETE from tc_usuarios WHERE idEmp = '$idEmpleado'";
        if (!$resultPermisos = mysqli_query($con, $queryPermisos)) {
            exit(mysqli_error($con));
        }
    
    //print json_encode($respuesta);
?>