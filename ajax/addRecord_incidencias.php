<?php
    // if(isset($_POST['nombreDireccion']))
    // {
        // include Database connection file 
        include("db_connection.php");
        session_start();
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
                $mail->addAddress($mailPara, 'Joe User');     //Add a recipient
                $mail->addAddress($mailPara);               //Name is optional
                $mail->addReplyTo($mailPara, 'Information');
                //$mail->addCC('cc@example.com');
                //$mail->addBCC('bcc@example.com');
            
                //Attachments
                // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
                //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name
            
                //Content
                $mail->isHTML(true);                                  //Set email format to HTML
                $mail->Subject = 'Registro de incidencia';
                $mail->Body    = '<b>Empleado: </b>'.$txtEmpleado.'<br>
                <b>Folio(s) incidencia: </b>'.$finalPases.'<br>
                <b>Incidencia registrada:</b>'.$incidenciaNombre.'<br>
                <b>Fecha de inicio:</b>'.$txtFechaInicio.'<br>
                <b>Fecha de fin: </b>'.$txtFechaFin.'<br>
                <b>Motivo: </b>'.$txtMotivo.'<br>
                <a href="http://10.10.11.252/emporium/" target="_blank">Entrar al sistema</a>';
                $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
            
                $mail->send();
                echo 'Message has been sent';
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        //MAIL
        //echo date('Y-m-d', strtotime($dateFin. ' + 1 days'));
    // }
?>