    <?php
    error_reporting(E_ALL);
    // include Database connection file 
    include("db_connection.php");
    $con10 = new mysqli($host, $user, $password, $database);
    $con3 = new mysqli($host, $user, $password, $database);
     $con4 = new mysqli($host, $user, $password, $database);
     $con5 = new mysqli($host, $user, $password, $database);
     $con6 = new mysqli($host, $user, $password, $database);
     $con7 = new mysqli($host, $user, $password, $database);
     $con11 = new mysqli($host, $user, $password, $database);
     $coninas = new mysqli($host, $user, $password, $database);
     $coninas2 = new mysqli($host, $user, $password, $database);
     $coninas3 = new mysqli($host, $user, $password, $database);
     $coninas4 = new mysqli($host, $user, $password, $database);
     $coninas5 = new mysqli($host, $user, $password, $database);
     $coninas6 = new mysqli($host, $user, $password, $database);
     $coninas7 = new mysqli($host, $user, $password, $database);
    $data = '
    <div class="row">
        <div id="registra" class="col-sm-4" align="center">
            <button class="btn btn-success" onclick="justificacionFaltas()">Justificar Faltas</button>
        </div>
        <div id="registra" class="col-sm-4" align="center">
            <button class="btn btn-success" onclick="justificacionEntradasSalidas()">Justificar Entradas y Salidas</button>
        </div>
        <div id="registra" class="col-sm-4" align="center">
            <button class="btn btn-success" onclick="justificacionSalidas()">Justificar Salidas</button>
        </div>
         <div id="registra" class="col-sm-4" align="center">
            <button class="btn btn-success" onclick="justificacionCambiosHorarios()">Justificar Cambios de horario</button>
        </div>

        <div id="registra" class="col-sm-4" align="center">
            <button class="btn btn-success" onclick="justificacionCambiosHorariosSalidas()">Justificar Cambios de horario parte 2</button>
        </div>
        <div id="justifica" class="col-sm-4" align="center">
           <button class="btn btn-success" onclick="JustificarIncidencias()">Justificar incidencias</button> 
        </div>
        <div id="actualiza" class="col-sm-4" align="center">
           <button class="btn btn-success" onclick="ActualizarNomina()">Actualizar Nómina</button>
        </div>
    </div>
    <hr>
    <table id="example" class="table table-bordered table-striped display">
                <thead>
                        <tr>
                            <td colspan="10" align="center"> <b>BASADO EN EL REPORTE OBTENIDO DEL CHECADOR<b></td>
                        </tr>
                        <tr>
                            <th>Empleado</th>
                            <th>Número de días antes de su hora de entrada</th>
                            <th>Asistencias</th>
                            <th>Retardos</th>
                            <th>Medio día</th>
                            <th>Faltas</th>
                            <th>Checadas quincena</th> 
                            <th>Inasistencias</th>
                            <th>Días incompletos</th>
                            <th>Bono</th>
                        </tr>
                        </thead>
                        <tbody>';
    // Design initial table header 
    $query = "CALL stored_nomina(1)";
    
    /*$query = "SELECT TIME(fechahora) as checada, tipo, idempleado from tr_checadas where idempleado = 1 AND tipo = 1";*/
 
    if (!$result = mysqli_query($con, $query)) {
        exit(mysqli_error($con));
    }
    // if query results contains rows then featch those rows 
    if(mysqli_num_rows($result) > 0)
    {   $bono = 0;
        $asistencia = 0;
        $retardo = 0;

        while($row = mysqli_fetch_assoc($result))
        {
            IF($row["Asistencia"] >= 1 || $row["Retardo"] >= 1  || $row["Falta"] >= 1 || $row["mediodia"] >= 1){
                $final = "No";
            } else{
                $final = "Si";
            }
            $totalc = $row["Asistencia"] + $row["Retardo"] + $row["Falta"] + $row["Bono"] + $row["mediodia"];
            $queryQuincena = "SELECT totalchecadas,checadaslunvie FROM tc_checadasQuincenaUCA ORDER BY idquincena DESC LIMIT 1 ";
            if(!$resulQuincena = mysqli_query($con10, $queryQuincena)){
                exit(mysqli_error($con10));
            }
            if(mysqli_num_rows($resulQuincena)){
                while ( $quincenatotal = mysqli_fetch_assoc($resulQuincena)){
                    $laquincena = $quincenatotal["totalchecadas"];
                    $laquincena2 = $quincenatotal["checadaslunvie"];
                    if($row["checadas"] == 1){
                        if($totalc == $quincenatotal["totalchecadas"]){
                            $criteriochecadas = "QUINCENA COMPLETA";
                        }
                        else{
                             $criteriochecadas = "QUINCENA INCOMPLETA"; 

                            $final = "No";
                        }
                    }
                    else{
                        if($totalc == $quincenatotal["checadaslunvie"]){
                          $criteriochecadas = "QUINCENA COMPLETA";  
                        }
                        else{
                             $criteriochecadas = "QUINCENA INCOMPLETA"; 

                            $final = "No";
                        }
                    }
                }
            }
            if($row["checadas"] == 1){
                $inasistencias = $laquincena - $totalc;
                $inasistencias .= " /".$laquincena;
            }else{
                $inasistencias = $laquincena2 - $totalc;
                $inasistencias .= " /".$laquincena2;
            }

            $data .= '<tr>
                <td align="center">'.$row['nombreemp'].'</td>
                <td align="center">'.$row['Bono'].'</td>
                <td align="center">'.$row['Asistencia'].'</td>
                <td align="center">'.$row['Retardo'].'</td>
                <td align="center">'.$row['mediodia'].'</td>
                <td align="center">'.$row['Falta'].'</td>
                <td align="center">'.$criteriochecadas.'</td>
                <td align="center">'.$inasistencias.'</td>
                <td align="center">'.$row['Incompleto'].'</td>';

                if($final == "No"){
                $data .='<td align="center" bgcolor="#FF0000">'.$final.'</td>';
            }
            else{
                $data .='<td align="center" bgcolor="#28a745">'.$final.'</td>';
            }

            $data .='</tr>';

            /*$querycheck = "SELECT ADDTIME(entrada,'0:11:00') as asistencia,ADDTIME(entrada,'0:21:00') as retardo, idempleado, nombreemp, checadas, entrada, salida from tc_empleados where idempleado = 1";*/
             /*if (!$result2 = mysqli_query($con, $querycheck)) {
                exit(mysqli_error($con));
            }
           while($row2 = mysqli_fetch_assoc($result2)){
                if($row["checada"] <= $row2["entrada"]){
                    $bono++;
                    $data .= '<h2>bono<h2><br>';
                }
                elseif($row["checada"] > $row2["entrada"] && $row["checada"] < $row2["asistencia"]){
                    $data .= '<h2>Asistencia<h2><br>';
                } elseif($row["checada"] > $row2["entrada"] && $row["checada"] > $row2["asistencia"] && $row["checada"] < $row2["retardo"]){
                    $data .= "retardo<br>";
                } elseif($row["checada"] > $row2["retardo"]){
                    $data .= "Falta<br>";
                }
            }*/
        }
    }
    else
    {
        // records now found 
        $data .= '<tr><td>Records not found!</td></tr>';
    }
    /*AQUI SACAMOS A LOS EMPLEADOS QUE NO TIENEN CHECADAS EN EL REPORTE*/

    $sinChecadas = "SELECT * FROM tc_empleados";
    if(!$resultsinChecadas = mysqli_query($coninas6, $sinChecadas)){
        exit(mysqli_error($coninas6));
    }
    while ( $rowsinChecadas = mysqli_fetch_assoc($resultsinChecadas)){
        $sinChecadasDos = "SELECT * FROM tr_checadas WHERE idempleado = ".$rowsinChecadas["idempleado"]."";
        if(!$resultsinChecadasDos = mysqli_query($coninas6, $sinChecadasDos)){
            exit(mysqli_error($coninas6));
        }
        if(mysqli_num_rows($resultsinChecadasDos) < 1){
            //$data .= $rowsinChecadas["nombreemp"]." No tiene checadas <br>";
           
            $queryDiasQ2 = "SELECT * FROM tc_checadasQuincenaUCA WHERE idquincena = 35";
            if(!$resultDias2 = mysqli_query($coninas7, $queryDiasQ2)){
                exit(mysqli_error($coninas7));
            }
            while ( $diaQuincena2 = mysqli_fetch_assoc($resultDias2)){
                if($rowsinChecadas["checadas"] == 1){
                    $inasistenciasSC = $diaQuincena2["totalchecadas"]." /".$diaQuincena2["totalchecadas"];
                }else{
                    $inasistenciasSC = $diaQuincena2["checadaslunvie"]." / ".$diaQuincena2["checadaslunvie"];
                }
               $data .='<tr>
                            <td align="center">'.$rowsinChecadas["nombreemp"].'</td>
                            <td align="center">0</td>
                            <td align="center">0</td>
                            <td align="center">0</td>
                            <td align="center">0</td>
                            <td align="center">0</td>
                            <td align="center">QUINCENA INCOMPLETA</td>
                            <td align="center">'.$inasistenciasSC.'</td>
                            <td align="center">N/A<br>(Sin checadas ni incidencias)</td>
                            <td align="center">NO</td>
                        </tr>'; 
            }
        }
    }
    /*AQUI SACAMOS A LOS EMPLEADOS QUE NO TIENEN CHECADAS EN EL REPORTE*/

    $data .= '</tbody>
    </table>
    ';
    $data .= '<br><hr><br>
    
    <div id="tablachecadas">
    <div class="row">
