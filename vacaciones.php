<?php
require('fpdf.php');
setlocale(LC_ALL, "es_ES", 'Spanish_Spain', 'Spanish');
date_default_timezone_set('America/Mexico_City');
if(isset($_GET["folio"])){
    $folio = $_GET["folio"];
    include("ajax/db_connection.php");

}
$querySolicitud = "SELECT * FROM tr_solicitudvacaciones WHERE folioSolicitud = '$folio'";
if (!$result = mysqli_query($con, $querySolicitud)) {
    exit(mysqli_error($con));
}
while($row = mysqli_fetch_array($result)){
    $anioServicios = $row["aniosServicio"];
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
    $saldoActual = $row["saldoActualVacaciones"];
    $diasDisponiblesDisfrute =$row["diasDispoDisfrute"];
    $idEmpleadoAct = $row["idEmpleado"];
    $queryDiasUsados = "SELECT SUM(unicos.numDias) AS totalDias FROM (SELECT folioSolicitud, MAX(numDias) AS numDias FROM tr_solicitudvacaciones WHERE idEmpleado = '$idEmpleadoAct' AND YEAR(fechaRegistro) BETWEEN (YEAR(CURDATE()) - 2) AND YEAR(CURDATE()) GROUP BY folioSolicitud) AS unicos";
    $resultDiasUsados = mysqli_query($con, $queryDiasUsados);
    $rowDiasUsados = mysqli_fetch_array($resultDiasUsados);
    $diasUsados = $rowDiasUsados["totalDias"] ? $rowDiasUsados["totalDias"] : 0;
    $diasSolicitados = $row["numDias"];
    $periodoStr = explode(",", $row["dias"]);
    $diasDesglose = implode(", ", $periodoStr);
    $inicioPeriodo = $periodoStr[0];
    $finPeriodo = end($periodoStr);
    $inicioDateDia = date('l', strtotime($inicioPeriodo));
    $finDateDia = date('l', strtotime($finPeriodo));
    $next_date_nombre = date('l', strtotime($finPeriodo .' +1 day'));
    $finPeriodo_siguienteDia = date("Y-m-d", strtotime($finPeriodo .' +1 day'));
    if($next_date_nombre == "Saturday"){
        $next_date_nombre = date('l', strtotime($finPeriodo .' +3 day'));
        $finPeriodo_siguienteDia = date("Y-m-d", strtotime($finPeriodo .' +3 day'));
    }
    switch ($next_date_nombre) {
        case "Sunday":
            $next_date_nombre_final = "Domingo";
            break;
        case "Monday":
            $next_date_nombre_final = "Lunes";
            break;
        case "Tuesday":
            $next_date_nombre_final = "Martes";
            break;
        case "Wednesday":
            $next_date_nombre_final = "Miércoles";
            break;
        case "Thursday":
            $next_date_nombre_final = "Jueves";
            break;
        case "Friday":
            $next_date_nombre_final = "Viernes";
            break;
        case "Saturday":
            $next_date_nombre_final = "Sábado";
            break;
        
    }


    switch ($inicioDateDia) {
        case "Sunday":
            $inidioFinal = "Domingo";
            break;
        case "Monday":
            $inidioFinal = "Lunes";
            break;
        case "Tuesday":
            $inidioFinal = "Martes";
            break;
        case "Wednesday":
            $inidioFinal = "Miércoles";
            break;
        case "Thursday":
            $inidioFinal = "Jueves";
            break;
        case "Friday":
            $inidioFinal = "Viernes";
            break;
        case "Saturday":
            $inidioFinal = "Sábado";
            break;
        
    }
    switch ($finDateDia) {
        case "Sunday":
            $finFinal = "Domingo";
            break;
        case "Monday":
            $finFinal = "Lunes";
            break;
        case "Tuesday":
            $finFinal = "Martes";
            break;
        case "Wednesday":
            $finFinal = "Miércoles";
            break;
        case "Thursday":
            $finFinal = "Jueves";
            break;
        case "Friday":
            $finFinal = "Viernes";
            break;
        case "Saturday":
            $finFinal = "Sábado";
            break;
        default:
            $finFinal = "";
        
    }
}

