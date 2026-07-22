<?php
// Archivo exclusivo para ser ejecutado por el Cron Job del Servidor (Hostinger)
// NO requiere interacción de un usuario.

// Incluir tu conexión a la base de datos (con la zona horaria corregida)
require_once("db_connection.php");

// Verificamos si la conexión existe
if ($con) {
    
    // Llamamos al procedimiento bucle que creaste en la base de datos
    // Este procedimiento recorrerá del día 1 hasta el fin del mes y asignará las vacaciones
    $sql = "CALL sp_actualizar_vacaciones_mensual()";
    
    if ($con->query($sql) === TRUE) {
        // Mensaje de éxito que quedará registrado en los logs del Cron Job de Hostinger
        echo "Exito: Vacaciones mensuales procesadas correctamente el " . date('Y-m-d H:i:s');
    } else {
        // Mensaje de error
        echo "Error ejecutando el procedimiento: " . $con->error;
    }
    
    $con->close();
} else {
    echo "Error de conexion a la base de datos.";
}
?>
