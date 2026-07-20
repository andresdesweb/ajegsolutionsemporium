<?php
        $respuesta=array();
        session_start();
        $empleado = $_SESSION["idEmp"];

        // include Database connection file 
        include("db_connection.php");
        $respuesta=array();
            $query = "SELECT ap.*, a.* FROM tr_accesoapps ap INNER JOIN tc_aplicaciones a ON a.idApp = ap.idApp WHERE ap.idEmpleado = '$empleado'";
            //$query = "SELECT i.*, d.nombreDepartamento as departamento FROM tr_incidencias i INNER JOIN tc_departamento d ON i.areaEmpleado = d.idDepartamento where i.idEmpleado = 1 OR i.inserta = 1";
            if (!$result = mysqli_query($con, $query)) {
                exit(mysqli_error($con));
            }
            while($row = mysqli_fetch_array($result)){
                $respuesta[] = array(
                    "idApp" => $row["idApp"],
                    "nivelAcceso" => $row["nivelAcceso"],
                    "nombreAplicacion" => $row["nombreAplicacion"],
                    "url" => $row["urlApp"]
                );
            }
            print json_encode($respuesta);
        
?>