$querySolicitud = "SELECT fs.*, em.*, d.*, (YEAR(NOW()) - YEAR(em.ingreso)) as anioServicio FROM tr_solicitudvacaciones fs INNER JOIN tc_empleados em ON fs.idEmpleado = em.idEmpleado 
INNER JOIN tc_departamento d ON em.departamento = d.idDepartamento WHERE folioSolicitud = '$folio'";
if (!$result = mysqli_query($con, $querySolicitud)) {
    exit(mysqli_error($con));
}
while($row = mysqli_fetch_array($result)){
    //información general de empleado
    $diasDisponibles = "";
    $diasTomados = "";
    $diasUsables = "";
    $fechaInicioVacaciones = "";
    $fechaFinVacaciones = "";
    $diaPresentaTrabajar = "";
    $autorizadosDescontar = "";
    $saldoActualVacaciones = "";
    $fechaIngreso = $row["ingreso"];
    $idEmpleado = $row["idEmpleado"];
    $nombre = $row["apellido_p"]." ".$row["apellido_m"]." ".$row["nombre"]." ".$row["segundoNombre"];
    $puesto = $row["puesto"];
    $area = $row["nombreDepartamento"];
    $jefeInmediato = $row["idEncargado"];
    //periodo
    


}



//Obtener jefe directo
$queryDirecto = "SELECT * FROM tc_empleados WHERE idEmpleado = '$jefeInmediato'";
if (!$resultDirecto = mysqli_query($con, $queryDirecto)) {
    exit(mysqli_error($con));
}
if(mysqli_num_rows($resultDirecto) > 0){
    while($rowDirecto = mysqli_fetch_array($resultDirecto)){
        $nombreDirecto = $rowDirecto["apellido_p"]." ".$rowDirecto["apellido_m"]." ".$rowDirecto["nombre"]." ".$rowDirecto["segundoNombre"];
    }
}else{
    $nombreDirecto = ""; 
}



//Obtener jefe directo

$pdf = new FPDF();
$pdf->AddPage();
$pdf->Image('images/ImagenEmpo.png',170,2,-300);
$pdf->SetFont('Arial','B',15);

$pdf->SetFillColor(0,0,0);
$pdf->Cell(190,7,"Vacation Request & Authorization | ",0,1,'L');
$pdf->Cell(190,7,utf8_decode("Solicitud & Autorización de Vacaciones | "),0,1,'L');
$pdf->SetTextColor(0); 

$pdf->SetFont('Arial','B',8);
$pdf->SetFillColor(0,0,0);
$pdf->Cell(40,7,"Folio: ".$folio,0,0,'L');
$pdf->setFillColor(255); 
$pdf->SetTextColor(255);
$pdf->Cell(70,7,"",0,1,'L',1);
$pdf->SetTextColor(0); 

$pdf->SetFillColor(0,0,0);
$pdf->Cell(40,7,'SBU | UEN:',0,0,'L');
$pdf->setFillColor(153,0,0); 
$pdf->SetTextColor(255);
$pdf->Cell(70,7,utf8_decode('Grupo Emporium®'),0,1,'L',1);
$pdf->SetTextColor(0);

$pdf->Cell(40,7,'Concept | concepto:',0,0,'L');
$pdf->Cell(70,7,utf8_decode('Formato Solicitud y Autorización de Vacaciones'),0,0,'L');
$pdf->Cell(30,7,utf8_decode('Version | Versión:'),0,0,'L');
$pdf->Cell(50,7,'1.1',0,1,'L');

// $pdf->setFillColor(230,230,230); 
// $pdf->Cell(0,10,"hola",0,1,'L',1); //your cell

$pdf->setFillColor(230,230,230); 
$pdf->Cell(40,7,'Responsible | Responsable:',0,0,'L');
$pdf->Cell(70,7,utf8_decode('Recursos Humanos | Administración'),0,0,'L');
$pdf->Cell(30,7,'Date | Fecha:',0,0,'L');
$pdf->Cell(60,7,date("Y-m-d"),0,1,'L');

$pdf->setFillColor(0,0,0); 
$pdf->SetTextColor(255);
$pdf->Cell(10,8,'I.',0,0,'C',1);
$pdf->setFillColor(128,128,135);
$pdf->SetTextColor(255);
$pdf->Cell(180,8,utf8_decode('General Employee Information | Información General del Empleado'),0,1,'L',1);
$pdf->SetTextColor(0);

$pdf->SetTextColor(255);
$pdf->Cell(10,8,'I.01',0,0,'C',1);
$pdf->SetTextColor(0);
$pdf->Cell(60,7,'Nombre del Colaborador	',1,0,'L');
$pdf->Cell(120,7,utf8_decode($nombre),1,1,'L');

$pdf->SetTextColor(255);
$pdf->Cell(10,8,'I.02',0,0,'C',1);
$pdf->SetTextColor(0);
$pdf->Cell(60,7,'Puesto',1,0,'L');
$pdf->Cell(120,7,utf8_decode($puesto),1,1,'L');

