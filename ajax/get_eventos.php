<?php
header('Content-Type: application/json');

include("db_connection.php");

// 1. Obtener eventos de Vacaciones
$sqlVacaciones = "SELECT 
            sv.idEmpleado, 
            sv.dias, 
            e.nombre, 
            e.segundoNombre, 
            e.apellido_p, 
            e.apellido_m 
        FROM tr_solicitudvacaciones sv
        INNER JOIN tc_empleados e ON sv.idEmpleado = e.idEmpleado 
        WHERE sv.activa = 0 AND sv.dias != ''";

if (!$resultadoVacaciones = mysqli_query($con, $sqlVacaciones)) {
    $error = array('error' => mysqli_error($con));
    exit(json_encode($error));
}

$eventos = array();

while ($row = mysqli_fetch_assoc($resultadoVacaciones)) {
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

// 2. Obtener eventos de Day Off (tipoIncidencia = 31)
$sqlDayOff = "SELECT 
            i.idPase, 
            i.fechaPase, 
            i.nombreEmpleado,
            e.nombre, 
            e.segundoNombre, 
            e.apellido_p, 
            e.apellido_m 
        FROM tr_incidencias i
        LEFT JOIN tc_empleados e ON i.idEmpleado = e.idEmpleado 
        WHERE i.tipoIncidencia = 31 AND i.fechaPase IS NOT NULL";

if ($resultadoDayOff = mysqli_query($con, $sqlDayOff)) {
    while ($rowDayOff = mysqli_fetch_assoc($resultadoDayOff)) {
        if (!empty($rowDayOff['fechaPase']) && $rowDayOff['fechaPase'] != '0000-00-00') {
            if (!empty($rowDayOff['nombre']) || !empty($rowDayOff['apellido_p'])) {
                $nombreFormateado = $rowDayOff['nombre'] . ' ' . $rowDayOff['segundoNombre'] . ' ' . $rowDayOff['apellido_p'] . ' ' . $rowDayOff['apellido_m'];
                $nombreCompleto = preg_replace('/\s+/', ' ', trim($nombreFormateado));
            } else {
                $nombreCompleto = trim($rowDayOff['nombreEmpleado']);
            }

            $eventos[] = array(
                'title'  => "Day Off: " . $nombreCompleto,
                'start'  => $rowDayOff['fechaPase'],
                'allDay' => true,
                'color'  => '#2980b9'
            );
        }
    }
}

print json_encode($eventos);
?>