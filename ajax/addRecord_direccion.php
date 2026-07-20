<?php
    if(isset($_POST['nombreDireccion']))
    {
        // include Database connection file 
        include("db_connection.php");
 
        // get values 
        $nombreDireccion = $_POST['nombreDireccion'];

  
 
        $query = "INSERT INTO tc_direccion VALUES(DEFAULT, '$nombreDireccion')";
        if (!$result = mysqli_query($con, $query)) {
            exit(mysqli_error($con));
        }
        echo "1 Record Added!";
    }
?>