$pdf->SetTextColor(255);
$pdf->Cell(10,8,'I.03',0,0,'C',1);
$pdf->SetTextColor(0);
$pdf->Cell(60,7,utf8_decode('Área'),1,0,'L');
$pdf->Cell(120,7,utf8_decode($area),1,1,'L');

$pdf->SetTextColor(255);
$pdf->Cell(10,8,'I.04',0,0,'C',1);
$pdf->SetTextColor(0);
$pdf->Cell(60,7,'Jefe Inmediato Superior',1,0,'L');
$pdf->Cell(120,7,utf8_decode($nombreDirecto),1,1,'L');
$pdf->ln();

$pdf->setFillColor(0,0,0);
$pdf->SetTextColor(255);
$pdf->SetTextColor(255);
$pdf->Cell(10,10,'II.',0,0,'C',1);
$pdf->SetTextColor(0);
$pdf->setFillColor(128,128,135);
$pdf->SetTextColor(255);
$pdf->Cell(180,10,utf8_decode('General Employee Information | Información General del Empleado'),0,1,'L',1);
$pdf->SetTextColor(0);

$pdf->SetTextColor(255);
$pdf->Cell(10,8,'II.01',0,0,'C',1);
$pdf->SetTextColor(0);
$pdf->Cell(30,7,utf8_decode('Días Solicitados'),1,0,'L');
$pdf->Cell(30,7,$diasSolicitados,1,0,'L');
$pdf->Cell(55,7,'Periodo solicitado',1,0,'L');
if(count($periodoStr) == 1){
    $pdf->Cell(35,7,$inicioPeriodo,1,0,'C');
}else{
    $pdf->Cell(35,7,$inicioPeriodo." / ".$finPeriodo,1,0,'C');
}

$pdf->Cell(30,7,utf8_decode('Sólo días hábiles'),1,1,'L');

$pdf->SetTextColor(255);
//$pdf->Cell(10,8,'II.02',0,0,'C',1);
$pdf->SetTextColor(0);
//$pdf->Cell(30,7,'Con goce de sueldo',1,0,'L');
//$pdf->Cell(30,7,'1',1,0,'L');
//$pdf->Cell(60,7,'A cuenta de vacaciones | Sin goce de sueldo',1,0,'L');
//$pdf->Cell(30,7,'0',1,0,'L');
//$pdf->Cell(30,7,'Sin goce',1,1,'L');
$pdf->ln();

$pdf->setFillColor(0,0,0);
$pdf->SetTextColor(255);
$pdf->Cell(10,10,'III.',0,0,'C',1);
$pdf->setFillColor(128,128,135);
$pdf->Cell(180,10,'Human Resources | Recursos Humanos',0,1,'L',1);
$pdf->SetTextColor(0);

$pdf->SetTextColor(255);
$pdf->Cell(10,8,'III.01',0,0,'C',1);
$pdf->SetTextColor(0);
$pdf->Cell(60,7,'Fecha de Ingreso del Empleado',1,0,'L');
$pdf->Cell(20,7,$fechaIngreso,1,0,'L');
$pdf->Cell(45,7,'Fecha inicial Vacaciones',1,0,'L');
$pdf->Cell(30,7,$inicioPeriodo,1,0,'L');
$pdf->Cell(25,7,utf8_decode($inidioFinal),1,1,'L');

$pdf->SetTextColor(255);
$pdf->Cell(10,8,'III.02',0,0,'C',1);
$pdf->SetTextColor(0);
$pdf->Cell(60,7,utf8_decode('Años de Servicio'),1,0,'L');
$pdf->Cell(20,7,$anioServicios,1,0,'L');
$pdf->Cell(45,7,'Fecha final Vacaciones',1,0,'L');
$pdf->Cell(30,7,$finPeriodo,1,0,'L');
$pdf->Cell(25,7,$finFinal,1,1,'L');

$pdf->SetTextColor(255);
$pdf->Cell(10,8,'III.03',0,0,'C',1);
$pdf->SetTextColor(0);
$pdf->Cell(60,7,utf8_decode('Días de Vacaciones que Corresponden'),1,0,'L');
$pdf->Cell(20,7,$correspondientes,1,0,'L');
$pdf->Cell(45,7,utf8_decode('Día que se presenta a trabajar'),1,0,'L');
$pdf->Cell(30,7,$finPeriodo_siguienteDia,1,0,'L');
$pdf->Cell(25,7,utf8_decode($next_date_nombre_final),1,1,'L');

