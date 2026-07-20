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
 
<!-- Bootstrap CSS File -->
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
<script type="text/javascript" src="js/script_empleados.js"></script>
</head>
<body>
	<?php
	if($_SESSION["idEmpleado"] == 163 or $_SESSION["idEmpleado"] == 52 or $_SESSION["idEmpleado"] == 112){
	?>
    <div class="row">
        <div class="col-sm-12" align="center">
            <img src="img/uni.jpg" width="20%">
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-sm-12" align="center">
               <h2>Horarios de empleados</h2> 
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4"></div>
            <div class="col-sm-4"></div>
            <div class="col-sm-4" align="center">
                <button class="btn btn-success" onclick="formRegistro()">Agregar empleado nuevo</button>
            </div>
        </div>
    </div>
<!-- /Content Section -->
<!-- Modal -->

<div class="modal fade" id="add_new_record_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel">Nuevo Empleado</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body records_details">
                <div class="form-group">
                    <label for="ID Checador">ID Checador:</label>
                    <input type="number" id="add_numchec" name="add_numchec" placeholder="Número de alta en checador" class="form-control" />
                </div>
                <div class="form-group">
                    <label for="Nombre empleado">Nombre empleado:</label>
                    <input type="text" id="add_empleado" name="add_empleado" placeholder="Nombre completo del empleado" class="form-control"/>
                </div>
                <div class="form-group">
                    <label for="Departamento">Área:</label>
                    <select id="add_departamento" name="add_departamento" class="form-control">
                        <option value="">Selecciona el área</option>
                        <option value="1">RECTORIA</option>
                        <option value="2">VICERRECTORIA</option>
                        <option value="3">ESCUELA DE LA CREATIVIDAD</option>
                        <option value="4">DERECHO</option>
                        <option value="5">PSICOLOGIA</option>
                        <option value="6">NUTRICION</option>
                        <option value="7">GASTRONOMIA</option>
                        <option value="8">VETERINARIA</option>
                        <option value="9">ARQUITECTURA</option>
                        <option value="11">ODONTOLOGIA</option>
                        <option value="12">SISTEMAS</option>
                        <option value="13">KINESIOLOGIA</option>
                        <option value="14">MEDICINA</option>
                        <option value="15">TITULACIONES</option>
                        <option value="18">ESCUELA DE NEGOCIOS</option>
                        <option value="19">BACHILLERATO</option>
                        <option value="20">POSGRADOS</option>
                        <option value="21">EDUCACION A DISTANCIA</option>
                        <option value="22">PEDAGOGIA</option>
                        <option value="23">DIRECCION ACADEMICA</option>
                        <option value="24">PROMOCION</option>
                        <option value="25">RELACIONES PUBLICAS</option>
                        <option value="26">VIDA ESTUDIANTIL</option>
                        <option value="27">IDIOMAS</option>
                        <option value="28">DEPORTES</option>
                        <option value="29">DISEÑO GRÁFICO</option>
                        <option value="30">BIBLIOTECA</option>
                        <option value="31">RECURSOS HUMANOS</option>
                        <option value="32">CONTABILIDAD</option>
                        <option value="33">CAJAS</option>
                        <option value="34">COMUNICACION</option>
                        <option value="35">CONTROL ESCOLAR</option>
                        <option value="39">MANTENIMIENTO</option>
                        <option value="40">SISTEMA EMPRESARIAL</option>
                        <option value="42">COMPRAS</option>
                        <option value="44">DIRECCION GENERAL</option>
                        <option value="45">EMPRENDEDORES</option>
                        <option value="46">GIMNASIO</option>
                        <option value="47">SALA DE MAESTROS</option>
                        <option value="48">SERVICIOS GENERALES</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="Tipo de horario">Tipo de horario:</label>
                    <select id="add_tipohorario" name="add_tipohorario" class="form-control">
                       <option value="">Selecciona el tipo de horario</option>
                       <option value="1">Lunes a Sábado</option>
                       <option value="2">Lunes a Viernes</option> 
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="addRecord()">Agregar</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal - Update User details -->
<div class="modal fade" id="update_user_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Horario de empleado</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="id checador">ID Checador</label>
                    <input type="text" id="update_id" name="update_id" placeholder="ID en checador" class="form-control"/>
                </div>
                <div class="form-group">
                    <label for="Nombre empleado">Empleado</label>
                    <input type="text" id="update_empleado" name="update_empleado" placeholder="Empleado" class="form-control" />
                </div>
                <div class="form-group">
                    <label for="Area empleado">Área</label>
                    <!--<input type="text" id="update_departamento" name="update_departamento" placeholder="área empleado" class="form-control" />-->
                    <select id="update_departamento" name="update_departamento" class="form-control comboArea">
                        
                    </select>
                </div>

                <div class="form-group">
                    <label for="Entrada Lunes">Entrada Lunes</label>
                    <input type="time" id="update_lunesin" name="update_lunesin" placeholder="Horario de entrada Lunes" class="form-control"/>
                </div>

                <div class="form-group">
                    <label for="Salida Lunes">Salida Lunes</label>
                    <input type="time" id="update_lunesout" placeholder="Horario de salida Lunes" class="form-control"/>
                </div>

                <div class="form-group">
                    <label for="Entrada Martes">Entrada Martes</label>
                    <input type="time" id="update_martesin" placeholder="Horario de entrada Martes" class="form-control"/>
                </div>

                <div class="form-group">
                    <label for="Salida Martes">Salida Martes</label>
                    <input type="time" id="update_martesout" placeholder="Horario de salida Martes" class="form-control"/>
                </div>

                <div class="form-group">
                    <label for="Entrada Miércoles">Entrada Miércoles</label>
                    <input type="time" id="update_miercin" placeholder="Horario de entrada Miércoles" class="form-control"/>
                </div>

                <div class="form-group">
                    <label for="Salida Miércoles">Salida Miércoles</label>
                    <input type="time" id="update_miercout" placeholder="Horario de salida Miércoles" class="form-control"/>
                </div>

                <div class="form-group">
                    <label for="Entrada Jueves">Entrada Jueves</label>
                    <input type="time" id="update_juevesin" placeholder="Horario de entrada Jueves" class="form-control"/>
                </div>

                <div class="form-group">
                    <label for="Salida Jueves">Salida Jueves</label>
                    <input type="time" id="update_juevesout" placeholder="Horario de salida Jueves" class="form-control"/>
                </div>

                <div class="form-group">
                    <label for="Entrada Viernes">Entrada Viernes</label>
                    <input type="time" id="update_viernesin" placeholder="Horario de entrada Viernes" class="form-control"/>
                </div>

                <div class="form-group">
                    <label for="Salida Viernes">Salida Viernes</label>
                    <input type="time" id="update_viernesout" placeholder="Horario de salida Viernes" class="form-control"/>
                </div>

                <div class="form-group">
                    <label for="Entrada Sábado">Entrada Sábado</label>
                    <input type="time" id="update_sabadoin" placeholder="Horario de entrada Sábado" class="form-control"/>
                </div>

                <div class="form-group">
                    <label for="Salida Sábado">Salida Sábado</label>
                    <input type="time" id="update_sabadoout" placeholder="Horario de salida Sábado" class="form-control"/>
                </div>
                <div class="form-group">
                    <label for="checadas">Checadas semanales</label>
                    <!--<input type="text" id="update_checadas" placeholder="Número de checadas semanales" class="form-control"/>-->
                    <select id="update_checadas" class="form-control">
                        <option value="0">SELECCIONA TIPO DE CHECADA</option>
                        <option value="1">LUNES A SÁBADO</option>
                        <option value="2">LUNES A VIERNES</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="actualización">Fecha de última actualización</label>
                    <input type="text" id="lastupd" placeholder="Fecha actualización" disabled="yes" class="form-control"/>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="UpdateUserDetails()" >Guardar cambios</button>
                <input type="hidden" id="hidden_user_id">
            </div>
        </div>
    </div>
</div>
<div class="records_content"></div>  


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