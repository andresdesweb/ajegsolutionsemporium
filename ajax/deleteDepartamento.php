<?php
        $respuesta=array();
        // include Database connection file 
        $idDepartamento = $_POST["idDepartamento"];
        include("db_connection.php");
        $respuesta=array();
 
        $query = "DELETE FROM tc_departamento WHERE idDepartamento = '$idDepartamento'";
        if (!$result = mysqli_query($con, $query)) {
            exit(mysqli_error($con));
        }
    
    //print json_encode($respuesta);
?>