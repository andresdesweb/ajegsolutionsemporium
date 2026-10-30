<?php
        use PHPMailer\PHPMailer\PHPMailer;
        use PHPMailer\PHPMailer\Exception;
        use PHPMailer\PHPMailer\SMTP; // Requerido para activar la depuración

        require 'sendMail/src/Exception.php';
        require 'sendMail/src/PHPMailer.php';
        require 'sendMail/src/SMTP.php';
        $respuesta=array();
        // include Database connection file 
        $folio = $_POST["folio"];
        $numDias = $_POST["numDias"];
        $accion = $_POST["accion"];

        include("db_connection.php");
        if($accion == "1"){
            $queryPre = "UPDATE tr_solicitudvacaciones SET activa = 0, fechaAceptacion = NOW() WHERE folioSolicitud = '$folio'";
            if (!$resultPre = mysqli_query($con, $queryPre)) {
                exit(mysqli_error($con));
            }
            $queryInfo = "SELECT idEmpleado FROM tr_solicitudvacaciones WHERE folioSolicitud = '$folio'";
            if (!$resultInfo = mysqli_query($con, $queryInfo)) {
                exit(mysqli_error($con));
            }
            while($row = mysqli_fetch_array($resultInfo)){
                $empleado = $row["idEmpleado"];
            }

            $queryMax = "SELECT MAX(YEAR(fechaActualizacion)) as maxAnio FROM tr_vacacionespendientes WHERE utilizables = 1 AND idEmpleado = '$empleado'";
            if (!$resultMax = mysqli_query($con, $queryMax)) {
                exit(mysqli_error($con));
            }
            while($rowMax = mysqli_fetch_array($resultMax)){
                $maxAnio = $rowMax["maxAnio"];
            }

            $queryDescuento = "UPDATE tr_vacacionespendientes SET diasPendientes = diasPendientes - '$numDias' WHERE YEAR(fechaActualizacion) = '$maxAnio' AND idEmpleado = '$empleado'";
            if (!$resultDescuento = mysqli_query($con, $queryDescuento)) {
                exit(mysqli_error($con));
            }

            $queryInfoSolicitud = "SELECT * FROM tr_solicitudvacaciones WHERE folioSolicitud = '$folio'";
            if (!$resultInfoSolicitud = mysqli_query($con, $queryInfoSolicitud)) {
                exit(mysqli_error($con));
            }
            if(mysqli_num_rows($resultInfoSolicitud) > 0){
                while($rowInfoSolicitud = mysqli_fetch_array($resultInfoSolicitud)){
                    $diasSolicitados = $rowInfoSolicitud["dias"];
                    $fechaAceptacion = $rowInfoSolicitud["fechaAceptacion"];
                    $fechaRegistro = $rowInfoSolicitud["fechaRegistro"];
                    $empleadoVacaciones = $rowInfoSolicitud["idEmpleado"];
                }
                
            }
            $queryCorreoEmp = "SELECT * FROM tc_empleados WHERE idEmpleado = '$empleadoVacaciones'";
            if (!$resultCorreoEmp = mysqli_query($con, $queryCorreoEmp)) {
                exit(mysqli_error($con));
            }
            if(mysqli_num_rows($resultCorreoEmp) > 0){
                while($rowCorreoEmp = mysqli_fetch_array($resultCorreoEmp)){
                    $mailEmpleado = $rowCorreoEmp["mail"];
                }
            }
            // --- INICIO DE BLOQUE MAIL ---
            if (empty($mailEmpleado)) {
                $respuesta["debug_correo"] = "FALLO: La variable de correo destino está vacía.";
            } else {
                $mail = new PHPMailer(true);
                
                try {
                    $mail->SMTPDebug = 0; 
            
                    $mail->isSMTP();                                            
                    $mail->Host       = 'smtp.gmail.com';                     
                    $mail->SMTPAuth   = true;                                   
                    $mail->Username   = 'serviciosdigitales@grupoemporium.com.mx';                     
                    $mail->Password   = 'vhsrizwvxfzzisxd'; 
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; 
                    $mail->Port       = 465;                                  
                
                    $mail->setFrom('grupo_emporium@outlook.com', 'Notificaciones Emporium');
                    $mail->addAddress($mailEmpleado, 'GRUPO EMPORIUM');     
                
                    $mail->isHTML(true);                                  
                    $mail->Subject = 'Solicitud de vacaciones';
                    $mail->Body    = 'Su solicitud ha sido aprobada.<br>
                    <b>Folio: </b>'.$folio.'<br>
                    <b>Días solicitados:</b>'.$diasSolicitados.'<br>
                    <b>Fecha de registro solicitud:</b>'.$fechaRegistro.'<br>
                    <b>Fecha de aceptación: </b>'.$fechaAceptacion.'<br>';
                
                    $mail->send();
                    
                    $respuesta["debug_correo"] = "EXITO: Enviado correctamente a " . $mailEmpleado;
                    
                } catch (Exception $e) {
                    $respuesta["debug_correo"] = "ERROR MAILER: " . $mail->ErrorInfo;
                } catch (\Throwable $e) {
                    $respuesta["debug_correo"] = "ERROR PHP: " . $e->getMessage();
                }
            }
            // --- FIN DE BLOQUE MAIL ---
        }else if($accion == "3"){
            $queryPre = "UPDATE tr_solicitudvacaciones SET activa = 3 WHERE folioSolicitud = '$folio'";
            if (!$resultPre = mysqli_query($con, $queryPre)) {
                exit(mysqli_error($con));
            }

            $queryInfoSolicitud = "SELECT * FROM tr_solicitudvacaciones WHERE folioSolicitud = '$folio'";
            if (!$resultInfoSolicitud = mysqli_query($con, $queryInfoSolicitud)) {
                exit(mysqli_error($con));
            }
            if(mysqli_num_rows($resultInfoSolicitud) > 0){
                while($rowInfoSolicitud = mysqli_fetch_array($resultInfoSolicitud)){
                    $diasSolicitados = $rowInfoSolicitud["dias"];
                    $fechaAceptacion = $rowInfoSolicitud["fechaAceptacion"];
                    $fechaRegistro = $rowInfoSolicitud["fechaRegistro"];
                    $empleadoVacaciones = $rowInfoSolicitud["idEmpleado"];
                }
                
            }
            $queryCorreoEmp = "SELECT * FROM tc_empleados WHERE idEmpleado = '$empleadoVacaciones'";
            if (!$resultCorreoEmp = mysqli_query($con, $queryCorreoEmp)) {
                exit(mysqli_error($con));
            }
            if(mysqli_num_rows($resultCorreoEmp) > 0){
                while($rowCorreoEmp = mysqli_fetch_array($resultCorreoEmp)){
                    $mailEmpleado = $rowCorreoEmp["mail"];
                }
            }
            // --- INICIO DE BLOQUE MAIL ---
            if (empty($mailEmpleado)) {
                $respuesta["debug_correo"] = "FALLO: La variable de correo destino está vacía.";
            } else {
                $mail = new PHPMailer(true);
                
                try {
                    $mail->SMTPDebug = 0; 
            
                    $mail->isSMTP();                                            
                    $mail->Host       = 'smtp.gmail.com';                     
                    $mail->SMTPAuth   = true;                                   
                    $mail->Username   = 'serviciosdigitales@grupoemporium.com.mx';                     
                    $mail->Password   = 'vhsrizwvxfzzisxd'; 
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; 
                    $mail->Port       = 465;                                  
                
                    $mail->setFrom('grupo_emporium@outlook.com', 'Notificaciones Emporium');
                    $mail->addAddress($mailEmpleado, 'GRUPO EMPORIUM');     
                
                    $mail->isHTML(true);                                  
                    $mail->Subject = 'Solicitud de vacaciones';
                    $mail->Body    = 'Su solicitud ha sido rechazada.<br>
                    <b>Folio: </b>'.$folio.'<br>
                    <b>Días solicitados:</b>'.$diasSolicitados.'<br>
                    <b>Fecha de registro solicitud:</b>'.$fechaRegistro.'<br>';
                
                    $mail->send();
                    
                    $respuesta["debug_correo"] = "EXITO: Enviado correctamente a " . $mailEmpleado;
                    
                } catch (Exception $e) {
                    $respuesta["debug_correo"] = "ERROR MAILER: " . $mail->ErrorInfo;
                } catch (\Throwable $e) {
                    $respuesta["debug_correo"] = "ERROR PHP: " . $e->getMessage();
                }
            }
            // --- FIN DE BLOQUE MAIL ---
        }else if($accion == "4"){
            $queryPre = "UPDATE tr_solicitudvacaciones SET activa = 4 WHERE folioSolicitud = '$folio'";
            if (!$resultPre = mysqli_query($con, $queryPre)) {
                exit(mysqli_error($con));
            }

            $queryInfo = "SELECT idEmpleado FROM tr_solicitudvacaciones WHERE folioSolicitud = '$folio'";
            if (!$resultInfo = mysqli_query($con, $queryInfo)) {
                exit(mysqli_error($con));
            }
            while($row = mysqli_fetch_array($resultInfo)){
                $empleado = $row["idEmpleado"];
            }

            $queryMax = "SELECT MAX(YEAR(fechaActualizacion)) as maxAnio FROM tr_vacacionespendientes WHERE utilizables = 1 AND idEmpleado = '$empleado'";
            if (!$resultMax = mysqli_query($con, $queryMax)) {
                exit(mysqli_error($con));
            }
            while($rowMax = mysqli_fetch_array($resultMax)){
                $maxAnio = $rowMax["maxAnio"];
            }

            $queryDescuento = "UPDATE tr_vacacionespendientes SET diasPendientes = diasPendientes + '$numDias' WHERE YEAR(fechaActualizacion) = '$maxAnio' AND idEmpleado = '$empleado'";
            if (!$resultDescuento = mysqli_query($con, $queryDescuento)) {
                exit(mysqli_error($con));
            }

            $queryInfoSolicitud = "SELECT * FROM tr_solicitudvacaciones WHERE folioSolicitud = '$folio'";
            if (!$resultInfoSolicitud = mysqli_query($con, $queryInfoSolicitud)) {
                exit(mysqli_error($con));
            }
            if(mysqli_num_rows($resultInfoSolicitud) > 0){
                while($rowInfoSolicitud = mysqli_fetch_array($resultInfoSolicitud)){
                    $diasSolicitados = $rowInfoSolicitud["dias"];
                    $fechaAceptacion = $rowInfoSolicitud["fechaAceptacion"];
                    $fechaRegistro = $rowInfoSolicitud["fechaRegistro"];
                    $empleadoVacaciones = $rowInfoSolicitud["idEmpleado"];
                }
                
            }
            $queryCorreoEmp = "SELECT * FROM tc_empleados WHERE idEmpleado = '$empleadoVacaciones'";
            if (!$resultCorreoEmp = mysqli_query($con, $queryCorreoEmp)) {
                exit(mysqli_error($con));
            }
            if(mysqli_num_rows($resultCorreoEmp) > 0){
                while($rowCorreoEmp = mysqli_fetch_array($resultCorreoEmp)){
                    $mailEmpleado = $rowCorreoEmp["mail"];
                }
            }
            // --- INICIO DE BLOQUE MAIL ---
            if (empty($mailEmpleado)) {
                $respuesta["debug_correo"] = "FALLO: La variable de correo destino está vacía.";
            } else {
                $mail = new PHPMailer(true);
                
                try {
                    $mail->SMTPDebug = 0; 
            
                    $mail->isSMTP();                                            
                    $mail->Host       = 'smtp.gmail.com';                     
                    $mail->SMTPAuth   = true;                                   
                    $mail->Username   = 'serviciosdigitales@grupoemporium.com.mx';                     
                    $mail->Password   = 'vhsrizwvxfzzisxd'; 
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; 
                    $mail->Port       = 465;                                  
                
                    $mail->setFrom('grupo_emporium@outlook.com', 'Notificaciones Emporium');
                    $mail->addAddress($mailEmpleado, 'GRUPO EMPORIUM');     
                
                    $mail->isHTML(true);                                  
                    $mail->Subject = 'Solicitud de vacaciones - Cancelada';
                    $mail->Body    = 'Su solicitud de vacaciones aprobada ha sido cancelada y los días correspondientes han sido restituidos.<br>
                    <b>Folio: </b>'.$folio.'<br>
                    <b>Días solicitados:</b>'.$diasSolicitados.'<br>
                    <b>Fecha de registro solicitud:</b>'.$fechaRegistro.'<br>';
                
                    $mail->send();
                    
                    $respuesta["debug_correo"] = "EXITO: Enviado correctamente a " . $mailEmpleado;
                    
                } catch (Exception $e) {
                    $respuesta["debug_correo"] = "ERROR MAILER: " . $mail->ErrorInfo;
                } catch (\Throwable $e) {
                    $respuesta["debug_correo"] = "ERROR PHP: " . $e->getMessage();
                }
            }
            // --- FIN DE BLOQUE MAIL ---
        }
            

            
        
    print json_encode($respuesta);
?>