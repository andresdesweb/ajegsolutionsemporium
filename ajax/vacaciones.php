<?php
        $respuesta=array();
        // include Database connection file 
        $accion = $_POST["accion"];
        $permiso = $_POST["permiso"];

        

        include("db_connection.php");
        $respuesta=array();
        if($accion == 3 || $accion == '3'){
            $empleadoChecador = $_POST["empleadoChecador"];
            $empleadoId = $_POST["empleadoId"];
            $diasAgregar = $_POST["diasAgregar"];
            $utilizables = $_POST["utilizables"];
            $anio = $_POST["anio"];
            $anioVacaciones = $_POST["anioVacaciones"];
            $queryPre = "SELECT * FROM tr_vacacionespendientes WHERE idEmpleado = '$empleadoId' AND year(fechaActualizacion) = '$anio'";
            if (!$resultPre = mysqli_query($con, $queryPre)) {
                exit(mysqli_error($con));
            }
            if(mysqli_num_rows($resultPre) > 0){
                $query = "UPDATE tr_vacacionespendientes SET diasPendientes = diasPendientes + $diasAgregar WHERE idEmpleado = '$empleadoId' AND year(fechaActualizacion) = '$anio'";
                if (!$result = mysqli_query($con, $query)) {
                    exit(mysqli_error($con));
                }
                $respuesta[] = array(
                    "status" => "insercion",
                );
            }else{
                $query = "INSERT INTO tr_vacacionespendientes VALUES('', '$empleadoId', '$diasAgregar', '$anioVacaciones', '$empleadoChecador', '$utilizables')";
                if (!$result = mysqli_query($con, $query)) {
                    exit(mysqli_error($con));
                }
                $respuesta[] = array(
                    "status" => "insercion",
                );
            }

 
        }else{
            //ver todo
            if($permiso == 3){
                $query = "SELECT v.*, year(v.fechaActualizacion) as anio, CONCAT(apellido_p, ' ', e.apellido_m, ' ', e.nombre, ' ',  e.segundoNombre) as nombreEmpleado, e.isActive FROM tr_vacacionespendientes v INNER JOIN tc_empleados e ON e.idEmpleado = v.idEmpleado ORDER BY v.idEmpleado, v.utilizables DESC";
                if (!$result = mysqli_query($con, $query)) {
                    exit(mysqli_error($con));
                }
                if(mysqli_num_rows($result) > 0){
                    while($row = mysqli_fetch_array($result)){
                        $respuesta[] = array(
                            "idChecador" => $row["idChecador"],
                            "idEmpleado" => $row["idEmpleado"],
                            "NombreEmpleado" => $row["nombreEmpleado"],
                            "diasPendientes" => $row["diasPendientes"],
                            "fechaActualizacion" => $row["fechaActualizacion"],
                            "utilizables" => $row["utilizables"],
                            "anio" => $row["anio"],
                            "activo" => $row["isActive"]
                            
                        );
                    }
                    
                }else{
                    $respuesta[] = array(
                        "status" => "error",
                    );
                }
            }else{
                $idEmpleado = $_POST["idEmpleado"];
                $query = "SELECT v.*, year(v.fechaActualizacion) as anio, CONCAT(apellido_p, ' ', e.apellido_m, ' ', e.nombre, ' ',  e.segundoNombre) as nombreEmpleado FROM tr_vacacionespendientes v INNER JOIN tc_empleados e ON e.idEmpleado = v.idEmpleado WHERE v.idEmpleado = '$idEmpleado' ORDER BY v.idEmpleado, v.utilizables DESC";
                if (!$result = mysqli_query($con, $query)) {
                    exit(mysqli_error($con));
                }
                if(mysqli_num_rows($result) > 0){
                    while($row = mysqli_fetch_array($result)){
                        $respuesta[] = array(
                            "idChecador" => $row["idChecador"],
                            "idEmpleado" => $row["idEmpleado"],
                            "NombreEmpleado" => $row["nombreEmpleado"],
                            "diasPendientes" => $row["diasPendientes"],
                            "fechaActualizacion" => $row["fechaActualizacion"],
                            "utilizables" => $row["utilizables"],
                            "anio" => $row["anio"],
                            
                        );
                    }
                    
                }else{
                    $respuesta[] = array(
                        "status" => "error",
                    );
                }
            }
        }
 
        
    print json_encode($respuesta);
?>