$pdf->SetTextColor(255);
$pdf->Cell(10,8,'III.04',0,0,'C',1);
$pdf->SetTextColor(0);
$pdf->Cell(60,7,utf8_decode('Dias Disfrutados anteriormente'),1,0,'L');
$pdf->Cell(20,7,$diasUsados,1,0,'L');
$pdf->Cell(45,7,utf8_decode('Días Autorizados a Descontar'),1,0,'L');
$pdf->Cell(30,7,$diasSolicitados,1,0,'L');
$pdf->Cell(25,7,'Total del periodo',1,1,'L');

$pdf->SetTextColor(255);
$pdf->Cell(10,8,'III.05',0,0,'C',1);
$pdf->SetTextColor(0);
$pdf->Cell(60,7,utf8_decode('Dias Disponibles para Disfrute'),1,0,'L');
$pdf->Cell(20,7,$diasDisponiblesDisfrute,1,0,'L');
$pdf->Cell(45,7,utf8_decode('Saldo Actual Vacaciones'),1,0,'L');
$pdf->Cell(30,7,$diasDisponiblesDisfrute,1,0,'L');
$pdf->Cell(25,7,'',1,1,'L');
$pdf->ln();

$pdf->setFillColor(0,0,0);
$pdf->SetTextColor(255);
$pdf->Cell(10,10,'IV.',0,0,'L',1);
$pdf->setFillColor(128,128,135);
$pdf->Cell(180,10,'Comments | Comentarios',0,1,'L',1);
$pdf->SetTextColor(0);
$pdf->SetTextColor(255);
$pdf->Cell(10,8,'IV.01',0,0,'C',1);
$pdf->SetTextColor(0);
$pdf->Cell(180,8,utf8_decode("Desglose días: " . $diasDesglose),1,1,'L');
$pdf->SetTextColor(0);
$pdf->ln();

$pdf->setFillColor(0,0,0);
$pdf->SetTextColor(255);
$pdf->Cell(10,10,'V.',0,0,'L',1);
$pdf->setFillColor(128,128,135);
$pdf->Cell(180,10,utf8_decode('Authorization | Autorización'),0,1,'L',1);
$pdf->SetTextColor(0);
$pdf->SetTextColor(255);
$pdf->Cell(10,8,'V.01',0,0,'C',1);
$pdf->SetTextColor(0);
$pdf->SetFont('Arial','B',7);
$pdf->Cell(180,7,'Por el presente expreso mi conformidad de solicitar y gozar mis vacaciones de acuerdo a lo que se establece en el articulo 76 de Ley Federal de Trabajo.						
',1,1,'L');
$pdf->SetFont('Arial','B',8);
$pdf->SetTextColor(0);
$pdf->ln();

$pdf->setFillColor(0,0,0);
$pdf->SetTextColor(255);
$pdf->Cell(10,10,'VI.',0,0,'L',1);
$pdf->setFillColor(128,128,135);
$pdf->Cell(180,10,'Signatures | Firmas',0,1,'L',1);
$pdf->SetTextColor(0);

$pdf->SetTextColor(255);
$pdf->Cell(10,8,'V.01',0,0,'C',1);
$pdf->SetTextColor(0);
$pdf->Cell(60,7,'Conformidad del Solicitante',1,0,'L');
$pdf->Cell(100,7,'',1,0,'L');
$pdf->Cell(20,7,date("Y-m-d"),1,1,'L');

$pdf->SetTextColor(255);
$pdf->Cell(10,8,'V.01',0,0,'C',1);
$pdf->SetTextColor(0);
$pdf->Cell(60,7,utf8_decode('Autorización del Jefe Inmediato Superior'),1,0,'L');
$pdf->Cell(100,7,'',1,0,'L');
$pdf->Cell(20,7,date("Y-m-d"),1,1,'L');

$pdf->SetTextColor(255);
$pdf->Cell(10,7,'V.01',0,0,'C',1);
$pdf->SetTextColor(0);
$pdf->Cell(60,7,utf8_decode('Administración | Recursos Humanos'),1,0,'L');
$pdf->Cell(100,7,'',1,0,'L');
$pdf->Cell(20,7,date("Y-m-d"),1,1,'L');

$pdf->SetTextColor(255);
$pdf->Cell(10,8,'V.01',0,0,'C',1);
$pdf->SetTextColor(0);
$pdf->Cell(60,7,'Presidencia',1,0,'L');
$pdf->Cell(100,7,'',1,0,'L');
$pdf->Cell(20,7,date("Y-m-d"),1,1,'L');

       





$pdf->Output();
?>