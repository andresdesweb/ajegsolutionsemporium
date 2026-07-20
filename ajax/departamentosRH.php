<?php
        $respuesta=array();
        // include Database connection file 
        include("db_connection.php");
        $respuesta=array();
        if(isset($_POST['idDepartamento'])){
            $idDepartamento = $_POST['idDepartamento'];
            $WhereParam = "WHERE idDepartamento = $idDepartamento";
        }else{
            $idDepartamento = ''; 
            $WhereParam = '';
        }
        $query = "SELECT * FROM tc_departamento $WhereParam";
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