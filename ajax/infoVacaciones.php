<?php
        $respuesta=array();
        // include Database connection file 
        $idChecador = $_POST["idChecador"];

        include("db_connection.php");
        $respuesta=array();
 
        $query = "SELECT year(fechaActualizacion) as anio, diasPendientes, utilizables FROM tr_vacacionespendientes WHERE idChecador = '$idChecador'";
        if (!$result = mysqli_query($con, $query)) {
            exit(mysqli_error($con));
        }
        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_array($result)){
                $respuesta[] = array(
                    "diasPendientes" => $row["diasPendientes"],
                    "anio" => $row["anio"],
                    "utilizables" => $row["utilizables"],
                );
            }
            
        }else{
            $respuesta[] = array(
                "status" => "error",
            );
        }
    print json_encode($respuesta);
?>