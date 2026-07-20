<?php
    if(isset($_POST['add_nombre']) && isset($_POST['add_departamento']))
    {
        // include Database connection file 
        include("db_connection.php");

        $libre;
 
        // get values 
        $idChecador = $_POST['idChecador'];

  
 
        $query = "SELECT * FROM tc_empleados WHERE idChecador = '$idChecador'')";
        if (!$result = mysqli_query($con, $query)) {
            exit(mysqli_error($con));
        }
        if(mysqli_num_rows($result) > 0){
            $libre = false;
        }else{
            $libre = true;
        }
        echo $libre;
    }
?>