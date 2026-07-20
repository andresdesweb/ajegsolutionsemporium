<?php
header('Content-Type: application/json');

include("db_connection.php");

$sql = "SELECT 
            sv.idEmpleado, 
            sv.dias, 
            e.nombre, 
            e.segundoNombre, 
            e.apellido_p, 
            e.apellido_m 
        FROM tr_solicitudvacaciones sv
        INNER JOIN tc_empleados e ON sv.idEmpleado = e.idEmpleado 
        WHERE sv.activa = 0 AND sv.dias != ''";

if (!$resultado = mysqli_query($con, $sql)) {
    $error = array('error' => mysqli_error($con));
    exit(json_encode($error));
}

$eventos = array();

while ($row = mysqli_fetch_assoc($resultado)) {
    $fechas_str = $row['dias']; 

    $nombreFormateado = $row['nombre'] . ' ' . $row['segundoNombre'] . ' ' . $row['apellido_p'] . ' ' . $row['apellido_m'];
    $nombreCompleto = preg_replace('/\s+/', ' ', trim($nombreFormateado));

    $fechas_array = explode(',', $fechas_str);

    foreach ($fechas_array as $fecha) {
        $fecha = trim($fecha);
        
        if (!empty($fecha)) {
            $eventos[] = array(
                'title'  => "Vacaciones: " . $nombreCompleto,
                'start'  => $fecha,
                'allDay' => true,
                'color'  => '#e74c3c'
            );
        }
    }
}

print json_encode($eventos);
?>