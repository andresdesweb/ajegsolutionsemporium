<?php
    if(isset($_POST['userLogin']) && isset($_POST['passwordLogin']))
    {
        $respuesta=array();
        // include Database connection file 
        include("db_connection.php");
 
        // get values 
        $add_user = $_POST['userLogin'];
        $add_password = $_POST['passwordLogin'];
  
 
        $query = "SELECT *, MD5(RAND()) as token FROM tc_usuarios WHERE usuario = '$add_user' AND password = '$add_password'";
        if (!$result = mysqli_query($con, $query)) {
            exit(mysqli_error($con));
        }
        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_array($result)){
                if($add_user == $row["usuario"] && $add_password == $row["password"]){
                    $empleado = $row["idEmp"];
                    $queryArea = "SELECT departamento, direccion FROM tc_empleados WHERE idEmpleado = '$empleado'";
                    if (!$resultArea = mysqli_query($con, $queryArea)) {
                        exit(mysqli_error($con));
                    }
                    while($rowArea = mysqli_fetch_array($resultArea)){
                        $areaEmpleado = $rowArea["departamento"];
                        $direccionEmpleado = $rowArea["direccion"];
                    }
                    $tokenSession = $row["token"];
                    $respuesta[] = array(
                        "status" => "success",
                        "token" => $row["token"],
                        "emp" => $row["idEmp"]
                    );
                    $queryPermisos = "SELECT * FROM tr_accesoapps WHERE idEmpleado = '$empleado'";
                    if (!$resultPermisos = mysqli_query($con, $queryPermisos)) {
                        exit(mysqli_error($con));
                    }
                    while($rowPermisos = mysqli_fetch_array($resultPermisos)){
                        if($rowPermisos["idApp"] == 1){
                            $permisoGestion = $rowPermisos["nivelAcceso"];
                        }
                        if($rowPermisos["idApp"] == 2){
                            $permisoNomina = $rowPermisos["nivelAcceso"];
                        }
                        if($rowPermisos["idApp"] == 3){
                            $permisoIncidencias = $rowPermisos["nivelAcceso"];
                        }
                        if($rowPermisos["idApp"] == 4){
                            $permisoVacaciones = $rowPermisos["nivelAcceso"];
                        }
                    }

                    session_start();
                    $_SESSION["user"] = $row["usuario"];
                    $_SESSION["userId"] = $row["idUsuario"];
                    $_SESSION["departamento"] = $areaEmpleado;
                    $_SESSION["direccion"] = $direccionEmpleado;
                    $_SESSION["idEmp"] = $empleado;
                    $_SESSION["permisoGestion"] = $permisoGestion;
                    $_SESSION["permisoNomina"] = $permisoNomina;
                    $_SESSION["permisoIncidencias"] = $permisoIncidencias;
                    $_SESSION["permisoVacaciones"] = $permisoVacaciones;
                }else{
                    $respuesta[] = array(
                        "status" => "error",
                    );
                }
            }
            $query = "UPDATE tc_usuarios SET tokenSession = '$tokenSession'  WHERE usuario = '$add_user' AND password = '$add_password'";
                    if (!$result = mysqli_query($con, $query)) {
                        exit(mysqli_error($con));
                    }
            
        }else{
            $respuesta[] = array(
                "status" => "error",
            );
        }
    }
    print json_encode($respuesta);
?>