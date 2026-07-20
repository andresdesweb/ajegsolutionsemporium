	<?php
 
// Connection variables 
$host = "localhost"; // MySQL host name eg. localhost
$user = "root"; // MySQL user. eg. root ( if your on localserver)
//$user = "id18306669_admin"; // MySQL user. eg. root ( if your on localserver)
$password = "root"; // MySQL user password  (if password is not set for your root user then keep it empty )
//$password = "h3rz3l31dgutsonn.AE"; // MySQL user password  (if password is not set for your root user then keep it empty )
$database = "emporium"; // MySQL Database name
//$database = "id18306669_emporiumdb"; // MySQL Database name
 
// Connect to MySQL Database
$con = new mysqli($host, $user, $password, $database); 
// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// Forzar la zona horaria para que NOW() coincida con tu hora local
$con->query("SET time_zone = '-06:00'");
 