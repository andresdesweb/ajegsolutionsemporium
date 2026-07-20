<?php
        $respuesta=array();
        
        session_start();
        $idEmpleado = $_SESSION["idEmp"];

    
        include("db_connection.php");

            $queryPre = "SELECT SUM(diasPendientes) as pendientes FROM tr_vacacionespendientes WHERE idEmpleado = '$idEmpleado' AND utilizables = 1";

            if (!$resultPre = mysqli_query($con, $queryPre)) {
                exit(mysqli_error($con));
            }
            while($row = mysqli_fetch_array($resultPre)){
                $respuesta[] = array(
                    "disponibles" => $row["pendientes"],
                    
                );
            }
 
        
    print json_encode($respuesta);
?>