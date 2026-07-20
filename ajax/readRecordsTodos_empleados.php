<?php
        $respuesta=array();
        // include Database connection file 
        include("db_connection.php");
        $respuesta=array();
 
        $query = "SELECT e.*, d.nombreDepartamento, di.nombreDireccion FROM tc_empleados e INNER JOIN tc_departamento d ON d.idDepartamento = e.departamento INNER JOIN tc_direccion di ON di.idDireccion = e.direccion";
        if (!$result = mysqli_query($con, $query)) {
            exit(mysqli_error($con));
        }
        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_array($result)){
                $respuesta[] = array(
                    "idChecador" => $row["idChecador"],
                    "idEmpleado" => $row["idEmpleado"],
                    "Nombre" => $row["nombre"],
                    "SegundoNombre" => $row["segundoNombre"],
                    "apellido_p" => $row["apellido_p"],
                    "apellido_m" => $row["apellido_m"],
                    "departamento" => $row["departamento"],
                    "direccion" => $row["direccion"],
                    "Puesto" => $row["puesto"],
                    "nombreDepartamento" => $row["nombreDepartamento"],
                    "nombreDireccion" => $row["nombreDireccion"],
                    "Ingreso" => $row["ingreso"],
                    "activo" => $row["isActive"],
                    "acumula" => $row["acumulaVacs"]
                );
            }
            
        }else{
            $respuesta[] = array(
                "status" => "error",
            );
        }
    print json_encode($respuesta);
?>