<?php
$src = $_FILES['image']['tmp_name'];
$filename = $_FILES['image']['name'];
$output_dir = "../upload/".$filename;
$titulo = $_POST["nombreToShow"];
if (move_uploaded_file($src, $output_dir )) {
    include("db_connection.php");
    $querySolicitud = "INSERT INTO tc_archivospoliticas VALUES ('','$titulo','$filename')";
    if (!$resultSolicitud = mysqli_query($con, $querySolicitud)) {
        exit(mysqli_error($con));
    }
} else{
    //echo "Error! Image upload failed! File: ".$filename;
};
//echo "<br>";
?>