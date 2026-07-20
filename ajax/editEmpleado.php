<?php
        // include Database connection file 
        include("db_connection.php");
        $respuesta=array();
        $idEmpleado = $_POST["idEmpleado"];
        $nombreEmpleado = $_POST["nombreemp"];
        $checador = $_POST["checador"];
        $apellidoP = $_POST["apellidoP"];
        $apellidoM = $_POST["apellidoM"];
        $segundoNombre = $_POST["segundoNombre"];
        $departamento = $_POST["departamento"];
        $direccion = $_POST["direccion"];
        $ingreso = $_POST["ingreso"];
        $mailEmp = $_POST["mailEmp"];
        $entrada = $_POST["entrada"];
        $salida = $_POST["salida"];
        $entradaDos = $_POST["entradaDos"];
        $salidaDos = $_POST["salidaDos"];
        $puesto = $_POST["puesto"];
        $jefeDirecto = $_POST["jefeDirecto"];
        $entradaViernes = $_POST["entradaViernes"];
        $salidaViernes = $_POST["salidaViernes"];
        $add_acumulaVacs = $_POST['add_acumulaVacs'];
        
        $query = "UPDATE tc_empleados SET nombre = '$nombreEmpleado', idChecador = '$checador', segundoNombre = '$segundoNombre', apellido_p = '$apellidoP', apellido_m = '$apellidoM', departamento = '$departamento', direccion = '$direccion', ingreso = '$ingreso', mail = '$mailEmp', entrada = '$entrada', salida = '$salida', idEncargado = '$jefeDirecto', puesto = '$puesto', entradaDos = '$entradaDos', salidaDos = '$salidaDos', entradaViernes = '$entradaViernes', salidaViernes = '$salidaViernes', acumulaVacs = '$add_acumulaVacs'  WHERE idEmpleado = '$idEmpleado'";
        if (!$result = mysqli_query($con, $query)) {
            exit(mysqli_error($con));
        }

        $queryEmpleado = "SELECT e.*, d.nombreDepartamento, di.nombreDireccion FROM tc_empleados e INNER JOIN tc_departamento d ON d.idDepartamento = e.departamento INNER JOIN tc_direccion di ON di.idDireccion = e.direccion WHERE e.idEmpleado = '$idEmpleado' ORDER BY e.apellido_p, e.apellido_m";
        if (!$resultEmpleado = mysqli_query($con, $queryEmpleado)) {
            exit(mysqli_error($con));
        }
        if(mysqli_num_rows($resultEmpleado) > 0){
            while($row = mysqli_fetch_array($resultEmpleado)){
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
                    "acumula" => $row["acumulaVacs"],
                );
            }
            
        }
        print json_encode($respuesta);

?>