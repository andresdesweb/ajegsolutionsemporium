<?php

        $respuesta=array();
        // include Database connection file 
        include("db_connection.php");
 
        // get values 
        $token = $_POST["token"];
  
 
        $query = "UPDATE tc_usuarios SET tokenSession = '' WHERE tokenSession = '$token'";
        if (!$result = mysqli_query($con, $query)) {
            exit(mysqli_error($con));
        }
        $respuesta[] = array(
            "status" => "success",
        );
    print json_encode($respuesta);
?>