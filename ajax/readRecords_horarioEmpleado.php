<?php
        $respuesta=array();
        // include Database connection file 
        include("db_connection.php");
        $respuesta=array();
        $idChecador = $_POST["idChecador"];
 
        $query = "SELECT entrada, salida, entradaDos, salidaDos FROM tc_empleados WHERE idChecador = '$idChecador'";
        if (!$result = mysqli_query($con, $query)) {
            exit(mysqli_error($con));
        }
        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_array($result)){
                $respuesta[] = array(
                    "entrada" => $row["entrada"],
                    "salida" => $row["salida"],
                    "entradaDos" => $row["entradaDos"],
                    "salidaDos" => $row["salidaDos"],
                );
            }
            
        }else{
            $respuesta[] = array(
                "status" => "error",
            );
        }
    print json_encode($respuesta);
?>