<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP; // Requerido para activar la depuración

$respuesta = array();

if(isset($_POST["cantidad"]) && isset($_POST["dias"])){
    $cantidad = $_POST["cantidad"];
    $dias = $_POST["dias"];
}

session_start();
$idEmpleado = $_SESSION["idEmp"];
$accion = $_POST["accion"];

require 'sendMail/src/Exception.php';
require 'sendMail/src/PHPMailer.php';
require 'sendMail/src/SMTP.php';

include("db_connection.php");

if($accion == 1){
    $querySolicitud = "SELECT TIMESTAMPDIFF(YEAR, ingreso, NOW()) as anioServicio FROM tc_empleados WHERE idEmpleado = '$idEmpleado'";
    if (!$resultSolicitud = mysqli_query($con, $querySolicitud)) {
        exit(mysqli_error($con));
    }
    while($row = mysqli_fetch_array($resultSolicitud)){
        $anioServicios = $row["anioServicio"];
        if($anioServicios == 1){
            $correspondientes = 12;
        }else if($anioServicios == 2){
            $correspondientes = 14;
        }else if($anioServicios == 3){
            $correspondientes = 16;
        }else if($anioServicios == 4){
            $correspondientes = 18;
        }else if($anioServicios == 5){
            $correspondientes = 20;
        }else if($anioServicios >= 6 || $anioServicios <= 10){
            $correspondientes = 22;
        }else if($anioServicios >= 11 || $anioServicios <= 15){
            $correspondientes = 24;
        }else if($anioServicios >= 16 || $anioServicios <= 20){
            $correspondientes = 26;
        }else if($anioServicios >= 21 || $anioServicios <= 25){
            $correspondientes = 28;
        }else if($anioServicios >= 26 || $anioServicios <= 30){
            $correspondientes = 30;
        }
    }
    
    // Obtener días disfrutados
    $queryUsados = "SELECT *, SUM(numDias) as disUsados FROM  tr_solicitudvacaciones WHERE idEmpleado = '$idEmpleado' AND activa = 0";
    if (!$resultUsados = mysqli_query($con, $queryUsados)) {
        exit(mysqli_error($con));
    }

    if(mysqli_num_rows($resultUsados) > 0){
        while($rowUsados = mysqli_fetch_array($resultUsados)){
            $diasUsados = $rowUsados["disUsados"];
        }
    }else{
        $diasUsados = 0;
    }

    // Obtener días disponibles
    $queryDias = "SELECT *, SUM(diasPendientes) as disponibles FROM tr_vacacionespendientes WHERE idEmpleado = '$idEmpleado' AND utilizables = 1";
    if (!$resultDias = mysqli_query($con, $queryDias)) {
        exit(mysqli_error($con));
    }
    while($rowDias = mysqli_fetch_array($resultDias)){
        if(isset($rowDias["disponibles"])){
            $diasCorresponden = $rowDias["disponibles"];
            $diasDisponiblesDisfrute =$rowDias["disponibles"];
            $saldoActual = $rowDias["disponibles"];
        }else{
            $diasCorresponden = 0;
            $diasDisponiblesDisfrute =0;
            $saldoActual = 0;
        }
    }
    
    // Inserción de solicitud
    $queryPre = "INSERT INTO tr_solicitudvacaciones VALUES ('', '$idEmpleado', '$cantidad', '$dias', '', NOW(), '', 1,'$anioServicios', '$diasUsados','$diasDisponiblesDisfrute','$saldoActual','$correspondientes')";
    if (!$resultPre = mysqli_query($con, $queryPre)) {
        exit(mysqli_error($con));
    }
    
    $queryMail = "SELECT idEncargado, CONCAT(apellido_p, ' ', apellido_m, ' ', nombre, ' ', segundoNombre) as nombreEmpleado FROM tc_empleados WHERE idEmpleado = '$idEmpleado'";
    if (!$resultMail = mysqli_query($con, $queryMail)) {
        exit(mysqli_error($con));
    }
    if(mysqli_num_rows($resultMail) > 0){
        while($rowMail = mysqli_fetch_array($resultMail)){
            $idEncargado = $rowMail["idEncargado"];
            $nombreEmpleadoMail = $rowMail["nombreEmpleado"];
        }
    }else{
        $idEncargado = "";
    }

    $queryMailFinal = "SELECT mail FROM tc_empleados WHERE idEmpleado = '$idEncargado'";
    if (!$resultMailFinal = mysqli_query($con, $queryMailFinal)) {
        exit(mysqli_error($con));
    }
    if(mysqli_num_rows($resultMailFinal) > 0){
        while($rowMailFinal = mysqli_fetch_array($resultMailFinal)){
            $mailPara = $rowMailFinal["mail"];
        }
    }else{
        $mailPara = "";
    }
    
    // --- INICIO DE BLOQUE MAIL ---
    // 1. Validar si realmente tenemos un correo de destino
    if (empty($mailPara)) {
        $respuesta["debug_correo"] = "FALLO: La variable de correo destino está vacía.";
    } else {
        $mail = new PHPMailer(true);
        
        try {
            // Desactivamos el debug del servidor para que no rompa el formato JSON
            $mail->SMTPDebug = 0; 
    
            // Configuración del servidor
            $mail->isSMTP();                                            
            $mail->Host       = 'smtp.gmail.com';                     
            $mail->SMTPAuth   = true;                                   
            $mail->Username   = 'serviciosdigitales@grupoemporium.com.mx';                     
            $mail->Password   = 'vhsrizwvxfzzisxd'; 
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; 
            $mail->Port       = 465;                                  
        
            // Destinatarios
            $mail->setFrom('grupo_emporium@outlook.com', 'Notificaciones Emporium');
            $mail->addAddress($mailPara, 'GRUPO EMPORIUM');     
        
            // Contenido
            $mail->isHTML(true);                                  
            $mail->Subject = 'Solicitud de vacaciones';
            $mail->Body    = '<b>Empleado: </b>'.$nombreEmpleadoMail.'<br>
            <b>Días solicitados: </b>'.$dias.'<br>
            <a href="https://ajegsolutions.com/emporium/" target="_blank">Entrar al sistema</a>';
        
            $mail->send();
            
            // Si llega hasta aquí, se envió con éxito
            $respuesta["debug_correo"] = "EXITO: Enviado correctamente a " . $mailPara;
            
        } catch (Exception $e) {
            // Captura errores específicos de PHPMailer
            $respuesta["debug_correo"] = "ERROR MAILER: " . $mail->ErrorInfo;
        } catch (\Throwable $e) {
            // Captura errores fatales generales de PHP (ej. fallos al instanciar clases)
            $respuesta["debug_correo"] = "ERROR PHP: " . $e->getMessage();
        }
    }
    // --- FIN DE BLOQUE MAIL ---

} else {
    if(isset($_POST["permiso"])){
        $permiso = $_POST["permiso"];
    }
    else{
        $permiso = 1;
    }
    if($permiso == 2){
        $queryPre = "SELECT sv.*, CONCAT(em.apellido_p, ' ', em.apellido_m, ' ', em.nombre, ' ', em.segundoNombre) as nombreEmp FROM tr_solicitudvacaciones sv INNER JOIN tc_empleados em ON em.idEmpleado = sv.idEmpleado WHERE em.idEncargado = '$idEmpleado' OR sv.idEmpleado = '$idEmpleado'"; 
    }else if($permiso == 1){
        $queryPre = "SELECT sv.*, CONCAT(em.apellido_p, ' ', em.apellido_m, ' ', em.nombre, ' ', em.segundoNombre) as nombreEmp FROM tr_solicitudvacaciones sv INNER JOIN tc_empleados em ON em.idEmpleado = sv.idEmpleado WHERE sv.idEmpleado = '$idEmpleado'";
    }else{
        $queryPre = "SELECT sv.*, CONCAT(em.apellido_p, ' ', em.apellido_m, ' ', em.nombre, ' ', em.segundoNombre) as nombreEmp FROM tr_solicitudvacaciones sv INNER JOIN tc_empleados em ON em.idEmpleado = sv.idEmpleado";
    }
    if (!$resultPre = mysqli_query($con, $queryPre)) {
        exit(mysqli_error($con));
    }
    while($row = mysqli_fetch_array($resultPre)){
        $respuesta[] = array(
            "numDias" => $row["numDias"],
            "nameDias" => $row["dias"],
            "fechaRegistro" => $row["fechaRegistro"],
            "activa" => $row["activa"],
            "fechaAceptacion" => $row["fechaAceptacion"],
            "folio" => $row["folioSolicitud"],
            "empleado" => $row["idEmpleado"],
            "nombreEmp" => $row["nombreEmp"]
        );
    }
}

// Retornar JSON limpio
print json_encode($respuesta);
?>