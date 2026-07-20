<?php
        $respuesta=array();
        session_start();
        $departamento = $_SESSION["departamento"];
        $idDireccion = $_SESSION["direccion"];
        $permisosDepartamentos = $_SESSION["permisoIncidencias"];
        $idEmpleado = $_SESSION["idEmp"];
        
        if(isset($_POST["verTodo"])){
            $verTodo = $_POST["verTodo"];
        }
        // include Database connection file 
        include("db_connection.php");

        if(isset($_POST["idIncidencia"])){
            $idIncidencia = $_POST["idIncidencia"];
        }


        if(isset($_POST['idPeriodo'])){
            $idPeriodo = $_POST['idPeriodo'];
        }else{
            $idPeriodo = 1;
        }
        $respuesta=array();
        if(isset($_POST['idIncidencia'])){
            $query = "SELECT i.*, d.nombreDepartamento as departamento FROM tr_incidencias i INNER JOIN tc_departamento d ON i.direccionEmpleado = d.idDepartamento WHERE i.idPase = '$idIncidencia'";
        }else{
            if($permisosDepartamentos == 3){
                $query = "SELECT i.*, d.nombreDepartamento as departamento FROM tr_incidencias i INNER JOIN tc_departamento d ON i.direccionEmpleado = d.idDepartamento";
            }else if($permisosDepartamentos == 2 || $permisosDepartamentos == 4){
                $query = "SELECT i.*, d.nombreDepartamento as departamento FROM tr_incidencias i INNER JOIN tc_departamento d ON i.direccionEmpleado = d.idDepartamento INNER JOIN tc_empleados e ON e.idEmpleado = i.idEmpleado WHERE e.idEncargado = '$idEmpleado' OR i.idEmpleado = '$idEmpleado'";
            }else{
                $query = "SELECT i.*, d.nombreDepartamento as departamento FROM tr_incidencias i INNER JOIN tc_departamento d ON i.direccionEmpleado = d.idDepartamento WHERE i.idEmpleado = '$idEmpleado'";
            }
        }
        
        
        //$query = "SELECT i.*, d.nombreDepartamento as departamento FROM tr_incidencias i INNER JOIN tc_departamento d ON i.areaEmpleado = d.idDepartamento where i.idEmpleado = 1 OR i.inserta = 1";
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
                    "urlEvidencia" => $row["urlEvidencia"]
                );
            }
            
        }else{
            $respuesta[] = array(
                "status" => "error",
            );
        }
    print json_encode($respuesta);
?>