<?php
include("db_connection.php");
    $tokenSession = $_POST["token"];
    $respuesta[] = array(
        "status" => "error",
    );
    $query = "SELECT * FROM tc_usuarios WHERE tokenSession = '$tokenSession'";
        if (!$result = mysqli_query($con, $query)) {
            exit(mysqli_error($con));
        }
        if(mysqli_num_rows($result) > 0){
            $respuesta[] = array(
                "status" => "success",
            );
            print json_encode($respuesta);
        }else{
            header("Location: index.html");
            die();
            header('HTTP/1.1 500 sessión no iniciada');
            header('Content-Type: application/json; charset=UTF-8');
            die(json_encode(array('message' => 'ERROR', 'code' => 1337)));
        }
?>