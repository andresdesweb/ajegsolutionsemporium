<?php
    session_start();
    if(isset($_SESSION["nombreEmpleado"]) != "" && isset($_SESSION["idEmpleado"])){
        $_SESSION["datosArea"];
        $rangoNArea = explode("|",$_SESSION["datosArea"]);
        $_SESSION["accessapp"];

        $accesos = explode("|",$_SESSION["accessapp"]);
        $nivel = "../";

?>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Recursos Humanos</title>
 
<!-- ORIGINAL -->
<script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" integrity="sha384-xrRywqdh3PHs8keKZN+8zzc5TX0GRTLCcmivcbNJWm2rs5C8PRhcEn3czEjhAO9o" crossorigin="anonymous"></script>

<script type="text/javascript" src="bootstrap-3.3.7/js/bootstrap.min.js"></script>
<link rel="stylesheet" type="text/css" href="bootstrap-3.3.7//css/bootstrap.css" />


<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.10.18/b-1.5.6/b-flash-1.5.6/b-html5-1.5.6/b-print-1.5.6/r-2.2.2/datatables.min.css"/>
 
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.10.18/b-1.5.6/b-flash-1.5.6/b-html5-1.5.6/b-print-1.5.6/r-2.2.2/datatables.min.js"></script>

<!-- ORIGINAL -->

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
 
<!-- Custom JS file -->
<script type="text/javascript" src="js/script_test.js"></script>
</head>
<body style="background-color: #547f9e;">
    <?php
    if($_SESSION["idEmpleado"] == 163 or $_SESSION["idEmpleado"] == 52 or $_SESSION["idEmpleado"] == 112){
    ?>
<!-- Content Section -->
 
<!-- /Content Section -->
 
<!-- Jquery JS file -->

 
<!-- Bootstrap JS file -->

<!-- Content Section -->
<div class="container" style="background-color: #ffffff">
<div class="row">
<div class="col-md-12" align="center">
<h2>Reporte de Nómina Plantel Norte</h2>
<div class="pull-right">

</div>
</div>
</div>
<div class="row">
<div class="col-md-12">
<div class="records_content"></div>
</div>
</div>
</div>
<!-- /Content Section -->
<!-- Modal -->
<div class="modal fade" id="add_new_record_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
<div class="modal-dialog" role="document">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
<h4 class="modal-title" id="myModalLabel">Add New Record</h4>
</div>
<div class="modal-body records_details">
   <div class="modal-body">
                <div class="form-group">
                    <label for="update_first_name">First Name</label>
                    <input type="text" id="update_first_name" placeholder="First Name" class="form-control"/>
                </div>

                <div class="form-group">
                    <label for="update_last_name">Last Name</label>
                    <input type="text" id="update_last_name" placeholder="Last Name" class="form-control"/>
                </div>

                <div class="form-group">
                    <label for="update_email">Email Address</label>
                    <input type="text" id="update_email" placeholder="Email Address" class="form-control"/>
                </div>
                 <input type="hidden" id="hidden_user_id">
            </div> 
</div>
<div class="modal-footer">
<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
<button type="button" class="btn btn-primary" onclick="addRecord()">Add Record</button>
</div>
</div>
</div>
</div>
<!-- Modal - Update User details -->
<div class="modal fade" id="update_user_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Justificar incidencia</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">

                <div class="form-group">
                    <label for="update_name">Empleado</label>
                    <input type="text" name="update_name" id="update_name" placeholder="Nombre" class="form-control" disabled="yes" />
                </div>

                <div class="form-group">
                    <label for="update_fechahora">Fecha y hora de checada</label>
                    <input type="text" id="update_fechahora" placeholder="Fecha y hora" class="form-control"/>
                </div>

                <div class="form-group">
                    <label for="update_comentarios">Motivo justificación</label>
                    <input type="text" id="update_comentarios" placeholder="Comentarios justificaciones" class="form-control"/>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="UpdateUserDetails()" >Justificar</button>
                <input type="hidden" id="hidden_user_id">
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="justifica_inasistencia" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Justificar inasistencia</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">

                <div class="form-group">
                    <label for="update_name">Empleado</label>
                    <select id="empleadojustifica" class="form-control empleados">
                        
                    </select>
                </div>

                <div class="form-group">
                    <label for="update_fechahora">Fecha inicio</label>
                    <input type="date" id="fechajustifica" class="form-control">
                </div>
                <div class="form-group">
                    <label for="update_fechahora">Fecha fin</label>
                    <input type="date" id="fechajustificafin" class="form-control">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="JustificaInasistencia()" >Justificar</button>
                <input type="hidden" id="hidden_user_id">
            </div>
        </div>
    </div>
</div>
<button class="btn btn-success" onclick="ModalInasistencias()">JUSTIFICAR INASISTENCIAS</button>

<!-- // Modal -->
                <?php
                    }
                    else{
                        echo "<h2>ACCESO NO PERMITIDO</h2>";
                        header("Location:../inicio.php");
                    }
                ?>
</body>
</html>
<?php
    }
    else{
        header("location:../index.php");
    }
?>