<div class="col-md-12" align="center">
<h2>Checadas de entrada empleados</h2>
</div>
</div>';

    $data .= '
    <script>
    $(document).ready( function () {
    $("#example").DataTable({
        "language": {
      "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json",
    },
    dom: "Bfrtip",
    "lengthMenu": [[10, 25, 50, -1], ["Mostrar 10", "Mostrar 25", "Mostrar 50", "Mostrar Todo"]],
    buttons: [ {
      extend: "excel",
      title: "REPORTE NOMINA",
      filename: "Reporte de Nómina",
      text: "Descargar Excel"
    },
    "pageLength",
    ]
    });
} );
        $(document).ready( function () {
    $("#checadas").DataTable({
        "language": {
      "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json",
    },
    dom: "Bfrtip",
    "lengthMenu": [[10, 25, 50, -1], ["Mostrar 10", "Mostrar 25", "Mostrar 50", "Mostrar Todo"]],
    buttons: [ {
      extend: "excel",
      title: "REPORTE NOMINA",
      filename: "Reporte de Nómina",
      text: "Descargar Excel"
    },

     "copy",
    "pageLength"
    ]
    });
} );
    $(document).ready( function () {
    $("#salidas").DataTable({
        "language": {
      "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json",
    },
    dom: "Bfrtip",
    "lengthMenu": [[10, 25, 50, -1], ["Mostrar 10", "Mostrar 25", "Mostrar 50", "Mostrar Todo"]],
    buttons: [ {
      extend: "excel",
      title: "REPORTE NOMINA",
      filename: "Reporte de Nómina",
      text: "Descargar Excel"
    },
    "pageLength",
    ]
    });
} );
$(document).ready( function () {
    $("#inasistencias").DataTable({
        "language": {
      "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json",
    },
    dom: "Bfrtip",
    "lengthMenu": [[10, 25, 50, -1], ["Mostrar 10", "Mostrar 25", "Mostrar 50", "Mostrar Todo"]],
    buttons: [ {
      extend: "excel",
      title: "REPORTE NOMINA",
      filename: "Reporte de Inasistencias",
      text: "Descargar Excel"
    },
    "pageLength",
    ]
    });
} );
$(document).ready(function(){
  $("#mostrarchecadas").click(function(){
    $("#tablachecadas").hide();
  });

});
    </script>';
     

     $data .='<table id="checadas" class="table table-bordered table-striped display">
                <thead>
                        <tr>
                            <th>Empleado</th>
                            <th>Fecha y hora de checada</th>
                            <th>Criterio</th>
                            <th>Justificar</th>
                            <th>Comentario</th>
                        </tr>
                        </thead>
                        <tbody>';
     

    $queryInc = "CALL stored_nomina(2)";
    if(!$resulinc = mysqli_query($con3, $queryInc)){
        exit(mysqli_error($con3));
    }
    if(mysqli_num_rows($resulinc)){
        while ( $incidencia = mysqli_fetch_assoc($resulinc)) {
            $data .= '<tr>
                        <td>'.$incidencia["nombreemp"].'</td>
                        <td>'.$incidencia["fechahora"].'</td>
                        <td>'.$incidencia["STATUS"].'</td>';
                        if($incidencia["STATUS"] == "FALTA" || $incidencia["STATUS"] == "RETARDO" || $incidencia["STATUS"] == "MEDIO DIA" || $incidencia["STATUS"] == "NO FALTA"){
                        $data .= '<td align="center"><button onclick="GetUserDetails('.$incidencia['idchecada'].')" class="btn btn-success">Justificar incidencia</button></td>';
                        }
                        else{
                        $data .=' <td align="center">CORRECTO</td>';     
                        }

                        $data .='<td>'.$incidencia["comentario"].'</td></tr>'; 
            /*$queryReinicio = "UPDATE tc_diasquincenas SET bandera = 1";
           if (!$ResRei = mysqli_query($coninas4, $queryReinicio)) {
                exit(mysqli_error($coninas4));
            }*/
        }
        $data .='</tbody>
        </table>';
    }


    $data .= '<br><hr><br>
    <div class="row">
