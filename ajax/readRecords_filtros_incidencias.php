<?php
    // if(isset($_POST['nombreDireccion']))
    // {
        // include Database connection file 
        include("db_connection.php");
        $filtroFecha = $_POST["filtroFecha"];
        $filtroDepartamento = $_POST["filtroDepartamento"];
        $filtroTipo = $_POST["filtroTipo"];
        $filtroFechaRegistro = $_POST["filtroFechaRegistro"];

        $filtro = "";
        if($filtroFecha != ""){
            //$filtro = $filtro." AND i.fechaPase =".$filtroFecha; 
        }
        if($filtroDepartamento != ""){
            $filtro = $filtro." AND i.areaEmpleado =".$filtroDepartamento; 
        }
        if($filtroTipo != ""){
            $filtro = $filtro." AND i.tipoIncidencia =".$filtroTipo; 
        }
        if($filtroFechaRegistro != ""){
            $filtro = $filtro." AND i.fechaRegistro =".$filtroFechaRegistro; 
        }

 
        $query = "SELECT i.*, d.nombreDepartamento as departamento FROM tr_incidencias i INNER JOIN tc_departamento d ON i.areaEmpleado = d.idDepartamento where i.estado = 1 '$filtro'";
        if (!$result = mysqli_query($con, $query)) {
            exit(mysqli_error($con)); 
        }
        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_array($result)){
                $respuesta[] = array(
                    "fechaPase" => $row["fechaPase"],
                    "idEmpleado" => $row["idEmpleado"],
                    "departamento" => $row["departamento"],
                    "direccionEmpleado" => $row["direccionEmpleado"],
                    "nombreEmpleado" => $row["nombreEmpleado"],
                    "entrada" => $row["entrada"],
                    "salida" => $row["salida"],
                    "motivo" => $row["motivo"],
                    "tipoIncidencia" => $row["tipoIncidencia"],
                    "fechaRegistro" => $row["fechaRegistro"],
                    "idQuincena" => $row["idQuincena"],
                    "inserta" => $row["inserta"],
                    "estado" => $row["estado"],
                    "idPase" => $row["idPase"],
                    "comentarioNoProcede" => $row["comentarioNoProcede"],
                );
            }
            
        }else{
            $respuesta[] = array(
                "status" => "error",
            );
        }
    print json_encode($respuesta);
    // }
?>