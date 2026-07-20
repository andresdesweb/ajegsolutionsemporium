<?php
        $respuesta=array();
        // include Database connection file 
        include("db_connection.php");
        $respuesta=array();
        if(isset($_POST['idDireccion'])){
            $idDireccion = $_POST['idDireccion'];
            $WhereParam = "WHERE idDireccion = $idDireccion";
        }else{
            $idDireccion = ''; 
            $WhereParam = '';
        }
 
        $query = "SELECT * FROM tc_direccion $WhereParam";
        if (!$result = mysqli_query($con, $query)) {
            exit(mysqli_error($con));
        }
        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_array($result)){
                $respuesta[] = array(
                    "idDireccion" => $row["idDireccion"],
                    "nombreDireccion" => $row["nombreDireccion"],
                );
            }
            
        }else{
            $respuesta[] = array(
                "status" => "error",
            );
        }
    print json_encode($respuesta);
?>