<?php
        $respuesta=array();
        // include Database connection file 
        $idPase = $_POST["idPase"];
        include("db_connection.php");
        $respuesta=array();
 
        $query = "DELETE FROM tr_incidencias WHERE idPase = '$idPase'";
        if (!$result = mysqli_query($con, $query)) {
            exit(mysqli_error($con));
        }
    
    //print json_encode($respuesta);
?>