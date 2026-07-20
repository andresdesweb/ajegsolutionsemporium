<?php
        $respuesta=array();
        // include Database connection file 
        include("db_connection.php");
        session_start();
        $idDepartamento = $_SESSION["departamento"];
        $permisosDepartamentos = $_SESSION["permisoIncidencias"];
        $respuesta=array();
        if($permisosDepartamentos == 3){
            $query = "SELECT * FROM tc_departamento";
        }else{
            $query = "SELECT * FROM tc_departamento WHERE idDepartamento = $idDepartamento";
        }
        
        if (!$result = mysqli_query($con, $query)) {
            exit(mysqli_error($con));
        }
        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_array($result)){
                $respuesta[] = array(
                    "idDepartamento" => $row["idDepartamento"],
                    "nombreDepartamento" => $row["nombreDepartamento"],
                );
            }
            
        }else{
            $respuesta[] = array(
                "status" => "error",
            );
        }
    print json_encode($respuesta);
?>