<?php
        // include Database connection file 
        include("db_connection.php");
        $respuesta=array();

        $nombreDireccion = $_POST["nombreDireccion"];
        $direccion = $_POST["idDireccion"];

 
        $query = "UPDATE tc_direccion SET nombreDireccion = '$nombreDireccion' WHERE idDireccion = '$direccion'";
        if (!$result = mysqli_query($con, $query)) {
            exit(mysqli_error($con));
        }

?>