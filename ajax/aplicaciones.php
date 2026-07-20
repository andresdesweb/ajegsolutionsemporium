<?php
        $respuesta=array();
        // include Database connection file 
        $accion = $_POST["accion"];

        

        include("db_connection.php");
        $respuesta=array();
        if($accion == 1 || $accion == '1'){
            $idEmpleado = $_POST["idEmpleado"];
            $mailEmp = $_POST["mailEmp"];
            $nominaPer = $_POST["nominaPer"];
            $personalPer = $_POST["personalPer"];
            $vacacionesPer = $_POST["vacacionesPer"];
            $incidenciasPer = $_POST["incidenciasPer"];
            $politicasPer = $_POST["incidenciasPer"];
            $passwordEmpleado = $_POST["passwordEmpleado"];

            $queryCheck = "SELECT * FROM tc_usuarios WHERE idEmp = '$idEmpleado'";
            if (!$resultCheck = mysqli_query($con, $queryCheck)) {
                exit(mysqli_error($con));
            }
            if(mysqli_num_rows($resultCheck) > 0){
                
                die();
                header('HTTP/1.1 500 sessión no iniciada');
                header('Content-Type: application/json; charset=UTF-8');
                die(json_encode(array('message' => 'ERROR', 'code' => 1337)));
            }else{
                $query = "INSERT INTO  tc_usuarios VALUES(DEFAULT, '$mailEmp', '$passwordEmpleado', MD5(RAND()), '$idEmpleado',1)";
                if (!$result = mysqli_query($con, $query)) {
                    exit(mysqli_error($con));
                }
                $queryPermisos = "INSERT INTO tr_accesoapps VALUES(DEFAULT, '$idEmpleado', '1', '$personalPer')";
                if (!$resultPermisos = mysqli_query($con, $queryPermisos)) {
                    exit(mysqli_error($con));
                }

                $queryPermisosNomina = "INSERT INTO tr_accesoapps VALUES(DEFAULT, '$idEmpleado', '2', '$nominaPer')";
                if (!$resultPermisosNomina = mysqli_query($con, $queryPermisosNomina)) {
                    exit(mysqli_error($con));
                }

                $queryPermisosIncidencias = "INSERT INTO tr_accesoapps VALUES(DEFAULT, '$idEmpleado', '3', '$incidenciasPer')";
                if (!$resultPermisosIncidencias = mysqli_query($con, $queryPermisosIncidencias)) {
                    exit(mysqli_error($con));
                }

                $queryPermisosVacas = "INSERT INTO tr_accesoapps VALUES(DEFAULT, '$idEmpleado', '4', '$vacacionesPer')";
                if (!$resultPermisosVacas = mysqli_query($con, $queryPermisosVacas)) {
                    exit(mysqli_error($con));
                }

                $queryPermisosPoli = "INSERT INTO tr_accesoapps VALUES(DEFAULT, '$idEmpleado', '5', '$vacacionesPer')";
                if (!$resultPermisosPoli = mysqli_query($con, $queryPermisosPoli)) {
                    exit(mysqli_error($con));
                }
                // if(mysqli_num_rows($result) > 0){
                //     while($row = mysqli_fetch_array($result)){
                //         $respuesta[] = array(
                //             "idApp" => $row["idApp"],
                //             "nombreAplicacion" => $row["nombreAplicacion"],
                //             "descripcionApp" => $row["descripcionApp"],
                //             "urlApp" => $row["urlApp"],
                //         );
                //     }
                    
                // }else{
                //     $respuesta[] = array(
                //         "status" => "error",
                //     );
                // }
            }

            

 
        }else if($accion == 2 || $accion == '2'){
            $idEmpleado = $_POST["emp"];
            $query = "SELECT * FROM tr_accesoapps WHERE idEmpleado = '$idEmpleado'";
            if (!$result = mysqli_query($con, $query)) {
                exit(mysqli_error($con));
            }
            if(mysqli_num_rows($result) > 0){
                while($row = mysqli_fetch_array($result)){
                    $respuesta[] = array(
                        "idApp" => $row["idApp"],
                        "nivelAcceso" => $row["nivelAcceso"],
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