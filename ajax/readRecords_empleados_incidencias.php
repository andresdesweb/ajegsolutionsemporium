<?php
        $respuesta=array();
        // include Database connection file 
        include("db_connection.php");
        $respuesta=array();
        session_start();
        $idDepartamento = $_SESSION["departamento"];
        $permisosDepartamentos = $_SESSION["permisoIncidencias"];
        $idDireccion = $_SESSION["direccion"];
        $idEmpleado = $_SESSION["idEmp"];
        
        if($permisosDepartamentos == 3){
            $query = "SELECT e.*, d.nombreDepartamento, di.nombreDireccion FROM tc_empleados e INNER JOIN tc_departamento d ON d.idDepartamento = e.departamento INNER JOIN tc_direccion di ON di.idDireccion = e.direccion WHERE e.isActive = 1 ORDER BY e.apellido_p, apellido_m";
            //$query = "SELECT e.*, d.nombreDepartamento, di.nombreDireccion FROM tc_empleados e INNER JOIN tc_departamento d ON d.idDepartamento = e.departamento INNER JOIN tc_direccion di ON di.idDireccion = e.direccion";
        }else if($permisosDepartamentos == 4){
            $query = "SELECT e.*, d.nombreDepartamento, di.nombreDireccion FROM tc_empleados e INNER JOIN tc_departamento d ON d.idDepartamento = e.departamento INNER JOIN tc_direccion di ON di.idDireccion = e.direccion WHERE e.idEmpleado = '$idEmpleado' OR e.idEncargado = '$idEmpleado' ORDER BY e.apellido_p, apellido_m";
        }else{
            $query = "SELECT e.*, d.nombreDepartamento, di.nombreDireccion FROM tc_empleados e INNER JOIN tc_departamento d ON d.idDepartamento = e.departamento INNER JOIN tc_direccion di ON di.idDireccion = e.direccion WHERE e.idEmpleado = '$idEmpleado' ORDER BY e.apellido_p, apellido_m";
            //$query = "SELECT e.*, d.nombreDepartamento, di.nombreDireccion FROM tc_empleados e INNER JOIN tc_departamento d ON d.idDepartamento = e.departamento INNER JOIN tc_direccion di ON di.idDireccion = e.direccion WHERE e.departamento = '$idDepartamento'";
        }
        
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
                );
            }
            
        }else{
            $respuesta[] = array(
                "status" => "error",
            );
        }
    print json_encode($respuesta);
?>