<?php
        use PHPMailer\PHPMailer\PHPMailer;
        use PHPMailer\PHPMailer\Exception;

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
            //MAIL
            
            
            //Create an instance; passing `true` enables exceptions
            $mail = new PHPMailer(true);
            
            try {
                //Server settings
                $mail->isSMTP();                                            //Send using SMTP
                $mail->Host       = 'smtp.office365.com';                     //Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                $mail->Username   = 'grupo_emporium@outlook.com';                     //SMTP username
                $mail->Password   = 'rivera#2021';                               //SMTP password
                $mail->SMTPSecure = 'STARTTLS';            //Enable implicit TLS encryption
                $mail->Port       = 587;                                   //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
            
                //Recipients
                $mail->setFrom('grupo_emporium@outlook.com', 'Notificaciones Emporium');
                $mail->addAddress($mailEmpleado);     //Add a recipient
                $mail->addAddress($mailEmpleado);               //Name is optional
                $mail->addReplyTo($mailEmpleado, 'Information');
                //$mail->addCC('cc@example.com');
                //$mail->addBCC('bcc@example.com');
            
                //Attachments
                // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
                //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name
            
                //Content
                $mail->isHTML(true);                                  //Set email format to HTML
                $mail->Subject = 'Solicitud de vacaciones';
                $mail->Body    = 'Su solicitud ha sido aprobada.<br>
                <b>Folio: </b>'.$folio.'<br>
                <b>Días solicitados:</b>'.$diasSolicitados.'<br>
                <b>Fecha de registro solicitud:</b>'.$fechaRegistro.'<br>
                <b>Fecha de aceptación: </b>'.$fechaAceptacion.'<br>';
                $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
            
                $mail->send();
                //echo 'Message has been sent';
            } catch (Exception $e) {
                //echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        //MAIL
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
            //MAIL
            
            
            //Create an instance; passing `true` enables exceptions
            $mail = new PHPMailer(true);
            
            try {
                //Server settings
                $mail->isSMTP();                                            //Send using SMTP
                $mail->Host       = 'smtp.office365.com';                     //Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                $mail->Username   = 'grupo_emporium@outlook.com';                     //SMTP username
                $mail->Password   = 'rivera#2021';                               //SMTP password
                $mail->SMTPSecure = 'STARTTLS';            //Enable implicit TLS encryption
                $mail->Port       = 587;                                   //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
            
                //Recipients
                $mail->setFrom('grupo_emporium@outlook.com', 'Notificaciones Emporium');
                $mail->addAddress($mailEmpleado);     //Add a recipient
                $mail->addAddress($mailEmpleado);               //Name is optional
                $mail->addReplyTo($mailEmpleado, 'Information');
                //$mail->addCC('cc@example.com');
                //$mail->addBCC('bcc@example.com');
            
                //Attachments
                // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
                //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name
            
                //Content
                $mail->isHTML(true);                                  //Set email format to HTML
                $mail->Subject = 'Solicitud de vacaciones';
                $mail->Body    = 'Su solicitud ha sido rechazada.<br>
                <b>Folio: </b>'.$folio.'<br>
                <b>Días solicitados:</b>'.$diasSolicitados.'<br>
                <b>Fecha de registro solicitud:</b>'.$fechaRegistro.'<br>';
                $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
            
                $mail->send();
                //echo 'Message has been sent';
            } catch (Exception $e) {
                //echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        //MAIL
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
            //MAIL
            
            
            //Create an instance; passing `true` enables exceptions
            $mail = new PHPMailer(true);
            
            try {
                //Server settings
                $mail->isSMTP();                                            //Send using SMTP
                $mail->Host       = 'smtp.office365.com';                     //Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                $mail->Username   = 'grupo_emporium@outlook.com';                     //SMTP username
                $mail->Password   = 'rivera#2021';                               //SMTP password
                $mail->SMTPSecure = 'STARTTLS';            //Enable implicit TLS encryption
                $mail->Port       = 587;                                   //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
            
                //Recipients
                $mail->setFrom('grupo_emporium@outlook.com', 'Notificaciones Emporium');
                $mail->addAddress($mailEmpleado);     //Add a recipient
                $mail->addAddress($mailEmpleado);               //Name is optional
                $mail->addReplyTo($mailEmpleado, 'Information');
            
                //Content
                $mail->isHTML(true);                                  //Set email format to HTML
                $mail->Subject = 'Solicitud de vacaciones - Cancelada';
                $mail->Body    = 'Su solicitud de vacaciones aprobada ha sido cancelada y los días correspondientes han sido restituidos.<br>
                <b>Folio: </b>'.$folio.'<br>
                <b>Días solicitados:</b>'.$diasSolicitados.'<br>
                <b>Fecha de registro solicitud:</b>'.$fechaRegistro.'<br>';
                $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
            
                $mail->send();
                //echo 'Message has been sent';
            } catch (Exception $e) {
                //echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        //MAIL
        }
            

            
        
    print json_encode($respuesta);
?>