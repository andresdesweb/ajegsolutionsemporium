<?php
        $respuesta=array();
        // include Database connection file 
        include("db_connection.php");
        $respuesta=array();
 
        $query = "SELECT * FROM tc_periodosnomina";
        if (!$result = mysqli_query($con, $query)) {
            exit(mysqli_error($con));
        }
        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_array($result)){
                $respuesta[] = array(
                    "periodo" => $row["idPeriodo"],
                    "inicio" => $row["fechaInicio"],
                    "fin" => $row["fechaFin"],
                );
            }
            
        }else{
            $respuesta[] = array(
                "periodo" => 0,
                "inicio" => "NO HAY PERIODOS REGISTRADOS",
                "fin" => "",
            );
        }
    print json_encode($respuesta);
?>