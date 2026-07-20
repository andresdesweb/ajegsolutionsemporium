<?php
        $respuesta=array();
        // include Database connection file 
        include("db_connection.php");
        $respuesta=array();
 
        $query = "SELECT * FROM tc_departamento";
        if (!$result = mysqli_query($con, $query)) {
            exit(mysqli_error($con));
        }
        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_array($result)){
                $respuesta[] = array(
                    "nombreDepartamento" => $row["nombreDepartamento"],
                    "idDepartamento" => $row["idDepartamento"],
                );
            }
            
        }else{
            $respuesta[] = array(
                "status" => "error",
            );
        }
    print json_encode($respuesta);
?>