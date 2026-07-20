<?php
include("db_connection.php");
session_start();
        $departamento = $_SESSION["departamento"];
        $idDireccion = $_SESSION["direccion"];
        $permisosDepartamentos = $_SESSION["permisoIncidencias"];
        $idEmpleado = $_SESSION["idEmp"];
    $query = "SELECT CONCAT(apellido_p, ' ', apellido_m, ' ', nombre, ' ', segundoNombre) as nombreEmpleado FROM tc_empleados WHERE idEmpleado = '$idEmpleado'";
        if (!$result = mysqli_query($con, $query)) {
            exit(mysqli_error($con));
        }
        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_array($result)){
                $respuesta[] = array(
                    "Nombre" => $row["nombreEmpleado"],
                );
            }
            print json_encode($respuesta);
        }else{
            header("Location: index.html");
            die();
            header('HTTP/1.1 500 sessión no iniciada');
            header('Content-Type: application/json; charset=UTF-8');
            die(json_encode(array('message' => 'ERROR', 'code' => 1337)));
        }
?>