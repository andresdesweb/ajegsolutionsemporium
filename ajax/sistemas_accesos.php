<?php
        $respuesta=array();
        // include Database connection file 
        include("db_connection.php");
        $respuesta=array();
        if (isset($_POST["empleado"]) && isset($_POST["accion"])){
            $empleado = $_POST["empleado"];
            if($_POST["accion"] == 1){
                $query = "SELECT * FROM tr_accesoapps WHERE idEmpleado = '$empleado'";
                if (!$result = mysqli_query($con, $query)) {
                    exit(mysqli_error($con));
                }
                if(mysqli_num_rows($result) > 0){
                    while($row = mysqli_fetch_array($result)){
                        $respuesta[] = array(
                            "idApp" => $row["idApp"],
                            "idEmpleado" => $row["idEmpleado"],
                            "nivelAcceso" => $row["nivelAcceso"],
                        );
                        
                    }
                    
                }else{
                    $respuesta[] = array(
                        "status" => "error",
                    );
                }
            }
            if($_POST["accion"] == 2){
                $nominaPer = $_POST["nominaPer"];
                $personalPer = $_POST["personalPer"];
                $vacacionesPer = $_POST["vacacionesPer"];
                $incidenciasPer = $_POST["incidenciasPer"];
                $politicasPer = $_POST["politicasPer"];
                $query = "UPDATE tr_accesoapps SET nivelAcceso = '$personalPer' WHERE idApp = 1 AND idEmpleado = '$empleado'";
                if (!$result = mysqli_query($con, $query)) {
                    exit(mysqli_error($con));
                }

                $queryNom = "UPDATE tr_accesoapps SET nivelAcceso = '$nominaPer' WHERE idApp = 2 AND idEmpleado = '$empleado'";
                if (!$result = mysqli_query($con, $queryNom)) {
                    exit(mysqli_error($con));
                }

                $queryInci = "UPDATE tr_accesoapps SET nivelAcceso = '$incidenciasPer' WHERE idApp = 3 AND idEmpleado = '$empleado'";
                if (!$result = mysqli_query($con, $queryInci)) {
                    exit(mysqli_error($con));
                }

                $queryVacas = "UPDATE tr_accesoapps SET nivelAcceso = '$vacacionesPer' WHERE idApp = 4 AND idEmpleado = '$empleado'";
                if (!$result = mysqli_query($con, $queryVacas)) {
                    exit(mysqli_error($con));
                }

                $queryPoli = "UPDATE tr_accesoapps SET nivelAcceso = '$politicasPer' WHERE idApp = 5 AND idEmpleado = '$empleado'";
                if (!$result = mysqli_query($con, $queryPoli)) {
                    exit(mysqli_error($con));
                }
            }
            
            


        }else{
            //$query = "SELECT aa.*, CONCAT(em.apellido_p, ' ', em.apellido_m, ' ', em.nombre, ' ', em.segundoNombre) as Nombre, ap.* FROM tr_accesoapps aa INNER JOIN tc_empleados em ON em.idEmpleado = aa.idEmpleado INNER JOIN tc_aplicaciones ap ON ap.idApp = aa.idApp ORDER BY aa.idEmpleado";
            $query = "SELECT CONCAT(em.apellido_p, ' ', em.apellido_m, ' ', em.nombre, ' ', em.segundoNombre) as Nombre, em.idEmpleado FROM tr_accesoapps aa INNER JOIN tc_empleados em ON em.idEmpleado = aa.idEmpleado GROUP BY em.idEmpleado ORDER BY em.idEmpleado";
            if (!$result = mysqli_query($con, $query)) {
                exit(mysqli_error($con));
            }
            if(mysqli_num_rows($result) > 0){
                while($row = mysqli_fetch_array($result)){
                    $respuesta[] = array(
                        "nombreEmpleado" => $row["Nombre"],
                        "idEmpleado" => $row["idEmpleado"],
                    );
                    
                }
                
            }else{
                $respuesta[] = array(
                    "status" => "error",
                );
            }
        }
        
    print json_encode($respuesta);
?>