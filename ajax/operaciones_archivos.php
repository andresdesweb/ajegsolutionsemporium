<?php
        $respuesta=array();
        // include Database connection file 
        include("db_connection.php");
        $idArchivo = $_POST["idArchivo"];
        $accion = $_POST["accion"];
        $respuesta=array();
        if($accion == "ver"){
            $query = "SELECT * FROM tc_archivospoliticas WHERE idArchivo = '$idArchivo'";
            if (!$result = mysqli_query($con, $query)) {
                exit(mysqli_error($con));
            }
            if(mysqli_num_rows($result) > 0){
                while($row = mysqli_fetch_array($result)){
                    $respuesta[] = array(
                        "idArchivo" => $row["idArchivo"],
                        "titulo" => $row["tituloPolitica"],
                        "url" => $row["urlAchivo"],
                    );
                }
                
            }else{
                $respuesta[] = array(
                    "status" => "error",
                );
            }
        }
        if($accion == "borrar"){
            $query = "DELETE FROM tc_archivospoliticas WHERE idArchivo = '$idArchivo'";
            if (!$result = mysqli_query($con, $query)) {
                exit(mysqli_error($con));
            } 
        }
        if($accion == "editar"){
            $titulo = $_POST["titulo"];
            $src = $_FILES['image']['tmp_name'];
            $filename = $_FILES['image']['name'];
            $output_dir = "../upload/".$filename;
            if (move_uploaded_file($src, $output_dir )) {
                $query = "UPDATE tc_archivospoliticas SET tituloPolitica = '$titulo', urlAchivo = '$filename' WHERE idArchivo = '$idArchivo'";
                if (!$result = mysqli_query($con, $query)) {
                    exit(mysqli_error($con));
                } 
            } else{
                //echo "Error! Image upload failed! File: ".$filename;
            }
            
        }
        if($accion == "editarSinArchivo"){
            $titulo = $_POST["titulo"];
            $query = "UPDATE tc_archivospoliticas SET tituloPolitica = '$titulo' WHERE idArchivo = '$idArchivo'";
                if (!$result = mysqli_query($con, $query)) {
                    exit(mysqli_error($con));
                } 
        }
        if($accion == "desplegar"){
            $query = "SELECT * FROM tc_archivospoliticas";
            if (!$result = mysqli_query($con, $query)) {
                exit(mysqli_error($con));
            } 
            if(mysqli_num_rows($result) > 0){
                while($row = mysqli_fetch_array($result)){
                    $respuesta[] = array(
                        "idArchivo" => $row["idArchivo"],
                        "titulo" => $row["tituloPolitica"],
                        "url" => $row["urlAchivo"],
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