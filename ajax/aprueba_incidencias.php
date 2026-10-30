<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP; // Requerido para activar la depuración
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
        // --- INICIO DE BLOQUE MAIL ---
        require 'sendMail/src/Exception.php';
        require 'sendMail/src/PHPMailer.php';
        require 'sendMail/src/SMTP.php';
        
        // 1. Validar si realmente tenemos un correo de destino
        if (empty($mailEmpleado)) {
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
                $mail->addAddress($mailEmpleado, 'GRUPO EMPORIUM');     
            
                // Contenido
                $mail->isHTML(true);                                  
                $mail->Subject = 'Notificaciones incidencias';
                $mail->Body  = $mensaje; 
                $mail->AltBody = $mensaje;       
                
                $mail->send();
                
                // Si llega hasta aquí, se envió con éxito
                $respuesta["debug_correo"] = "EXITO: Enviado correctamente a " . $mailEmpleado;
                
            } catch (Exception $e) {
                // Captura errores específicos de PHPMailer
                $respuesta["debug_correo"] = "ERROR MAILER: " . $mail->ErrorInfo;
            } catch (\Throwable $e) {
                // Captura errores fatales generales de PHP (ej. fallos al instanciar clases)
                $respuesta["debug_correo"] = "ERROR PHP: " . $e->getMessage();
            }
        }
        // --- FIN DE BLOQUE MAIL ---

    print json_encode($respuesta);
?>