<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP; // Requerido para activar la depuración
    // if(isset($_POST['nombreDireccion']))
    // {
        // include Database connection file
        require 'sendMail/src/Exception.php';
        require 'sendMail/src/PHPMailer.php';
        require 'sendMail/src/SMTP.php'; 
        include("db_connection.php");
        session_start();
        $respuesta = array();
        $insertaIncidencia = $_SESSION["user"];
 
        // get values 
        $txtDepartamento = $_POST["txtDepartamento"];  
        $txtEmpleadoNombre = $_POST["txtEmpleadoNombre"];
        $txtIncidencia = $_POST["txtIncidencia"];
        switch($txtIncidencia){
            case 1:
                $incidenciaNombre = "SALIDA ANTICIPADA";
            break;
            case 2:
                $incidenciaNombre = "LLEGADA TARDE";
            break;
            case 3:
                $incidenciaNombre = "FALTA POR COMISIÓN";
            break;
            case 4:
                $incidenciaNombre = "NO CHECAR ENTRADA";
            break;
            case 5:
                $incidenciaNombre = "NO CHECAR SALIDA";
            break;
            case 6:
                $incidenciaNombre = "CAMBIO FIJO";
            break;
            case 31:
                $incidenciaNombre = "DAY OFF";
            break;
            case 32:
                $incidenciaNombre = "INCAPACIDAD";
            break;
        }
        if($txtIncidencia == 1){
            $incidenciaNombre = "SALIDA ANTICIPADA";
        }
        $txtFechaInicio = $_POST["txtFechaInicio"];
        $txtFechaFin = $_POST["txtFechaFin"];
        $txtHoraEntrada = $_POST["txtHoraEntrada"];
        $txtHoraSalida = $_POST["txtHoraSalida"];
        $txtMotivo = $_POST["txtMotivo"];
        $txtEmpleado = $_POST["txtEmpleado"];
        $nameFile = $_POST["nameFile"];

        if($txtIncidencia == "6" || $txtIncidencia == 6){
            $horarioGuardar = $_POST["horarioGuardar"];
        }

        $queryPeriodoMayor = "SELECT MAX(idPeriodo) AS periodo FROM  tc_periodosnomina";
            if (!$resultPeriodoMayor = mysqli_query($con, $queryPeriodoMayor)) {
                exit(mysqli_error($con));
            }
            if(mysqli_num_rows($resultPeriodoMayor) > 0){
                while($rowPeriodoMayor = mysqli_fetch_array($resultPeriodoMayor)){
                    $idPeriodo = $rowPeriodoMayor["periodo"];
                }
            }else{
                $idPeriodo = 1;
            }
            
  
 
        // $query = "INSERT INTO tr_incidencias VALUES('', '$txtFechaInicio', '$txtEmpleado', '$txtEmpleadoNombre', '$txtDepartamento', '', '$txtHoraEntrada', '$txtHoraSalida', '$txtMotivo', '$txtIncidencia', NOW(),'1','PRUEBAS','1', '')";
        // if (!$result = mysqli_query($con, $query)) {
        //     exit(mysqli_error($con));
        // }

        $dateInicio = date('Y-m-d', strtotime($txtFechaInicio));
        if($txtFechaFin == ""){
            $txtFechaFin = $dateInicio;
        }
        $dateFin = date('Y-m-d', strtotime($txtFechaFin));
        $diff = strtotime($dateInicio) - strtotime($dateFin);
        $diffDays = abs(round($diff / 86400));
        $folios = array();
        for($x=0; $x<=$diffDays; $x++){
            if($txtIncidencia == "6" || $txtIncidencia == 6){
                $query = "INSERT INTO tr_incidencias VALUES(DEFAULT, '$dateInicio', '$txtEmpleado', '$txtEmpleadoNombre', '', '$txtDepartamento', '$txtHoraEntrada', '$txtHoraSalida', '$horarioGuardar', '$txtIncidencia', NOW(),'$idPeriodo','$insertaIncidencia','0', '', '$nameFile')";
                if (!$result = mysqli_query($con, $query)) {
                    exit(mysqli_error($con));
                }
            }else{
                $query = "INSERT INTO tr_incidencias VALUES(DEFAULT, '$dateInicio', '$txtEmpleado', '$txtEmpleadoNombre', '', '$txtDepartamento', '$txtHoraEntrada', '$txtHoraSalida', '$txtMotivo', '$txtIncidencia', NOW(),'$idPeriodo','$insertaIncidencia','0', '', '$nameFile')";
                if (!$result = mysqli_query($con, $query)) {
                    exit(mysqli_error($con));
                }
            }
            $queryIdPase = "SELECT MAX(idPase) as folio FROM tr_incidencias";
            if (!$resultIdPase = mysqli_query($con, $queryIdPase)) {
                exit(mysqli_error($con));
            }
            while($rowIdPase = mysqli_fetch_array($resultIdPase)){
                $idPaseLoop = $rowIdPase["folio"];
            }
            array_push($folios,$idPaseLoop);
            $dateInicio = date('Y-m-d', strtotime($dateInicio. ' + 1 days'));
            
        }
        $finalPases = "";
        for($x = 0; $x < count($folios); $x++){
            $finalPases = $finalPases.",".$folios[$x];
        }
        
        $dateFin = date('Y-m-d', strtotime($txtFechaFin));
        $queryMail = "SELECT idEncargado FROM tc_empleados WHERE idEmpleado = '$txtEmpleadoNombre'";
        if (!$resultMail = mysqli_query($con, $queryMail)) {
            exit(mysqli_error($con));
        }
        if(mysqli_num_rows($resultMail) > 0){
            while($rowMail = mysqli_fetch_array($resultMail)){
                $idEncargado = $rowMail["idEncargado"];
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
                $mail->Subject = 'Registro de incidencia';
                $mail->Body    = '<b>Empleado: </b>'.$txtEmpleado.'<br>
                <b>Folio(s) incidencia: </b>'.$finalPases.'<br>
                <b>Incidencia registrada:</b>'.$incidenciaNombre.'<br>
                <b>Fecha de inicio:</b>'.$txtFechaInicio.'<br>
                <b>Fecha de fin: </b>'.$txtFechaFin.'<br>
                <b>Motivo: </b>'.$txtMotivo.'<br>
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
        //echo date('Y-m-d', strtotime($dateFin. ' + 1 days'));
    // }
?>