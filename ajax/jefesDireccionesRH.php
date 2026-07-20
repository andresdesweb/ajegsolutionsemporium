<?php
        $respuesta=array();
        // include Database connection file 
        include("db_connection.php");
        $preArray[] =array(
            "idEmpleado" => 0,
            "nombreEmpleado" => "SELECCIONE UNA OPCIÓN",
        );
        $respuesta=array();
 
        $query = "SELECT idEmpleado, CONCAT(apellido_p, ' ', apellido_m, ' ', nombre, ' ', segundoNombre) as nombreEmpleado FROM tc_empleados WHERE isActive = 1 ORDER BY apellido_p, apellido_m";
        if (!$result = mysqli_query($con, $query)) {
            exit(mysqli_error($con));
        }
        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_array($result)){
                $respuesta[] = array(
                    "idEmpleado" => $row["idEmpleado"],
                    "nombreEmpleado" => $row["nombreEmpleado"],
                );
            }
            
        }else{
            $respuesta[] = array(
                "status" => "error",
            );
        }
        $finalArray = array_merge($preArray, $respuesta);
    print json_encode($finalArray);
?>