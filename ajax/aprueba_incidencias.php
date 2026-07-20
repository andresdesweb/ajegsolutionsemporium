<?php
        $respuesta=array();
        // include Database connection file 
        include("db_connection.php");
        $respuesta=array();
        $idPase = $_POST["idPase"];
 
        $query = "UPDATE tr_incidencias SET estado = 1 WHERE idPase = '$idPase'";
        //$query = "SELECT i.*, d.nombreDepartamento as departamento FROM tr_incidencias i INNER JOIN tc_departamento d ON i.areaEmpleado = d.idDepartamento where i.idEmpleado = 1 OR i.inserta = 1";
        if (!$result = mysqli_query($con, $query)) {
            exit(mysqli_error($con));
        }

        $queryInfoInci = "SELECT * FROM tr_incidencias WHERE idPase = '$idPase'";
        if (!$resultInfoInci = mysqli_query($con, $queryInfoInci)) {
            exit(mysqli_error($con));
        }
        if(mysqli_num_rows($resultInfoInci) > 0){
            while($row = mysqli_fetch_array($resultInfoInci)){
                $idEmpleado = $row["idEmpleado"];
                $txtEmpleado = $row["nombreEmpleado"];
                $txtFechaPase = $row["fechaPase"];
                $txtMotivo = $row["motivo"];
                $folio = $row["idPase"];
                $txtIncidencia = $row["tipoIncidencia"];
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
                }
            }
        }

        $queryCorreoEmp = "SELECT * FROM tc_empleados WHERE idEmpleado = '$idEmpleado'";
        if (!$resultCorreoEmp = mysqli_query($con, $queryCorreoEmp)) {
            exit(mysqli_error($con));
        }
        if(mysqli_num_rows($resultCorreoEmp) > 0){
            while($rowCorreoEmp = mysqli_fetch_array($resultCorreoEmp)){
                $mailEmpleado = $rowCorreoEmp["mail"];
            }
        }
        $mensaje = '<b>Su incidencia ha sido aprobada</b><br>
        <b>Empleado: </b>'.$txtEmpleado.'<br>
        <b>Folio: </b>'.$folio.'<br>
            <b>Incidencia registrada:</b>'.$incidenciaNombre.'<br>
            <b>Fecha de incidencia:</b>'.$txtFechaPase.'<br>
            <b>Motivo: </b>'.$txtMotivo.'<br>';
        //MAIL
        use PHPMailer\PHPMailer\PHPMailer;
        use PHPMailer\PHPMailer\Exception;
        
        require 'sendMail/src/Exception.php';
        require 'sendMail/src/PHPMailer.php';
        require 'sendMail/src/SMTP.php';
        
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
            $mail->addAddress($mailEmpleado, 'Grupo emporium');     //Add a recipient
            //$mail->addCC('cc@example.com');
            //$mail->addBCC('bcc@example.com');
        
            //Attachments
            // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
            //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name
        
            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Notificaciones incidencias';
            $mail->Body  = $mensaje; 
            $mail->MsgHTML = $mensaje;
            $mail->AltBody = $mensaje;       
            $mail->send();
            //echo 'Message has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    //MAIL

    print json_encode($respuesta);
?>