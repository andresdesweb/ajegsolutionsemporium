<?php
        // include Database connection file 
        include("db_connection.php");
        $respuesta=array();
        $departamento = $_POST["iddepartamento"];
        $nombreDepartamento = $_POST["nombreDepartamento"];
 
        $query = "UPDATE tc_departamento SET nombreDepartamento = '$nombreDepartamento'  WHERE idDepartamento = '$departamento'";
        if (!$result = mysqli_query($con, $query)) {
            exit(mysqli_error($con));
        }

?>