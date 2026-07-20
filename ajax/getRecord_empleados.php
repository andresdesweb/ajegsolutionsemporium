<?php
        $respuesta=array();
        // include Database connection file 
        include("db_connection.php");
        $idEmpleado = $_POST["idEmpleado"];
 
        $query = "SELECT * FROM tc_empleados WHERE idEmpleado = '$idEmpleado'";
        if (!$result = mysqli_query($con, $query)) {
            exit(mysqli_error($con));
        }
        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_array($result)){
                $respuesta[] = array(
                    "idEmpleado" => $row["idEmpleado"],
                    "Nombre" => $row["nombre"],
                    "Ingreso" => $row["ingreso"],
                    "idChecador" => $row["idChecador"],
                    "segundoNombre" => $row["segundoNombre"],
                    "apellido_p" => $row["apellido_p"],
                    "apellido_m" => $row["apellido_m"],
                    "departamento" => $row["departamento"],
                    "direccion" => $row["direccion"],
                    "mail" => $row["mail"],
                    "entrada" => $row["entrada"],
                    "salida" => $row["salida"],
                    "entradaDos" => $row["entradaDos"],
                    "salidaDos" => $row["salidaDos"],
                    "puesto" => $row["puesto"],
                    "Encargado" => $row["idEncargado"],
                    "entradaViernes" => $row["entradaViernes"],
                    "salidaViernes" => $row["salidaViernes"],
                );
            }
            
        }else{
            $respuesta[] = array(
                "status" => "error",
            );
        }
    print json_encode($respuesta);
?>