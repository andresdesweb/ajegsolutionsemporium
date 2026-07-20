<?php
        $respuesta=array();
        // include Database connection file 
        $idDireccion = $_POST["idDireccion"];
        include("db_connection.php");
        $respuesta=array();
 
        $query = "DELETE FROM tc_direccion WHERE idDireccion = '$idDireccion'";
        if (!$result = mysqli_query($con, $query)) {
            exit(mysqli_error($con));
        }
    
    //print json_encode($respuesta);
?>