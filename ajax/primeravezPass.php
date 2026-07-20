<?php
        $respuesta=array();
        session_start();
        $usuario = $_SESSION["userId"];
        $accion = $_POST["accion"];
        $resultado = "";

        // include Database connection file 
        include("db_connection.php");
        $respuesta=array();
        if($accion == 1){
            $query = "SELECT * FROM tc_usuarios WHERE idUsuario = '$usuario'";
            //$query = "SELECT i.*, d.nombreDepartamento as departamento FROM tr_incidencias i INNER JOIN tc_departamento d ON i.areaEmpleado = d.idDepartamento where i.idEmpleado = 1 OR i.inserta = 1";
            if (!$result = mysqli_query($con, $query)) {
                exit(mysqli_error($con));
            }
            while($row = mysqli_fetch_array($result)){
                $resultado = $row["primeraVez"];
            }
            print $resultado;
        }else{
            $nuevaContra = $_POST["nuevaContra"];
            $query = " UPDATE tc_usuarios SET password = '$nuevaContra', primeraVez = 1 WHERE idUsuario = '$usuario'";
            if (!$result = mysqli_query($con, $query)) {
                exit(mysqli_error($con));
            }
            print 1;
        }
        
?>