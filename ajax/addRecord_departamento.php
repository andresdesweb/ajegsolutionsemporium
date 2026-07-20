<?php
    if(isset($_POST['nombreDepartamento']))
    {
        // include Database connection file 
        include("db_connection.php");
 
        // get values 
        $nombreDepartamento = $_POST['nombreDepartamento'];

  
 
        $query = "INSERT INTO tc_departamento VALUES(DEFAULT, '$nombreDepartamento')";
        if (!$result = mysqli_query($con, $query)) {
            exit(mysqli_error($con));
        }
        echo "1 Record Added!";
    }
?>