<div class="col-md-12" align="center">
<h2>Checadas de salida empleados</h2>
</div>
</div>';

    $data .='<table id="salidas" class="table table-bordered table-striped display">
                <thead>
                        <tr>
                            <th>Empleado</th>
                            <th>Fecha y hora de checada</th>
                            <th>Criterio Día</th>
                            <th>Justificar</th>
                            <th>Comentario</th>
                        </tr>
                        </thead>
                        <tbody>';
    $querysalida = "CALL stored_nomina(3)";
    if(!$resultSalida = mysqli_query($con11, $querysalida)){
        exit(mysqli_error($con11));
    }
    if(mysqli_num_rows($resultSalida)){
        while ( $salida = mysqli_fetch_assoc($resultSalida)){
            $data .= '<tr>
                            <td>'.$salida["nombreemp"].'</td>
                            <td>'.$salida["fechahora"].'</td>
                            <td>'.$salida["DIA"].'</td>';
                            if($salida["DIA"] == "INCOMPLETO"){
                                $data .= '<td align="center"><button onclick="GetUserDetails('.$salida['idchecada'].')" class="btn btn-success">Justificar incidencia</button></td>';
                            }else{
                                $data .= '<td>CORRECTO</td>';
                            }
                            $data .='<td>'.$salida["comentario"].'</td>
                        </tr>';
        }
        $data .='</tbody>
        </table>';
    }
    $data .= '<br><hr><br>
    <div class="row">
    <div class="col-md-12" align="center">
    <h2>Inasistencias</h2>
    </div>
    </div>';

        $data .='<table id="inasistencias" class="table table-bordered table-striped display">
                <thead>
                        <tr>
                            <th align="center">ID</th>
                            <th align="center">Empleado</th>
                            <th align="center">Fecha de inasistencia</th>
                        </tr>
                        </thead>
                        <tbody>';
    //QUERY PARA OBTENER IDS DE EMPLEADOS (QUE TUVIERON CHECADAS EN LA QUINCENA)
    $queryInas = "SELECT c.*, e.nombreemp, e.checadas FROM tr_checadas c inner join tc_empleados e ON e.idempleado = c.idempleado where c.idquincena = 35 group by c.idEmpleado";
    if(!$resultInas = mysqli_query($coninas, $queryInas)){
        exit(mysqli_error($coninas));
    }
    if(mysqli_num_rows($resultInas)){
        while ( $inasistencia = mysqli_fetch_assoc($resultInas)){
            //QUERY PARA OBTENER DIAS DE QUINCENA
            $queryDiasQ = "SELECT idquincena, fecha, DAYNAME(fecha) as diaQuin FROM tc_diasquincenas WHERE idquincena = 35";
            if(!$resultDias = mysqli_query($coninas2, $queryDiasQ)){
                exit(mysqli_error($coninas2));
            }
            while ( $diaQuincena = mysqli_fetch_assoc($resultDias)){
                $diaquin = $diaQuincena["fecha"];
                $empl = $inasistencia["idempleado"];
                $QueryTabla = "SELECT * FROM tr_checadas WHERE DATE(fechahora) = '".$diaQuincena["fecha"]."' AND idempleado = '".$inasistencia["idempleado"]."' AND tipochecada = 1 ";
                if(!$resultabla = mysqli_query($coninas3, $QueryTabla)){
                    exit(mysqli_error($coninas3));
                }
                if(mysqli_num_rows($resultabla) > 0){

                }
                else{
                    if($diaQuincena["diaQuin"] == "Saturday" && $inasistencia["checadas"] == 2){

                    }else{
                        $data .='<tr>
                            <td align="center">'.$inasistencia["idempleado"].'</td>
                            <td align="center">'.$inasistencia["nombreemp"].'</td>
                            <td align="center">'.$diaQuincena["fecha"].'</td>
                            </tr>
                            ';
                    }
                }

            }
        }
        

    }
    $sinChecadas = "SELECT * FROM tc_empleados";
    if(!$resultsinChecadas = mysqli_query($coninas4, $sinChecadas)){
        exit(mysqli_error($coninas4));
    }
    while ( $rowsinChecadas = mysqli_fetch_assoc($resultsinChecadas)){
        $sinChecadasDos = "SELECT * FROM tr_checadas WHERE idempleado = ".$rowsinChecadas["idempleado"]."";
        if(!$resultsinChecadasDos = mysqli_query($coninas4, $sinChecadasDos)){
            exit(mysqli_error($coninas4));
        }
        if(mysqli_num_rows($resultsinChecadasDos) < 1){
            //$data .= $rowsinChecadas["nombreemp"]." No tiene checadas <br>";
            $queryDiasQ2 = "SELECT idquincena, fecha, DAYNAME(fecha) as diaQuin FROM tc_diasquincenas WHERE idquincena = 35";
            if(!$resultDias2 = mysqli_query($coninas5, $queryDiasQ2)){
                exit(mysqli_error($coninas5));
            }
            while ( $diaQuincena2 = mysqli_fetch_assoc($resultDias2)){
               $data .='<tr>
                            <td align="center">'.$rowsinChecadas["idempleado"].'</td>
                            <td align="center">'.$rowsinChecadas["nombreemp"].'</td>
                            <td align="center">'.$diaQuincena2["fecha"].'</td>
                        </tr>'; 
            }
        }


    }
    $data .='</tbody>
        </table>';


    echo $data;
?>

