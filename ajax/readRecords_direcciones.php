<?php
        $respuesta=array();
        // include Database connection file 
        include("db_connection.php");
        $respuesta=array();
 
        $query = "SELECT * FROM tc_direccion";
        if (!$result = mysqli_query($con, $query)) {
            exit(mysqli_error($con));
        }
        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_array($result)){
                $respuesta[] = array(
                    "nombreDireccion" => $row["nombreDireccion"],
                    "idDireccion" => $row["idDireccion"],
                );
            }
            
        }else{
            $respuesta[] = array(
                "status" => "error",
            );
        }
    print json_encode($respuesta);
?>