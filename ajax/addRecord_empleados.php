<?php
    //ini_set('display_errors', 1);
    //error_reporting(E_ALL);
    if(isset($_POST['add_nombre']) && isset($_POST['add_departamento']))
    {
        // include Database connection file 
        include("db_connection.php");
        $validId = 1;
 
        // get values 
        $add_nombre = $_POST['add_nombre'];
        $add_departamento = $_POST['add_departamento'];
        $add_ingreso = $_POST["add_ingreso"];
        $add_mail = $_POST["add_mail"];
        $add_entrada = $_POST["add_entrada"];
        $add_salida = $_POST["add_salida"];
        $add_entradaDos = $_POST["add_entradaDos"];
        $add_salidaDos = $_POST["add_salidaDos"];
        $add_puesto = $_POST["add_puesto"];
        $add_checador = $_POST["add_checador"];
        $add_apellido_p = $_POST["add_apellido_p"];
        $add_apellido_m = $_POST["add_apellido_m"];
        $add_segundoNombre = $_POST["add_segundoNombre"];
        $add_direccion = $_POST["add_direccion"];
        $add_jefeDirecto = $_POST["add_jefeDirecto"];
        $add_entradaViernes = $_POST["add_entradaViernes"];
        $add_SalidaViernes = $_POST["add_SalidaViernes"];
        $add_acumulaVacs = $_POST["add_acumulaVacs"];

        $queryValidId = "SELECT * FROM tc_empleados WHERE idChecador = '$add_checador'";
        if (!$resultValidId = mysqli_query($con, $queryValidId)) {
            exit(mysqli_error($con));
        }
        if(mysqli_num_rows($resultValidId) > 0){
            $validId = 0;
        }else{
            $query = "INSERT INTO tc_empleados VALUES(DEFAULT, '$add_checador', '$add_nombre', '$add_segundoNombre', '$add_apellido_p', '$add_apellido_m', '$add_departamento', '$add_direccion', '$add_ingreso', '$add_mail', '$add_entrada', '$add_salida', '$add_entradaDos', '$add_salidaDos','$add_jefeDirecto',1,'$add_puesto','$add_entradaViernes','$add_SalidaViernes', '$add_acumulaVacs')";
            if (!$result = mysqli_query($con, $query)) {
                exit(mysqli_error($con));
            } 
        }
  
        echo $validId;
    }
?>