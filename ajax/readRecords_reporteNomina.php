<?php
        $respuesta=array();
        // include Database connection file 
        include("db_connection.php");
        $respuesta=array();
        //$empleadoActual = $_POST["empleadoActual"];
        $tipoIncidenciaRevisar = $_POST["tipoIncidenciaRevisar"];
        $idPeriodo = $_POST["idPeriodo"];
        
        $queryEmpleados = "SELECT e.*, d.nombreDepartamento, di.nombreDireccion FROM tc_empleados e INNER JOIN tc_departamento d ON d.idDepartamento = e.departamento INNER JOIN tc_direccion di ON di.idDireccion = e.direccion";
        if (!$resultEmpleados = mysqli_query($con, $queryEmpleados)) {
            exit(mysqli_error($con));
        }
        if(mysqli_num_rows($resultEmpleados) > 0){
            while($rowEmpleado = mysqli_fetch_array($resultEmpleados)){
                $empleado = $rowEmpleado["idChecador"];
                $query = "SELECT rn.*, DATE(rn.fechaHora) as fecha, TIME(rn.fechaHora) as hora, CONCAT(e.apellido_p, ' ', e.apellido_m, ' ', e.nombre, ' ', e.segundoNombre) as nombreEmpleado, e.idEmpleado FROM tr_reportenomina rn INNER JOIN tc_empleados e ON e.idChecador = rn.idChecador WHERE idPeriodo = '$idPeriodo' AND rn.idChecador = '$empleado' AND rn.tipoChecada = '$tipoIncidenciaRevisar' ORDER BY DATE(rn.fechaHora), TIME(rn.fechaHora)";
                if (!$result = mysqli_query($con, $query)) {
                    exit(mysqli_error($con));
                }
                if(mysqli_num_rows($result) > 0){
                    while($row = mysqli_fetch_array($result)){
                        $fechaIncidencia = $row["fecha"];
                        $empleadoVuelta = $row["idEmpleado"];
                        //Revisamos que haya incidencias de esta fecha
                        $queryIncidencia = "SELECT * FROM tr_incidencias WHERE fechaPase = '$fechaIncidencia' AND idEmpleado = '$empleadoVuelta'";
                        if (!$resultIncidencia = mysqli_query($con, $queryIncidencia)) {
                            exit(mysqli_error($con));
                        }
                        if(mysqli_num_rows($resultIncidencia) > 0){
                            while($rowIncidencia = mysqli_fetch_array($resultIncidencia)){
                                $respuesta[] = array(
                                    "idRegistro" => $row["idRegistro"],
                                    "checador" => $row["idChecador"],
                                    "tipoChecada" => $row["tipoChecada"],
                                    "fechaHora" => $row["fechaHora"],
                                    "comentario" => $row["comentario"],
                                    "idPeriodo" => $row["idPeriodo"],
                                    "nombreEmpleado" => $row["nombreEmpleado"],
                                    "fecha" => $row["fecha"],
                                    "hora" => $row["hora"],
                                    "entrada" => $rowEmpleado["entrada"],
                                    "salida" => $rowEmpleado["salida"],
                                    "entradaDos" => $rowEmpleado["entradaDos"],
                                    "salidaDos" => $rowEmpleado["salidaDos"],
                                    "incidenciaAsociada" => $rowIncidencia["idPase"],
                                    "incidenciaStatus" => $rowIncidencia["estado"],
                                    "tipoIncidencia" => $rowIncidencia["tipoIncidencia"],
                                    "motivoIncidencia" => $rowIncidencia["motivo"],
                                    "entradaViernes" => $rowEmpleado["entradaViernes"],
                                    "salidaViernes" => $rowEmpleado["salidaViernes"],
                                );
                            }
                        }else{
                            $respuesta[] = array(
                                "idRegistro" => $row["idRegistro"],
                                "checador" => $row["idChecador"],
                                "tipoChecada" => $row["tipoChecada"],
                                "fechaHora" => $row["fechaHora"],
                                "comentario" => $row["comentario"],
                                "idPeriodo" => $row["idPeriodo"],
                                "nombreEmpleado" => $row["nombreEmpleado"],
                                "fecha" => $row["fecha"],
                                "hora" => $row["hora"],
                                "entrada" => $rowEmpleado["entrada"],
                                "salida" => $rowEmpleado["salida"],
                                "entradaDos" => $rowEmpleado["entradaDos"],
                                "salidaDos" => $rowEmpleado["salidaDos"],
                                "incidenciaAsociada" => "",
                                "incidenciaStatus" => "",
                                "entradaViernes" => $rowEmpleado["entradaViernes"],
                                "salidaViernes" => $rowEmpleado["salidaViernes"],

                            );
                        }
                        //Revisamos que haya incidencias de esta fecha
                        
                    }
                    
                }                
            }
            
        }
 
        // $query = "SELECT rn.*, DATE(rn.fechaHora) as fecha, TIME(rn.fechaHora) as hora, CONCAT(e.apellido_p, ' ', e.apellido_m, ' ', e.nombre, ' ', e.segundoNombre) as nombreEmpleado FROM tr_reportenomina rn INNER JOIN tc_empleados e ON e.idChecador = rn.idChecador WHERE idPeriodo = 1 AND rn.idChecador = '$empleadoActual' AND rn.tipoChecada = '$tipoIncidenciaRevisar' ORDER BY DATE(rn.fechaHora), TIME(rn.fechaHora)";
        // if (!$result = mysqli_query($con, $query)) {
        //     exit(mysqli_error($con));
        // }
        // if(mysqli_num_rows($result) > 0){
        //     while($row = mysqli_fetch_array($result)){
        //         $respuesta[] = array(
        //             "idRegistro" => $row["idRegistro"],
        //             "checador" => $row["idChecador"],
        //             "tipoChecada" => $row["tipoChecada"],
        //             "fechaHora" => $row["fechaHora"],
        //             "comentario" => $row["comentario"],
        //             "idPeriodo" => $row["idPeriodo"],
        //             "nombreEmpleado" => $row["nombreEmpleado"],
        //             "fecha" => $row["fecha"],
        //             "hora" => $row["hora"],
        //         );
        //     }
            
        // }else{
        //     $respuesta[] = array(
        //         "status" => "error",
        //     );
        // }
    print json_encode($respuesta);
?>