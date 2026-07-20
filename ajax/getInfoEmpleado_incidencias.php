<?php
        $respuesta=array();
        // include Database connection file 
        include("db_connection.php");
        $txtEmpleadoNombre = $_POST["txtEmpleadoNombre"];
 
        $query = "SELECT CONCAT(apellido_p, ' ', apellido_m, ' ', nombre, ' ', segundoNombre) as Nombre FROM tc_empleados WHERE idEmpleado = '$txtEmpleadoNombre'";
        if (!$result = mysqli_query($con, $query)) {
            exit(mysqli_error($con));
        }
        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_array($result)){
                $respuesta[] = array(
                    "Nombre" => $row["Nombre"],
                );
            }
            
        }else{
            $respuesta[] = array(
                "status" => "error",
            );
        }
    print json_encode($respuesta);
?>