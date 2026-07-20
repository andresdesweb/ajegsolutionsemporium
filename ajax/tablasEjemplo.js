function usuarioActualSistema(){
    jQuery.ajax({
        url: "ajax/checkEmpleadoSesion.php",
        method: 'POST',
        async: false,
        dataType: 'JSON',
        data:{
        },
        success: function (data) {
            $("#usaSistema").text(data[0].Nombre)
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            window.location.href = 'index.html';
            resultado = false;
        }
    });
}
function checkSession(token){
    var resultado;
    if (token != undefined && token != ''){
        jQuery.ajax({
            url: "ajax/checkSession.php",
            method: 'POST',
            async: false,
            dataType: 'JSON',
            data:{
                token:token
            },
            success: function (data) {
                resultado = true;
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                window.location.href = 'index.html';
                resultado = false;
            }
        });
    }else{
        window.location.href = 'index.html';
    }
    
    return resultado;
}
function formRegistro(){
    $("#add_new_record_modal").modal("show");
}
// Add Record
function addRecord() {
    // get values
    var contador = 0;
    var add_nombre = $("#txtNombre").val();
    var add_departamento = $("#txtDepartamento").val();
    var add_ingreso = $("#txtIngreso").val();
    var add_mail = $("#txtMail").val();
    var add_entrada = $("#txtEntrada").val();
    var add_salida = $("#txtSalida").val();
    var add_entradaDos = $("#txtEntradaDos").val();
    var add_salidaDos = $("#txtSalidaDos").val();
    var add_puesto = $("#txtPuesto").val();
    var add_checador = $("#txtIdChecador").val();
    var add_apellido_p = $("#txtApellido_p").val();
    var add_apellido_m = $("#txtApellido_m").val();
    var add_segundoNombre = $("#txtSegundoNombre").val();
    var add_direccion = $("#txtDireccion").val();
    var add_jefeDirecto = $("#txtJefeDirecto").val();
    var add_entradaViernes =$("#entradaViernes").val();
    var add_SalidaViernes =$("#salidaViernes").val();
    var add_acumulaVacs = $("#txtAcumulaVacs").val();
    
    if(add_nombre == ""){
        contador++;
        //validación mensaje
        $("#txtNombre").addClass("error-msg-input")
    }
    if(add_apellido_p == ""){
        contador++;
        //validación mensaje
        $("#txtApellido_p").addClass("error-msg-input")
    }
    if(add_ingreso == ""){
        contador++;
        //validación mensaje
        $("#txtIngreso").addClass("error-msg-input")
    }
    if(add_mail == ""){
        contador++;
        //validación mensaje
        $("#txtMail").addClass("error-msg-input")
    }
    if(add_puesto == ""){
        contador++;
        //validación mensaje
        $("#txtPuesto").addClass("error-msg-input")
    }
    if(add_checador == ""){
        contador++;
        //validación mensaje
        $("#txtIdChecador").addClass("error-msg-input")
    }

    // Add record
    if(contador == 0){
        $.post("ajax/addRecord_empleados.php", {
            add_nombre:add_nombre,        
            add_departamento:add_departamento,
            add_ingreso:add_ingreso,
            add_mail:add_mail,
            add_entrada:add_entrada,
            add_salida:add_salida,
            add_entradaDos:add_entradaDos,
            add_salidaDos:add_salidaDos,
            add_puesto:add_puesto,
            add_checador,
            add_apellido_p,
            add_apellido_m,
            add_segundoNombre,
            add_direccion,
            add_jefeDirecto:add_jefeDirecto,
            add_entradaViernes:add_entradaViernes,
            add_SalidaViernes:add_SalidaViernes,
            add_acumulaVacs:add_acumulaVacs
        }, function (data, status) {
            if(parseInt(data) == 0){
                swal("Este ID de checador ya está registrado", "", "info");
            }else{
                swal("Empleado agregado correctamente", "", "success");
                //$('#my_table').DataTable().clear();
                $("#empleadorForm").trigger("reset");
                $("#exampleModal").modal("hide");
                readRecords(1)
                readRecordsNoActivos(1)
                $('#example').DataTable({
                    fixedColumns: true,
                    "scrollX": true
                });
            }
            
            
                
        });
    }else{
        swal("Por favor llene los campos requeridos", "", "info");
        $( ".error-msg-input" ).change(function() {
            $(this).removeClass("error-msg-input")
          });
    }
    
    
}

function checkIdChecador(idChecador){
    var idLibre;
    $.post("ajax/check_idChecador.php", {
        idChecador:idChecador
    }, function (data, status) {
        
        idLibre = data;
            
    });
    return idLibre;
}

// READ records
function readRecords(tipoVista) {
    var resultado;
        jQuery.ajax({
            url: "ajax/readRecords_empleados.php",
            method: 'POST',
            async: false,
            dataType: 'JSON',
            data:{
            },
            success: function (data) {
                if(tipoVista == 1){
                    $(".tablaEmpleados").children().remove()
                    $(".tablaEmpleados").append(
                        `
                        <table id="example" class="display" style="width:100%">
                            <thead>
                                <tr>
                                    <th># checador</th>
                                    <th>Nombre empleado</th>
                                    <th>Departamento</th>
                                    <th>Dirección</th>
                                    <th>Puesto</th>
                                    <th>Estatus</th>
                                    <th>Acumula vacaciones</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="dataEmpleados">
                            </tbody>
                        </table>
                        `
                    );
                    data.forEach(empleado => {
                        $(".dataEmpleados").append(
                            `<tr>
                                <td class="idEmpleado">${empleado.idChecador}</td>
                                <td>${empleado.apellido_p} ${empleado.apellido_m} ${empleado.Nombre} ${empleado.SegundoNombre}</td>
                                <td>${empleado.nombreDepartamento}</td>
                                <td>${empleado.nombreDireccion}</td>
                                <td>${empleado.Puesto}</td>
                                <td>${empleado.activo == 1 ? "ACTIVO":"NO ACTIVO"}</td>
                                <td>${empleado.acumula == 1 ? "SI":"NO"}</td>
                                <td>
                                    
                                    <button class=" btn-success editar" data-bs-toggle="modal" data-bs-target="#exampleModal" onclick="HacerAlgo(${empleado.idEmpleado},2)"><i class="fa-solid fa-user-pen"></i></button>
                                    <button class=" btn-success borrar" onclick="deleteRecord(${empleado.idEmpleado})"><i class="fa-solid fa-trash"></i></button>
                                </td>
                             </tr>`
                        )
                    }
    
                    );
                    /*var empleadosData = [];
                    data.forEach(empleado => {
                        empleadosData.push([empleado.idEmpleado,empleado.Nombre,empleado.Ingreso])
                    }
    
                    )
                    var dataSet = empleadosData;
                    $('#example').DataTable( {
                        data: dataSet,
                        columns: [
                            { title: "idEmpleado" },
                            { title: "Nombre" },
                            { title: "Ingreso" },
                        ]
                    } );*/
                }else if(tipoVista == 2){
                    $("#txtEmpleadoNombre").append(
                        `<option value="">Seleccione empleado</option>`
                    )
                    data.forEach(empleado => {
                        
                        $("#txtEmpleadoNombre").append(
                            `<option value="${empleado.idEmpleado}">${empleado.apellido_p} ${empleado.apellido_m} ${empleado.Nombre} ${empleado.SegundoNombre}</option>`
                        )
                    }
    
                    );
                }else if(tipoVista == 3){
                    $("#txtEmpleadoNombre").append(
                        `<option value="">Seleccione empleado</option>`
                    )
                    data.forEach(empleado => {
                        
                        $("#txtEmpleadoNombre").append(
                            `<option value="${empleado.idEmpleado},${empleado.idChecador}">${empleado.apellido_p} ${empleado.apellido_m} ${empleado.Nombre} ${empleado.SegundoNombre}</option>`
                        )
                    }
    
                    );
                }
                
                
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                console.log("not ok")
            }
        });
        return resultado;
}


// READ records
function readRecordsNoActivos(tipoVista) {
    var resultado;
        jQuery.ajax({
            url: "ajax/readRecordsNoActivos_empleados.php",
            method: 'POST',
            async: false,
            dataType: 'JSON',
            data:{
            },
            success: function (data) {
                if(tipoVista == 1){
                    $(".tablaEmpleadosNoActivos").children().remove()
                    $(".tablaEmpleadosNoActivos").append(
                        `
                        <table id="exampleNoActivos" class="display" style="width:100%">
                            <thead>
                                <tr>
                                    <th># checador</th>
                                    <th>Nombre empleado</th>
                                    <th>Departamento</th>
                                    <th>Dirección</th>
                                    <th>Puesto</th>
                                    <th>Estatus</th>
                                    <th>Acumula vacaciones</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="dataEmpleadosNoActivos">
                            </tbody>
                        </table>
                        `
                    );
                    data.forEach(empleado => {
                        $(".dataEmpleadosNoActivos").append(
                            `<tr>
                                <td class="idEmpleado">${empleado.idChecador}</td>
                                <td>${empleado.apellido_p} ${empleado.apellido_m} ${empleado.Nombre} ${empleado.SegundoNombre}</td>
                                <td>${empleado.nombreDepartamento}</td>
                                <td>${empleado.nombreDireccion}</td>
                                <td>${empleado.Puesto}</td>
                                <td>${empleado.activo == 1 ? "ACTIVO":"NO ACTIVO"}</td>
                                <td>${empleado.acumula == 1 ? "SI":"NO"}</td>
                                <td>
                                    
                                    <button class=" btn-success editar" data-bs-toggle="modal" data-bs-target="#exampleModal" onclick="HacerAlgo(${empleado.idEmpleado},2)"><i class="fa-solid fa-user-pen"></i></button>
                                    <button class=" btn-success borrar" onclick="activateRecord(${empleado.idEmpleado})"><i class="fa-solid fa-user-check"></i></button>
                                </td>
                             </tr>`
                        )
                    }
    
                    );
                    /*var empleadosData = [];
                    data.forEach(empleado => {
                        empleadosData.push([empleado.idEmpleado,empleado.Nombre,empleado.Ingreso])
                    }
    
                    )
                    var dataSet = empleadosData;
                    $('#example').DataTable( {
                        data: dataSet,
                        columns: [
                            { title: "idEmpleado" },
                            { title: "Nombre" },
                            { title: "Ingreso" },
                        ]
                    } );*/
                }else if(tipoVista == 2){
                    $("#txtEmpleadoNombre").append(
                        `<option value="">Seleccione empleado</option>`
                    )
                    data.forEach(empleado => {
                        
                        $("#txtEmpleadoNombre").append(
                            `<option value="${empleado.idEmpleado}">${empleado.apellido_p} ${empleado.apellido_m} ${empleado.Nombre} ${empleado.SegundoNombre}</option>`
                        )
                    }
    
                    );
                }else if(tipoVista == 3){
                    $("#txtEmpleadoNombre").append(
                        `<option value="">Seleccione empleado</option>`
                    )
                    data.forEach(empleado => {
                        
                        $("#txtEmpleadoNombre").append(
                            `<option value="${empleado.idEmpleado},${empleado.idChecador}">${empleado.apellido_p} ${empleado.apellido_m} ${empleado.Nombre} ${empleado.SegundoNombre}</option>`
                        )
                    }
    
                    );
                }
                
                
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                console.log("not ok")
            }
        });

        //TODOS
        jQuery.ajax({
            url: "ajax/readRecordsTodos_empleados.php",
            method: 'POST',
            async: false,
            dataType: 'JSON',
            data:{
            },
            success: function (data) {
                if(tipoVista == 1){
                    $(".tablaEmpleadosTodos").children().remove()
                    $(".tablaEmpleadosTodos").append(
                        `
                        <table id="exampleTodos" class="display" style="width:100%">
                            <thead>
                                <tr>
                                    <th># checador</th>
                                    <th>Nombre empleado</th>
                                    <th>Departamento</th>
                                    <th>Dirección</th>
                                    <th>Puesto</th>
                                    <th>Estatus</th>
                                    <th>Acumula vacaciones</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="dataEmpleadosTodos">
                            </tbody>
                        </table>
                        `
                    );
                    data.forEach(empleado => {
                        if(empleado.activo == 1){
                            $(".dataEmpleadosTodos").append(
                                `<tr>
                                    <td class="idEmpleado">${empleado.idChecador}</td>
                                    <td>${empleado.apellido_p} ${empleado.apellido_m} ${empleado.Nombre} ${empleado.SegundoNombre}</td>
                                    <td>${empleado.nombreDepartamento}</td>
                                    <td>${empleado.nombreDireccion}</td>
                                    <td>${empleado.Puesto}</td>
                                    <td>${empleado.activo == 1 ? "ACTIVO":"NO ACTIVO"}</td>
                                    <td>${empleado.acumula == 1 ? "SI":"NO"}</td>
                                    <td>
                                        
                                        <button class=" btn-success editar" data-bs-toggle="modal" data-bs-target="#exampleModal" onclick="HacerAlgo(${empleado.idEmpleado},2)"><i class="fa-solid fa-user-pen"></i></button>
                                        <button class=" btn-success borrar" onclick="deleteRecord(${empleado.idEmpleado})"><i class="fa-solid fa-trash"></i></button>
                                    </td>
                                 </tr>`
                            )
                        }else{
                            $(".dataEmpleadosTodos").append(
                                `<tr>
                                    <td class="idEmpleado">${empleado.idChecador}</td>
                                    <td>${empleado.apellido_p} ${empleado.apellido_m} ${empleado.Nombre} ${empleado.SegundoNombre}</td>
                                    <td>${empleado.nombreDepartamento}</td>
                                    <td>${empleado.nombreDireccion}</td>
                                    <td>${empleado.Puesto}</td>
                                    <td>${empleado.activo == 1 ? "ACTIVO":"NO ACTIVO"}</td>
                                    <td>
                                        
                                        <button class=" btn-success editar" data-bs-toggle="modal" data-bs-target="#exampleModal" onclick="HacerAlgo(${empleado.idEmpleado},2)"><i class="fa-solid fa-user-pen"></i></button>
                                        <button class=" btn-success borrar" onclick="activateRecord(${empleado.idEmpleado})"><i class="fa-solid fa-user-check"></i></button>
                                    </td>
                                 </tr>`
                            )
                        }
                    }
    
                    );
                    /*var empleadosData = [];
                    data.forEach(empleado => {
                        empleadosData.push([empleado.idEmpleado,empleado.Nombre,empleado.Ingreso])
                    }
    
                    )
                    var dataSet = empleadosData;
                    $('#example').DataTable( {
                        data: dataSet,
                        columns: [
                            { title: "idEmpleado" },
                            { title: "Nombre" },
                            { title: "Ingreso" },
                        ]
                    } );*/
                }else if(tipoVista == 2){
                    $("#txtEmpleadoNombre").append(
                        `<option value="">Seleccione empleado</option>`
                    )
                    data.forEach(empleado => {
                        
                        $("#txtEmpleadoNombre").append(
                            `<option value="${empleado.idEmpleado}">${empleado.apellido_p} ${empleado.apellido_m} ${empleado.Nombre} ${empleado.SegundoNombre}</option>`
                        )
                    }
    
                    );
                }else if(tipoVista == 3){
                    $("#txtEmpleadoNombre").append(
                        `<option value="">Seleccione empleado</option>`
                    )
                    data.forEach(empleado => {
                        
                        $("#txtEmpleadoNombre").append(
                            `<option value="${empleado.idEmpleado},${empleado.idChecador}">${empleado.apellido_p} ${empleado.apellido_m} ${empleado.Nombre} ${empleado.SegundoNombre}</option>`
                        )
                    }
    
                    );
                }
                
                
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                console.log("not ok")
            }
        });
        return resultado;
}


function getRecord(idEmpleado,accion){
    $(".guardarEmpleado").show();
    $(".agregarEmpleado").hide();
    $(".modal-title").hide();
    $(".modal-title-edit").show();
    
        jQuery.ajax({
            url: "ajax/getRecord_empleados.php",
            method: 'POST',
            async: false,
            dataType: 'JSON',
            data:{
                idEmpleado:idEmpleado
            },
            success: function (data) {
                if(accion == 2){
                    $("#txtEmail").val(data[0].mail)
                }else{
                    $("#txtNombre").val(data[0].Nombre)
                    $("#txtIngreso").val(data[0].Ingreso)
                    $("#txtidEmpleado").val(data[0].idEmpleado)
                    $("#txtIdChecador").val(data[0].idChecador)
                    $("#txtApellido_p").val(data[0].apellido_p)
                    $("#txtApellido_m").val(data[0].apellido_m)
                    $("#txtSegundoNombre").val(data[0].segundoNombre)
                    $("#txtDepartamento").val(data[0].departamento)
                    $("#txtDireccion").val(data[0].direccion)
                    $("#txtMail").val(data[0].mail)
                    $("#txtEntrada").val(data[0].entrada)
                    $("#txtSalida").val(data[0].salida)
                    $("#txtEntradaDos").val(data[0].entradaDos)
                    $("#txtSalidaDos").val(data[0].salidaDos)
                    $("#txtPuesto").val(data[0].puesto)
                    $("#txtJefeDirecto").val(data[0].Encargado)
                    $("#entradaViernes").val(data[0].entradaViernes)
                    $("#salidaViernes").val(data[0].salidaViernes)
                }
                
                
                
                
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                console.log("not ok")
            }
        });
}
function deleteRecord(idEmpleado){
    swal({
        title: "¿Está seguro de que deseas dar de baja a este empleado?",
        text: "",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
            jQuery.ajax({
                url: "ajax/deleteEmpleado.php",
                method: 'POST',
                async: false,
                data:{
                    idEmpleado:idEmpleado
                },
                success: function (data) {
                    swal("Empleado dado de baja", "", "success");
                    $("#exampleModal").modal("hide");
                    readRecords(1)
                    readRecordsNoActivos(1)
                    $('#example').DataTable({
                        fixedColumns: true,
                        "scrollX": true
                    });
                    $('#exampleNoActivos').DataTable({
                        fixedColumns: true,
                        "scrollX": true
                      });
                      $('#exampleTodos').DataTable({
                        fixedColumns: true,
                        "scrollX": true
                      });
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    console.log("not ok")
                }
            });
        }
      });
}

function activateRecord(idEmpleado){
    swal({
        title: "¿Está seguro de que deseas habilitar este empleado?",
        text: "",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
            jQuery.ajax({
                url: "ajax/activateEmpleado.php",
                method: 'POST',
                async: false,
                data:{
                    idEmpleado:idEmpleado
                },
                success: function (data) {
                    swal("Empleado habilitado", "", "success");
                    $("#exampleModal").modal("hide");
                    readRecords(1)
                    readRecordsNoActivos(1)
                    $('#example').DataTable({
                        fixedColumns: true,
                        "scrollX": true
                    });
                    $('#exampleNoActivos').DataTable({
                        fixedColumns: true,
                        "scrollX": true
                      });
                      $('#exampleTodos').DataTable({
                        fixedColumns: true,
                        "scrollX": true
                      });
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    console.log("not ok")
                }
            });
        }
      });
}

function editaEmpleado(){
    $(".agregarEmpleado").hide();
    $(".guardarEmpleado").show();
    $(".modal-title").hide();
    $(".modal-title-edit").show();
    
    var idEmpleado = $("#txtidEmpleado").val()
    var nombreemp = $("#txtNombre").val()
    var checador = $("#txtIdChecador").val()
    var apellidoP = $("#txtApellido_p").val()
    var apellidoM = $("#txtApellido_m").val()
    var segundoNombre = $("#txtSegundoNombre").val()
    var departamento = $("#txtDepartamento").val()
    var direccion = $("#txtDireccion").val()
    var ingreso = $("#txtIngreso").val()
    var mailEmp = $("#txtMail").val()
    var entrada = $("#txtEntrada").val()
    var salida = $("#txtSalida").val()
    var entradaDos = $("#txtEntradaDos").val()
    var salidaDos = $("#txtSalidaDos").val()
    var puesto = $("#txtPuesto").val()
    var jefeDirecto = $("#txtJefeDirecto").val()
    var entradaViernes = $("#entradaViernes").val()
    var salidaViernes = $("#salidaViernes").val()
    var add_acumulaVacs = $("#txtAcumulaVacs").val();
    jQuery.ajax({
        url: "ajax/editEmpleado.php",
        method: 'POST',
        async: false,
        dataType: 'JSON',
        data:{
            idEmpleado:idEmpleado,
            nombreemp:nombreemp,
            checador:checador,
            apellidoP:apellidoP,
            apellidoM:apellidoM,
            segundoNombre:segundoNombre,
            departamento:departamento,
            direccion:direccion,
            ingreso:ingreso,
            mailEmp:mailEmp,
            entrada:entrada,
            salida:salida,
            entradaDos:entradaDos,
            salidaDos:salidaDos,
            puesto:puesto,
            jefeDirecto:jefeDirecto,
            entradaViernes:entradaViernes,
            salidaViernes:salidaViernes,
            add_acumulaVacs:add_acumulaVacs
        },
        success: function (data) {
            swal("Información actualizada", "", "success");
            $("#exampleModal").modal("hide");
            // readRecords(1)
            // readRecordsNoActivos(1)
            // $('#example').DataTable({
            //     fixedColumns: true,
            //     "scrollX": true
            // });
            $(".dataEmpleados tr .idEmpleado").each(function(index){
                if($(this).text() == data[0].idChecador){
                    $(this).next().text(data[0].apellido_p + " " + data[0].apellido_m + " " + data[0].Nombre + " " + data[0].SegundoNombre) 
                    $(this).next().next().text(data[0].nombreDepartamento) 
                    $(this).next().next().netx().text(data[0].nombreDireccion) 
                    $(this).next().next().netx().next().text(data[0].Puesto) 
                    return false;
                }

                
            });
            
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            console.log("not ok")
        }
    });
}
function HacerAlgo(idEmpleado,accion){
    //alert(idEmpleado);
    if(accion == 2){
        getRecord(idEmpleado)
    }else{
        $("#empleadorForm").trigger("reset");
        $(".guardarEmpleado").hide();
        $(".agregarEmpleado").show();
        $(".modal-title").show();
        $(".modal-title-edit").hide();
    }
    
}

function comboDepartamentos(){
    jQuery.ajax({
        url: "ajax/departamentosRH.php",
        method: 'POST',
        async: false,
        dataType: 'JSON',
        data:{
        },
        success: function (data) {
            data.forEach(departamento => {
                $("#txtDepartamento").append(
                    `
                    <option value="${departamento.idDepartamento}">${departamento.nombreDepartamento}</option>
                    `
                )
            }

            );
            
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            console.log("not ok")
        }
    });
}
function comboDireccion(){
    jQuery.ajax({
        url: "ajax/direccionesRH.php",
        method: 'POST',
        async: false,
        dataType: 'JSON',
        data:{
        },
        success: function (data) {
            data.forEach(departamento => {
                $("#txtDireccion").append(
                    `
                    <option value="${departamento.idDireccion}">${departamento.nombreDireccion}</option>
                    `
                )
            }

            );
            
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            console.log("not ok")
        }
    });
}
function comboJefesDirectos(){
    jQuery.ajax({
        url: "ajax/jefesDireccionesRH.php",
        method: 'POST',
        async: false,
        dataType: 'JSON',
        data:{
        },
        success: function (data) {
            data.forEach(jefeDirecto => {
                $("#txtJefeDirecto").append(
                    `
                    <option value="${jefeDirecto.idEmpleado}">${jefeDirecto.nombreEmpleado}</option>
                    `
                )
            }

            );
            
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            console.log("not ok")
        }
    });
}

/* DEPARTAMENTOS Y DIRECCIONES */
function muestraDepartamentos() {
    var resultado;
        jQuery.ajax({
            url: "ajax/readRecords_departamentos.php",
            method: 'POST',
            async: false,
            dataType: 'JSON',
            data:{
            },
            success: function (data) {
                $(".tablaDepartamentos").children().remove()
                $(".tablaDepartamentos").append(
                    `
                    <table id="tablaDepartamentos" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th>Nombre departamento</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="dataDepartamentos">
                        </tbody>
                    </table>
                    `
                );
                data.forEach(departamento => {
                    $(".dataDepartamentos").append(
                        `<tr>
                            <td>${departamento.nombreDepartamento}</td>
                            <td>
                                
                                <button class=" btn-success editar" data-bs-toggle="modal" data-bs-target="#departamentoModal" onclick="ModalDepartamentoAccion(${departamento.idDepartamento},2)"><i class="fa-solid fa-user-pen"></i></button>
                                <button class=" btn-success borrar" onclick="deleteRecordDepartamento(${departamento.idDepartamento})"><i class="fa-solid fa-trash"></i></button>
                            </td>
                         </tr>`
                    )
                }

                );

                
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                console.log("not ok")
            }
        });
        return resultado;
}

function muestraDirecciones() {
    var resultado;
        jQuery.ajax({
            url: "ajax/readRecords_direcciones.php",
            method: 'POST',
            async: false,
            dataType: 'JSON',
            data:{
            },
            success: function (data) {
                $(".tablaDirecciones").children().remove()
                $(".tablaDirecciones").append(
                    `
                    <table id="tablaDirecciones" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th>Nombre dirección</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="dataDirecciones">
                        </tbody>
                    </table>
                    `
                );
                data.forEach(direccion => {
                    $(".dataDirecciones").append(
                        `<tr>
                            <td>${direccion.nombreDireccion}</td>
                            <td>
                                
                                <button class=" btn-success editar" data-bs-toggle="modal" data-bs-target="#direccionModal" onclick="ModalDireccionAccion(${direccion.idDireccion},2)"><i class="fa-solid fa-user-pen"></i></button>
                                <button class=" btn-success borrar" onclick="deleteRecordDireccion(${direccion.idDireccion})"><i class="fa-solid fa-trash"></i></button>
                            </td>
                         </tr>`
                    )
                }

                );
                
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                console.log("not ok")
            }
        });
        return resultado;
}
function ModalDepartamentoAccion(idDepartamento,accion){
    //alert(idEmpleado);
    if(accion == 2){
        getRecordDepartamento(idDepartamento)
    }else{
        $("#departamentoForm").trigger("reset");
        $(".guardarDepartamento").hide();
        $(".agregarDepartamento").show();
        $(".modal-title-departamento").show();
        $(".modal-title-edit-departamento").hide();
    }
    
}
function ModalDireccionAccion(idDireccion,accion){
    //alert(idEmpleado);
    if(accion == 2){
        getRecordDireccion(idDireccion)
    }else{
        $("#direccionForm").trigger("reset");
        $(".guardarDireccion").hide();
        $(".agregarDireccion").show();
        $(".modal-title-direccion").show();
        $(".modal-title-edit-direccion").hide();
    }
    
}

function getRecordDepartamento(idDepartamento){
    $(".guardarDepartamento").show();
    $(".agregarDepartamento").hide();
    $(".modal-title-departamento").hide();
    $(".modal-title-edit-departamento").show();
    
        jQuery.ajax({
            url: "ajax/departamentosRH.php",
            method: 'POST',
            async: false,
            dataType: 'JSON',
            data:{
                idDepartamento:idDepartamento
            },
            success: function (data) {
                $("#txtDepartamento").val(data[0].nombreDepartamento)
                $("#txtidDepartamento").val(data[0].idDepartamento)      
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                console.log("not ok")
            }
        });
}

function getRecordDireccion(idDireccion){
    $(".guardarDireccion").show();
    $(".agregarDireccion").hide();
    $(".modal-title-departamento").hide();
    $(".modal-title-edit-direccion").show();
    
        jQuery.ajax({
            url: "ajax/direccionesRH.php",
            method: 'POST',
            async: false,
            dataType: 'JSON',
            data:{
                idDireccion:idDireccion
            },
            success: function (data) {
                $("#txtidDireccion").val(data[0].idDireccion)
                $("#txtDireccion").val(data[0].nombreDireccion)
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                console.log("not ok")
            }
        });
}

function editaDepartamento(){
    $(".agregarDepartamento").hide();
    $(".guardarDepartamento").show();
    $(".modal-title-departamento").hide();
    $(".modal-title-edit-departamento").show();
    
    var iddepartamento = $("#txtidDepartamento").val()
    var nombreDepartamento = $("#txtDepartamento").val()
    jQuery.ajax({
        url: "ajax/editDepartamento.php",
        method: 'POST',
        async: false,
        data:{
            iddepartamento:iddepartamento,
            nombreDepartamento:nombreDepartamento
        },
        success: function (data) {
            swal("Información actualizada", "", "success");
            $("#departamentoModal").modal("hide");
            muestraDepartamentos()
            $('#tablaDepartamentos').DataTable({
                fixedColumns: true,
                "scrollX": true
            });
            
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            console.log("not ok")
        }
    });
}

function editaDireccion(){
    $(".agregarDireccion").hide();
    $(".guardarDireccion").show();
    $(".modal-title-direccion").hide();
    $(".modal-title-edit-direccion").show();
    
    var idDireccion = $("#txtidDireccion").val()
    var nombreDireccion = $("#txtDireccion").val()

    jQuery.ajax({
        url: "ajax/editDireccion.php",
        method: 'POST',
        async: false,
        data:{
            idDireccion:idDireccion,
            nombreDireccion:nombreDireccion
        },
        success: function (data) {
            swal("Información actualizada", "", "success");
            $("#direccionModal").modal("hide");
            muestraDirecciones()
            $('#tablaDirecciones').DataTable({
                fixedColumns: true,
                "scrollX": true
            });
            
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            console.log("not ok")
        }
    });
}

function deleteRecordDepartamento(idDepartamento){
    swal({
        title: "¿Está seguro de que deseas eliminar a este departamento?",
        text: "No se podrá recuperar",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
            jQuery.ajax({
                url: "ajax/deleteDepartamento.php",
                method: 'POST',
                async: false,
                data:{
                    idDepartamento:idDepartamento
                },
                success: function (data) {
                    swal("Departamento eliminado", "", "success");
                    $("#departamentoModal").modal("hide");
                    muestraDepartamentos()
                    $('#tablaDepartamentos').DataTable({
                        fixedColumns: true,
                        "scrollX": true
                    });
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    console.log("not ok")
                }
            });
        }
      });
}


function deleteRecordDireccion(idDireccion){
    swal({
        title: "¿Está seguro de que deseas eliminar a esta dirección?",
        text: "No se podrá recuperar",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
            jQuery.ajax({
                url: "ajax/deleteDireccion.php",
                method: 'POST',
                async: false,
                data:{
                    idDireccion:idDireccion
                },
                success: function (data) {
                    swal("Dirección eliminada", "", "success");
                    $("#direccionModal").modal("hide");
                    muestraDirecciones()
                    $('#tablaDirecciones').DataTable({
                        fixedColumns: true,
                        "scrollX": true
                    });
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    console.log("not ok")
                }
            });
        }
      });
}

function addDepartamento() {
    // get values
    var nombreDepartamento = $("#txtDepartamento").val();
    if(nombreDepartamento == ""){
        $("#txtDepartamento").addClass("error-msg-input")
        swal("Por favor llene los campos requeridos", "", "info");
        $( ".error-msg-input" ).change(function() {
            $(this).removeClass("error-msg-input")
        });
    }else{
        // Add record
        $.post("ajax/addRecord_departamento.php", {
            nombreDepartamento:nombreDepartamento
        }, function (data, status) {
            swal("Departamento agregado correctamente", "", "success");
            //$('#my_table').DataTable().clear();
            $("#departamentoForm").trigger("reset");
            $("#departamentoModal").modal("hide");
            muestraDepartamentos()
            $('#tablaDepartamentos').DataTable({
                fixedColumns: true,
                "scrollX": true
            });
            
                
        });
    }
    
}

function addDireccion() {
    // get values
    var nombreDireccion = $("#txtDireccion").val();
    if(nombreDireccion == ""){
        $("#txtDireccion").addClass("error-msg-input")
        swal("Por favor llene los campos requeridos", "", "info");
        $( ".error-msg-input" ).change(function() {
            $(this).removeClass("error-msg-input")
        });
    }else{
        // Add record
        $.post("ajax/addRecord_direccion.php", {
            nombreDireccion:nombreDireccion
        }, function (data, status) {
            swal("Dirección agregada correctamente", "", "success");
            //$('#my_table').DataTable().clear();
            $("#direccionForm").trigger("reset");
            $("#direccionModal").modal("hide");
            muestraDirecciones()
            $('#tablaDirecciones').DataTable({
                fixedColumns: true,
                "scrollX": true
            });
            
                
        });
    }

    
}
/* DEPARTAMENTOS Y DIRECCIONES */

/* INCIDENCIAS */
function muestraIncidencias() {
    let empleadoActualInci = Cookies.get('idEmpleado');
    $(".cambioFijo").hide()
    let idPeriodo = $("#nominaReporte").val()
    let permisos = JSON.parse(Cookies.get('permisos'));
    var resultado;
    let verTodo = 0
    //SI NO TIENE PERMISOS SUFICIENTES
    let accesoApp = permisos.find(e => e.idApp == 3)
    
    //SI NO TIENE PERMISOS SUFICIENTES

        jQuery.ajax({
            url: "ajax/readRecords_incidencias.php",
            method: 'POST',
            async: false,
            dataType: 'JSON',
            data:{
                verTodo:verTodo,
                idPeriodo:idPeriodo
            },
            success: function (data) {
                $(".tablaIncidencias").children().remove()
                $(".tablaIncidencias").append(
                    `
                    <table id="tablaIncidencias" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th>Folio</th>
                                <th>Fecha</th>
                                <th>Empleado</th>
                                <th>Departamento</th>
                                <th>Entrada</th>
                                <th>Salida</th>
                                <th>Motivo incidencia</th>
                                <th>Tipo incidencia</th>
                                <th>Fecha registro</th>
                                <th>Evidencia</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="dataIncidencias">
                        </tbody>
                    </table>
                    `
                );
                if(data[0].status == undefined){
                    var noAprobadas = data.filter(x => x.estado === "0");
                    noAprobadas.forEach(incidencia => {
                        var param = incidencia;
                        if(incidencia.tipoIncidencia == 6){
                            var fijos = formatFijos(incidencia.motivo);
                        }
                        if(incidencia.idEmpleado == empleadoActualInci){
                            let evidencia = incidencia.urlEvidencia;
                            $(".dataIncidencias").append(
                                `<tr>
                                    <td>${incidencia.idPase}</td>
                                    <td>${incidencia.fechaPase}</td>
                                    <td>${incidencia.nombreEmpleado}</td>
                                    <td>${incidencia.departamento}</td>
                                    <td>${incidencia.entrada}</td>
                                    <td>${incidencia.salida}</td>
                                    <td>${incidencia.tipoIncidencia == 6 ? fijos : incidencia.motivo}</td>
                                    <td>${incidencia.tipoIncidencia == 1 ? 'SALIDA ANTICIPADA': incidencia.tipoIncidencia == 2 ? 'LLEGADA TARDE' : incidencia.tipoIncidencia == 3 ? 'FALTA POR COMISIÓN' : incidencia.tipoIncidencia == 4 ? 'NO CHECAR ENTRADA' : incidencia.tipoIncidencia == 6 ? 'CAMBIO FIJO': incidencia.tipoIncidencia == 31 ? 'DAY OFF' : incidencia.tipoIncidencia == 32 ? 'INCAPACIDAD' : 'NO CHECAR SALIDA'}</td>                                <td>${incidencia.fechaRegistro}</td>
                                    <td class="${incidencia.urlEvidencia == '' ? 'hideEvidence' : ''}"><a onclick="muestraEvidencia('${incidencia.urlEvidencia}')" style="cursor: pointer"><u>Ver evidencia</u></a></td>
                                    <td>
                                        
                                        <button class=" btn-success borrar" onclick="deleteIncidencia(${incidencia.idPase})"><i class="fa-solid fa-trash"></i></button>
                                    </td>
                                 </tr>`
                            )
                        }else{
                            $(".dataIncidencias").append(
                                `<tr>
                                    <td>${incidencia.idPase}</td>
                                    <td>${incidencia.fechaPase}</td>
                                    <td>${incidencia.nombreEmpleado}</td>
                                    <td>${incidencia.departamento}</td>
                                    <td>${incidencia.entrada}</td>
                                    <td>${incidencia.salida}</td>
                                    <td>${incidencia.tipoIncidencia == 6 ? fijos : incidencia.motivo}</td>
                                    <td>${incidencia.tipoIncidencia == 1 ? 'SALIDA ANTICIPADA': incidencia.tipoIncidencia == 2 ? 'LLEGADA TARDE' : incidencia.tipoIncidencia == 3 ? 'FALTA POR COMISIÓN' : incidencia.tipoIncidencia == 4 ? 'NO CHECAR ENTRADA' : incidencia.tipoIncidencia == 6 ? 'CAMBIO FIJO' : incidencia.tipoIncidencia == 31 ? 'DAY OFF' : incidencia.tipoIncidencia == 32 ? 'INCAPACIDAD' : 'NO CHECAR SALIDA'}</td>                                <td>${incidencia.fechaRegistro}</td>
                                    <td class="${incidencia.urlEvidencia == '' ? 'hideEvidence' : ''}"><a onclick="muestraEvidencia('${incidencia.urlEvidencia}')" style="cursor: pointer"><u>Ver evidencia</u></a></td>
                                    <td>
                                        
                                        <button class=" btn-success borrar" onclick="deleteIncidencia(${incidencia.idPase})"><i class="fa-solid fa-trash"></i></button>
                                        <button class=" btn-success aprobarIncidencia" onclick="apruebaIncidenciaNomina(${incidencia.idPase})"><i class="fa-solid fa-check"></i></button>
                                    </td>
                                 </tr>`
                            )
                        }
                        
                    }
    
                    );
                }
                

                $(".tablaIncidenciasNoAprobadas").children().remove()
                $(".tablaIncidenciasNoAprobadas").append(
                    `
                    <table id="tablaIncidenciasNoAprobadas" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th>Folio</th>
                                <th>Fecha</th>
                                <th>Empleado</th>
                                <th>Departamento</th>
                                <th>Entrada</th>
                                <th>Salida</th>
                                <th>Motivo incidencia</th>
                                <th>Tipo incidencia</th>
                                <th>Fecha registro</th>
                                <th>Evidencia</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="dataIncidenciasNoAprobadas">
                        </tbody>
                    </table>
                    `
                );
                if(data[0].status == undefined){
                    var aprobadas = data.filter(x => x.estado === "1");
                    aprobadas.forEach(incidencia => {
                        var param = incidencia;
                        if(incidencia.tipoIncidencia == 6){
                            var fijos = formatFijos(incidencia.motivo);
                        }
                        $(".dataIncidenciasNoAprobadas").append(
                            `<tr>
                                <td>${incidencia.idPase}</td>
                                <td>${incidencia.fechaPase}</td>
                                <td>${incidencia.nombreEmpleado}</td>
                                <td>${incidencia.departamento}</td>
                                <td>${incidencia.entrada}</td>
                                <td>${incidencia.salida}</td>
                                <td>${incidencia.tipoIncidencia == 6 ? fijos : incidencia.motivo}</td>
                                <td>${incidencia.tipoIncidencia == 1 ? 'SALIDA ANTICIPADA': incidencia.tipoIncidencia == 2 ? 'LLEGADA TARDE' : incidencia.tipoIncidencia == 3 ? 'FALTA POR COMISIÓN' : incidencia.tipoIncidencia == 4 ? 'NO CHECAR ENTRADA' : incidencia.tipoIncidencia == 6 ? 'CAMBIO FIJO': incidencia.tipoIncidencia == 31 ? 'DAY OFF' : incidencia.tipoIncidencia == 32 ? 'INCAPACIDAD' : 'NO CHECAR SALIDA'}</td>
                                <td>${incidencia.fechaRegistro}</td>
                                <td class="${incidencia.urlEvidencia == '' ? 'hideEvidence' : ''}"><a onclick="muestraEvidencia('${incidencia.urlEvidencia}')" style="cursor: pointer"><u>Ver evidencia</u></a></td>
                                <td>
                                    
                                    <button class=" btn-success borrar" onclick="deleteIncidencia(${incidencia.idPase})"><i class="fa-solid fa-trash"></i></button>
                                </td>
                             </tr>`
                        )
                    }
    
                    );
                }
                $(".hideEvidence").text("");
                
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                console.log("not ok")
            }
        });
        if(accesoApp.nivelAcceso != 2 && accesoApp.nivelAcceso != 3 && accesoApp.nivelAcceso != 4){
            $(".aprobarIncidencia").remove();
            $(".goToNomina").remove();
        }else{
            verTodo = 1;
        }
        if(accesoApp.nivelAcceso == 4 || accesoApp.nivelAcceso == 3){
            $("#cambioFijoOpcion").removeClass("d-none")
        }
        return resultado;
}

function formatFijos(horarios){
    let horariosJson = JSON.parse(horarios);
    let horariosStr =`<button class="verCambioFijo btn btn-success">Ver horarios</button><div class="d-none dataHorario" style="white-space: pre;">
    Lunes : ${horariosJson[0].inicioLunes} - ${horariosJson[0].finLunes}
    Martes : ${horariosJson[1].inicioMartes} - ${horariosJson[1].finMartes}
    Miércoles : ${horariosJson[2].inicioMiercoles} - ${horariosJson[2].finMiercoles}
    Jueves : ${horariosJson[3].inicioJueves} - ${horariosJson[3].finJueves}
    Viernes : ${horariosJson[4].inicioViernes} - ${horariosJson[4].finViernes}
    Sábado : ${horariosJson[5].inicioSabado} - ${horariosJson[5].finSabado}
    Domingo : ${horariosJson[6].inicioDomingo} - ${horariosJson[6].finDomingo}
    </div>
    `;
    return horariosStr;
}
function verCambioFijo(){
    $( ".verCambioFijo",this).closest( "div" ).removeClass("d-none");
}


function addRecordIncidencia() {
    var txtDepartamento = $("#txtDepartamento").val()
    var txtEmpleadoNombre = $("#txtEmpleadoNombre").val()
    var txtIncidencia = $("#txtIncidencia").val()
    var txtFechaInicio = $("#txtFechaInicio").val()
    var txtFechaFin = $("#txtFechaFin").val()
    var txtHoraEntrada = $("#txtHoraEntrada").val()
    var txtHoraSalida = $("#txtHoraSalida").val()
    var txtMotivo = $("#txtMotivo").val()
    var txtEmpleado = $("#txtEmpleado").val()
    var idPeriodo = $("#nominaReporte").val();
    var fileEvidencia = $("#uploadImage").prop("files")[0]
    if(fileEvidencia != undefined){
        var nameFile = fileEvidencia.name;
        var form = new FormData();
        form.append("image", fileEvidencia);
        $.ajax({
            url: "ajax/upload.php",
            type: "POST",
            data:  form,
            contentType: false,
            processData:false,
            success: function(result){
                //document.write(result);
            }
        });
    }else{
        var nameFile = "";
    }
    
    
   
    // Add record
    if(txtFechaInicio == "" || txtMotivo == "" || txtEmpleadoNombre == ""){
        if(txtFechaInicio == ""){
            $("#txtFechaInicio").addClass("error-msg-input")
        }
        if(txtMotivo == ""){
            $("#txtMotivo").addClass("error-msg-input")
        }
        if(txtEmpleadoNombre == ""){
            $("#txtEmpleadoNombre").addClass("error-msg-input")
        }
        swal("Por favor llene los campos requeridos", "", "info");
        $( ".error-msg-input" ).change(function() {
            $(this).removeClass("error-msg-input")
        });
    }else{
        var validaInserta = validaFechaParaInsertar(txtFechaInicio)
        if(validaInserta){
            $("#registraIncidencia").attr("disabled", "yes")
            $.post("ajax/addRecord_incidencias.php", {
                txtDepartamento:txtDepartamento,      
                txtEmpleadoNombre:txtEmpleadoNombre,
                txtIncidencia:txtIncidencia,
                txtFechaInicio:txtFechaInicio,
                txtFechaFin:txtFechaFin,
                txtHoraEntrada:txtHoraEntrada,
                txtHoraSalida:txtHoraSalida,
                txtMotivo:txtMotivo,
                txtEmpleado:txtEmpleado,
                idPeriodo:idPeriodo,
                nameFile:nameFile
            }, function (data, status) {
                $("#registraIncidencia").removeAttr("disabled")
                swal("Incidencia agregada correctamente", "", "success");
                //$('#my_table').DataTable().clear();
                $("#incidenciaForm").trigger("reset");
                $("#modalIncidencias").modal("hide");
                muestraIncidencias();
                $('#tablaIncidencias').DataTable({
                    fixedColumns: true,
                  "scrollX": true,
                  "language": {
                  "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json",
                  },
                  dom: "Bfrtip",
                  "lengthMenu": [[10, 25, 50, -1], ["Mostrar 10", "Mostrar 25", "Mostrar 50", "Mostrar Todo"]],
                  buttons: [ {
                    extend: "excel",
                    title: "REPORTE DE INCIDENCIAS",
                    filename: "Reporte de incidencias",
                    text: "Descargar Excel"
                  },
                  "pageLength",
                  ]
                });
                $('#tablaIncidenciasNoAprobadas').DataTable({
                    fixedColumns: true,
                  "scrollX": true,
                  "language": {
                  "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json",
                  },
                  dom: "Bfrtip",
                  "lengthMenu": [[10, 25, 50, -1], ["Mostrar 10", "Mostrar 25", "Mostrar 50", "Mostrar Todo"]],
                  buttons: [ {
                    extend: "excel",
                    title: "REPORTE DE INCIDENCIAS",
                    filename: "Reporte de incidencias",
                    text: "Descargar Excel"
                  },
                  "pageLength",
                  ]
                  });
                    
            });
        }else{
            swal("Periodo de fechas inválido", "", "info");
        }
        
    }
    
}

function addRecordIncidenciaHorarios() {
    var txtDepartamento = $("#txtDepartamento").val()
    var txtEmpleadoNombre = $("#txtEmpleadoNombre").val()
    var txtIncidencia = $("#txtIncidencia").val()
    var txtFechaInicio = $("#txtFechaInicio").val()
    var txtFechaFin = $("#txtFechaFin").val()
    var txtHoraEntrada = $("#txtHoraEntrada").val()
    var txtHoraSalida = $("#txtHoraSalida").val()
    var txtMotivo = $("#txtMotivo").val()
    var txtEmpleado = $("#txtEmpleado").val()
    
    var inicioLunes = $("#txtFechaInicioLunes").val();
    var finLunes = $("#txtFechaFinLunes").val();

    var inicioMartes = $("#txtFechaInicioMartes").val();
    var finMartes = $("#txtFechaFinMartes").val();

    var inicioMiercoles = $("#txtFechaInicioMiercoles").val();
    var finMiercoles = $("#txtFechaFinMiercoles").val();

    var inicioJueves = $("#txtFechaInicioJueves").val();
    var finJueves = $("#txtFechaFinJueves").val();

    var inicioViernes = $("#txtFechaInicioViernes").val();
    var finViernes = $("#txtFechaFinViernes").val();

    var inicioSabado = $("#txtFechaInicioSabado").val();
    var finSabado = $("#txtFechaFinSabado").val();

    var inicioDomingo = $("#txtFechaInicioDomingo").val();
    var finDomingo = $("#txtFechaFinDomingo").val();

    var horario = [];
    horario.push({"inicioLunes":inicioLunes, "finLunes":finLunes});
    horario.push({"inicioMartes":inicioMartes, "finMartes":finMartes});
    horario.push({"inicioMiercoles":inicioMiercoles, "finMiercoles":finMiercoles});
    horario.push({"inicioJueves":inicioJueves, "finJueves":finJueves});
    horario.push({"inicioViernes":inicioViernes, "finViernes":finViernes});
    horario.push({"inicioSabado":inicioSabado, "finSabado":finSabado});
    horario.push({"inicioDomingo":inicioDomingo, "finDomingo":finDomingo});

    var horarioGuardar = JSON.stringify(horario);

    
    // Add record
    $.post("ajax/addRecord_incidencias.php", {
        txtDepartamento:txtDepartamento,      
        txtEmpleadoNombre:txtEmpleadoNombre,
        txtIncidencia:txtIncidencia,
        txtFechaInicio:txtFechaInicio,
        txtFechaFin:txtFechaFin,
        txtHoraEntrada:txtHoraEntrada,
        txtHoraSalida:txtHoraSalida,
        txtMotivo:txtMotivo,
        txtEmpleado:txtEmpleado,
        horarioGuardar:horarioGuardar
    }, function (data, status) {
        swal("Incidencia agregada correctamente", "", "success");
        //$('#my_table').DataTable().clear();
        $("#incidenciaForm").trigger("reset");
        $("#modalIncidencias").modal("hide");
        muestraIncidencias();
        $('#tablaIncidencias').DataTable({
            fixedColumns: true,
                  "scrollX": true,
                  "language": {
                  "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json",
                  },
                  dom: "Bfrtip",
                  "lengthMenu": [[10, 25, 50, -1], ["Mostrar 10", "Mostrar 25", "Mostrar 50", "Mostrar Todo"]],
                  buttons: [ {
                    extend: "excel",
                    title: "REPORTE DE INCIDENCIAS",
                    filename: "Reporte de incidencias",
                    text: "Descargar Excel"
                  },
                  "pageLength",
                  ]
        });
        
        	
    });
}

function datosIncidenciaEmpleado() {
    var txtEmpleadoNombre = $("#txtEmpleadoNombre").val()
    // Add record
    jQuery.ajax({
        url: "ajax/getInfoEmpleado_incidencias.php",
        method: 'POST',
        async: false,
        dataType: 'JSON',
        data:{
            txtEmpleadoNombre:txtEmpleadoNombre
        },
        success: function (data) {
            $("#txtEmpleado").val(data[0].Nombre);
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            console.log("falló")
        }
    });

}

function deleteIncidencia(idPase){
    swal({
        title: "¿Está seguro de que deseas eliminar esta incidencia?",
        text: "No se podrá recuperar",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
            jQuery.ajax({
                url: "ajax/deleteIncidencia.php",
                method: 'POST',
                async: false,
                data:{
                    idPase:idPase
                },
                success: function (data) {
                    swal("Incidencia eliminada", "", "success");
                    muestraIncidencias();
                    $('#tablaIncidencias').DataTable({
                        fixedColumns: true,
                  "scrollX": true,
                  "language": {
                  "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json",
                  },
                  dom: "Bfrtip",
                  "lengthMenu": [[10, 25, 50, -1], ["Mostrar 10", "Mostrar 25", "Mostrar 50", "Mostrar Todo"]],
                  buttons: [ {
                    extend: "excel",
                    title: "REPORTE DE INCIDENCIAS",
                    filename: "Reporte de incidencias",
                    text: "Descargar Excel"
                  },
                  "pageLength",
                  ]
                    });
                    $('#tablaIncidenciasNoAprobadas ').DataTable({
                        fixedColumns: true,
                  "scrollX": true,
                  "language": {
                  "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json",
                  },
                  dom: "Bfrtip",
                  "lengthMenu": [[10, 25, 50, -1], ["Mostrar 10", "Mostrar 25", "Mostrar 50", "Mostrar Todo"]],
                  buttons: [ {
                    extend: "excel",
                    title: "REPORTE DE INCIDENCIAS",
                    filename: "Reporte de incidencias",
                    text: "Descargar Excel"
                  },
                  "pageLength",
                  ]
                    });
                    
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    console.log("not ok")
                }
            });
        }
      });
}
function filtroIncidencias(){
    var filtroFecha = $("#filtroFecha").val()
    var filtroDepartamento = $("#filtroDepartamento").val()
    var filtroTipo = $("#filtroTipo").val()
    var filtroFechaRegistro = $("#filtroFechaRegistro").val()
        jQuery.ajax({
            url: "ajax/readRecords_filtros_incidencias.php",
            method: 'POST',
            async: false,
            dataType: 'JSON',
            data:{
                filtroFecha:filtroFecha,
                filtroDepartamento:filtroDepartamento,
                filtroTipo:filtroTipo,
                filtroFechaRegistro:filtroFechaRegistro
            },
            success: function (data) {
                $(".tablaIncidencias").children().remove()
                $(".tablaIncidencias").append(
                    `
                    <table id="tablaIncidencias" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th>Folio</th>
                                <th>Fecha</th>
                                <th>Empleado</th>
                                <th>Departamento</th>
                                <th>Entrada</th>
                                <th>Salida</th>
                                <th>Motivo incidencia</th>
                                <th>Tipo incidencia</th>
                                <th>Fecha registro</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="dataIncidencias">
                        </tbody>
                    </table>
                    `
                );
                if(data[0].status == undefined){
                    data.forEach(incidencia => {
                        var param = incidencia;
                        $(".dataIncidencias").append(
                            `<tr>
                                <td>${incidencia.idPase}</td>
                                <td>${incidencia.fechaPase}</td>
                                <td>${incidencia.nombreEmpleado}</td>
                                <td>${incidencia.departamento}</td>
                                <td>${incidencia.entrada}</td>
                                <td>${incidencia.salida}</td>
                                <td>${incidencia.motivo}</td>
                                <td>${incidencia.tipoIncidencia}</td>
                                <td>${incidencia.fechaRegistro}</td>
                                <td>
                                    
                                    <button class=" btn-success borrar" onclick="deleteIncidencia(${incidencia.idPase})"><i class="fa-solid fa-trash"></i></button>
                                </td>
                             </tr>`
                        )
                    }
    
                    );
                }
                

                
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                console.log("not ok")
            }
        });
}

function apruebaIncidenciaNomina(idPase){
    var isNomina = false;
    if(idPase == "nomina"){
        idPase = $("#txtIdPase").val();
        isNomina = true;
    }
    swal({
        title: "¿Está seguro de que desea aprobar esta incidencia?",
        text: "",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
            jQuery.ajax({
                url: "ajax/aprueba_incidencias.php",
                method: 'POST',
                async: false,
                dataType: 'JSON',
                data:{
                    idPase : idPase
                },
                success: function (data) {
                    swal("Incidencia aprobada correctamente", "", "success");
                    $("#modalIncidencia").modal("hide");
                    $("#infoIncidenciaForm").trigger("reset");
                    muestraIncidencias();
                    comboDepartamentos();
                    readRecords(2);
                    $('#tablaIncidencias').DataTable({
                        fixedColumns: true,
                        "scrollX": true,
                        "language": {
                        "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json",
                        },
                        dom: "Bfrtip",
                        "lengthMenu": [[10, 25, 50, -1], ["Mostrar 10", "Mostrar 25", "Mostrar 50", "Mostrar Todo"]],
                        buttons: [ {
                          extend: "excel",
                          title: "REPORTE DE INCIDENCIAS",
                          filename: "Reporte de incidencias",
                          text: "Descargar Excel"
                        },
                        "pageLength",
                        ]
                    });
                    $('#tablaIncidenciasNoAprobadas').DataTable({
                        fixedColumns: true,
                        "scrollX": true,
                        "language": {
                        "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json",
                        },
                        dom: "Bfrtip",
                        "lengthMenu": [[10, 25, 50, -1], ["Mostrar 10", "Mostrar 25", "Mostrar 50", "Mostrar Todo"]],
                        buttons: [ {
                          extend: "excel",
                          title: "REPORTE DE INCIDENCIAS",
                          filename: "Reporte de incidencias",
                          text: "Descargar Excel"
                        },
                        "pageLength",
                        ]
                    });
                    $( "#txtEmpleadoNombre" ).change(function() {
                      datosIncidenciaEmpleado()
                    });
                    if(isNomina){
                        document.getElementById("muestraCambioFijos").innerHTML = "";
                        $('#ReporteGeneral').DataTable().clear();
                        $('#ReporteGeneral').DataTable().destroy();
                        muestraNomina();
                        $('#tablaNomina').DataTable({
                        fixedColumns: true,
                        "scrollX": true,
                        "language": {
                        "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json",
                        },
                        dom: "Bfrtip",
                        "lengthMenu": [[10, 25, 50, -1], ["Mostrar 10", "Mostrar 25", "Mostrar 50", "Mostrar Todo"]],
                        buttons: [ {
                            extend: "excel",
                            title: "REPORTE DE ENTRADAS",
                            filename: "Reporte de Entradas",
                            text: "Descargar Excel"
                        },
                        "pageLength",
                        ]
                        });
                        $('#tablaNominaSalidas').DataTable({
                        fixedColumns: true,
                        "scrollX": true,
                        "language": {
                        "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json",
                        },
                        dom: "Bfrtip",
                        "lengthMenu": [[10, 25, 50, -1], ["Mostrar 10", "Mostrar 25", "Mostrar 50", "Mostrar Todo"]],
                        buttons: [ {
                            extend: "excel",
                            title: "REPORTE DE SALIDAS",
                            filename: "Reporte de salidas",
                            text: "Descargar Excel"
                        },
                        "pageLength",
                        ]
                        });
                        
                        $("#ReporteGeneral").DataTable({
                        fixedColumns: true,
                        "scrollX": true,
                        "language": {
                        "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json",
                        },
                        dom: "Bfrtip",
                        "lengthMenu": [[10, 25, 50, -1], ["Mostrar 10", "Mostrar 25", "Mostrar 50", "Mostrar Todo"]],
                        buttons: [ {
                            extend: "excel",
                            title: "REPORTE GENERAL DE NOMINA",
                            filename: "Reporte general nomina",
                            text: "Descargar Excel"
                        },
                        "pageLength",
                        ]
                        });
                    }
                    
                    // setTimeout(function(){
                    //     window.location.reload();
                    //  }, 3000);
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    console.log(XMLHttpRequest.responseText)
                }
            });
        }
      });


    
}

function comboDepartamentosIncidencias(){
    jQuery.ajax({
        url: "ajax/departamentosRH_incidencias.php",
        method: 'POST',
        async: false,
        dataType: 'JSON',
        data:{
        },
        success: function (data) {
            data.forEach(departamento => {
                $("#txtDepartamento").append(
                    `
                    <option value="${departamento.idDepartamento}">${departamento.nombreDepartamento}</option>
                    `
                )
            }

            );
            
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            console.log("not ok")
        }
    });
}

function readRecords_incidencias() {
    var resultado;
        jQuery.ajax({
            url: "ajax/readRecords_empleados_incidencias.php",
            method: 'POST',
            async: false,
            dataType: 'JSON',
            data:{
            },
            success: function (data) {
                    $("#txtEmpleadoNombre").append(
                        `<option value="">Seleccione empleado</option>`
                    )
                    data.forEach(empleado => {
                        
                        $("#txtEmpleadoNombre").append(
                            `<option value="${empleado.idEmpleado}">${empleado.apellido_p} ${empleado.apellido_m} ${empleado.Nombre} ${empleado.SegundoNombre}</option>`
                        )
                    }
    
                    );                
                
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                console.log("not ok")
            }
        });
}
function primeraVezSelect(){
    let tipoIncidencia = $( "#txtIncidencia").val();
                switch(tipoIncidencia){
                  case "1":
                    $(".cambioFijo").hide()
                    $(".incidenciaHorarios").hide()
                    $(".horariosEntradaSalida").show()
                    $(".horaSalida").show()
                    if($(".horaSalida").hasClass("col-sm-6")){
                      $(".horaSalida").addClass("col-sm-12")
                      $(".horaSalida").removeClass("col-sm-6")
                    }
                    $(".horaEntrada").hide()
                  break;
                  case "2":
                    $(".cambioFijo").hide()
                    $(".incidenciaHorarios").hide()
                    $(".horariosEntradaSalida").show()
                    $(".horaEntrada").show()
                    if($(".horaEntrada").hasClass("col-sm-6")){
                      $(".horaEntrada").addClass("col-sm-12")
                      $(".horaEntrada").removeClass("col-sm-6")
                    }
                    $(".horaSalida").hide()
                  break;
                  case "3":
                    $(".cambioFijo").hide()
                  $(".incidenciaHorarios").hide()
                    $(".horariosEntradaSalida").hide()
                  break;
                  case "4":
                    $(".cambioFijo").hide()
                    $(".incidenciaHorarios").hide()
                    $(".horariosEntradaSalida").show()
                    $(".horaEntrada").show()
                    if($(".horaEntrada").hasClass("col-sm-6")){
                      $(".horaEntrada").addClass("col-sm-12")
                      $(".horaEntrada").removeClass("col-sm-6")
                    }
                    $(".horaSalida").hide()
                  break;
                  case "5":
                    $(".cambioFijo").hide()
                    $(".incidenciaHorarios").hide()
                    $(".horariosEntradaSalida").show()
                    $(".horaSalida").show()
                    if($(".horaSalida").hasClass("col-sm-6")){
                      $(".horaSalida").addClass("col-sm-12")
                      $(".horaSalida").removeClass("col-sm-6")
                    }
                    $(".horaEntrada").hide()
                  break;
                  case "6":
                    $(".cambioFijo").show();
                    $(".incidenciaHorarios").show()
                    $(".agregarEmpleadoNormal").hide()
                    $(".horariosEntradaSalida").hide()
                  break;
                }
}

function validaFechaParaInsertar(txtFechaInicio){
    let retrunValid = false;
    let fechaHoy = new Date();
    let fechaInciencia = new Date(txtFechaInicio.replace(/-/g, '\/'));
    let difference = fechaHoy.getTime() - fechaInciencia.getTime();
    let TotalDays = Math.floor(difference / (1000 * 3600 * 24));
    if(TotalDays < 2){
        retrunValid = true
    }
    return retrunValid;
}
/* INCIDENCIAS */

/* NOMINA FUNCIONES */
function muestraNomina() {
    // PRUEBA DE NOMINA OPTIMIZADA
    let idPeriodo = $("#nominaReporte").val()
    $(".tablaNomina").children().remove()
                            $(".tablaNomina").append(
                                `
                                <table id="tablaNomina" class="display" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Empleado</th>
                                            <th>Tipo registro</th>
                                            <th>fecha y hora</th>
                                            <th>Criterio</th>
                                            <th>Comentario</th>
                                            <th>Incidencia status</th>
                                            <!--<th>Acciones</th>-->
                                        </tr>
                                    </thead>
                                    <tbody class="dataNomina">
                                    </tbody>
                                </table>
                                `
                            );
                            $(".tablaNominaSalidas").children().remove()
                            $(".tablaNominaSalidas").append(
                                `
                                <table id="tablaNominaSalidas" class="display" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Empleado</th>
                                            <th>Tipo registro</th>
                                            <th>fecha y hora</th>
                                            <th>Criterio</th>
                                            <th>Comentario</th>
                                            <th>Incidencia status</th>
                                            <!--<th>Acciones</th>-->
                                        </tr>
                                    </thead>
                                    <tbody class="dataNominaSalidas">
                                    </tbody>
                                </table>
                                `
                            );
    jQuery.ajax({
        url: "ajax/readRecords_reporteNomina.php",
        method: 'POST',
        async: false,
        dataType: 'JSON',
        data:{
            tipoIncidenciaRevisar:1,
            idPeriodo:idPeriodo
        },
        success: function (data) {
            var persona = 0;
            var personaInfo = data;
            var retardosPrueba = 0;
            var correctoPrueba = 0;
            var faltaPrueba =0;
            if(data[0].status == undefined){
                var actualEntrada;
                var actualSalida;
                data.forEach(reporte => {
                    if(reporte.tipoChecada == 1){
                        if(persona > 0 && (personaInfo[persona-1].checador != reporte.checador)){
                            $(".pruebaRetardos").append(
                                `
                                <tr>
                                    <td>${personaInfo[persona-1].nombreEmpleado}</td>
                                    <td>${correctoPrueba}</td>
                                    <td>${retardosPrueba}</td>
                                    <td>${faltaPrueba}</td>
                                </tr>`
                            )
                            retardosPrueba = 0;
                            correctoPrueba = 0;
                            faltaPrueba =0;
                        }
                        var criterio;
                        //var horario = horarioEmpleado(reporte.checador);
                        var horario = reporte.entrada;
                        var fechaHoraCheador = new Date(reporte.fechaHora)
                        var noAplicaHorario = "";
                        // if(reporte.fecha == actualEntrada){
                        //     var horarioEntradaEmpleado = new Date(reporte.fecha + " " + horario[0].entradaDos) 
                        // }else{
                        //     var horarioEntradaEmpleado = new Date(reporte.fecha + " " + horario[0].entrada) 
                        // }
                        if(reporte.tipoIncidencia != undefined && reporte.tipoIncidencia == 6){
                            //alert("cambio de horario")
                        }

                        if(reporte.tipoIncidencia != undefined && reporte.tipoIncidencia == 6){
                            var diaChecadaNombre = fechaHoraCheador.toLocaleDateString("ES", { weekday: 'long' });
                            var horaiosIncidencia = JSON.parse(reporte.motivoIncidencia)
                            switch (diaChecadaNombre){
                                case "lunes":
                                    var horarioEntradaEmpleado = new Date(reporte.fecha + " " + horaiosIncidencia[0].inicioLunes)
                                    break;
                                case "martes":
                                    var horarioEntradaEmpleado = new Date(reporte.fecha + " " + horaiosIncidencia[1].inicioMartes)
                                    break;
                                case "miércoles":
                                    var horarioEntradaEmpleado = new Date(reporte.fecha + " " + horaiosIncidencia[2].inicioMiercoles)
                                    break;
                                case "jueves":
                                    var horarioEntradaEmpleado = new Date(reporte.fecha + " " + horaiosIncidencia[3].inicioJueves)
                                    break;
                                case "viernes":
                                    var horarioEntradaEmpleado = new Date(reporte.fecha + " " + horaiosIncidencia[4].inicioViernes)
                                    break;
                                case "sábado":
                                    var horarioEntradaEmpleado = new Date(reporte.fecha + " " + horaiosIncidencia[5].inicioSabado)
                                    break;
                                case "domingo":
                                    var horarioEntradaEmpleado = new Date(reporte.fecha + " " + horaiosIncidencia[6].inicioDomingo)
                                    break;

                            }
                            if(horarioEntradaEmpleado.getHours() == 0){
                                if(diaChecadaNombre == "viernes"){
                                    var horarioEntradaEmpleado = new Date(reporte.fecha + " " + reporte.entradaViernes)
                                }else{
                                    if(fechaHoraCheador.getHours() >= 8 && fechaHoraCheador.getHours() < 15){
                                        var horarioEntradaEmpleado = new Date(reporte.fecha + " " + reporte.entrada)
                                    }else
                                    {
                                        var horarioEntradaEmpleado = new Date(reporte.fecha + " " + reporte.entradaDos) 
                                    }
                                }
                                
                            }
                        }else{
                            var diaChecadaNombre = fechaHoraCheador.toLocaleDateString("ES", { weekday: 'long' });
                            if(diaChecadaNombre == "viernes"){
                                var horarioEntradaEmpleado = new Date(reporte.fecha + " " + reporte.entradaViernes)
                            }else{
                                if(fechaHoraCheador.getHours() >= 8 && fechaHoraCheador.getHours() < 15){
                                    var horarioEntradaEmpleado = new Date(reporte.fecha + " " + reporte.entrada)
                                }else
                                {
                                    var horarioEntradaEmpleado = new Date(reporte.fecha + " " + reporte.entradaDos) 
                                }
                            }
                            
                        }
                        
                        var diferencia = (fechaHoraCheador.getTime() - horarioEntradaEmpleado.getTime());
                        var diferenciaMins =  (((diferencia % 86400000) % 3600000) / 60000);
                        var final = Math.abs(Math.round(diferencia));
                        var param = reporte;
                        if(diferenciaMins <= 0 || diferenciaMins < 11){
                            criterio = "CORRECTO";
                            correctoPrueba++;
                        }else{
                            if(diferenciaMins < 21){
                                criterio = "RETARDO";
                                //SI LA INCIDENCIA ESTÁ APROBADA
                                if(reporte.incidenciaStatus == 1){

                                }else{
                                    retardosPrueba++;  
                                }
                                
                            }else{
                                criterio = "FALTA";
                                //SI LA INCIDENCIA ESTÁ APROBADA
                                if(reporte.incidenciaStatus == 1){

                                }else{
                                    faltaPrueba++;
                                }
                                

                            }
                            
                        }
                        $(".dataNomina").append(
                            `<tr>
                                <td>${reporte.nombreEmpleado}</td>
                                <td>${reporte.tipoChecada == 1 ? 'ENTRADA' : 'SALIDA'}</td>
                                <td>${reporte.fechaHora}</td>
                                <td class="criteriosEntrada">${criterio}</td>
                                <td>${reporte.incidenciaAsociada != "" ? "<a href='#' onclick='verIncidencia("+reporte.incidenciaAsociada+","+reporte.idRegistro+")' data-bs-toggle='modal' data-bs-target='#modalIncidencia'>Incidencia asociada</a>" : ""}</td>
                                <td class="incidencia-status ${reporte.incidenciaStatus == 1 && (criterio == "RETARDO" || criterio == "FALTA") ? "incidencia-aprobada" : ""}">${reporte.incidenciaStatus == 1 && reporte.incidenciaStatus != "" && (criterio == "RETARDO" || criterio == "FALTA") ? "APROBADA" : reporte.incidenciaStatus == 0 && reporte.incidenciaStatus != "" && (criterio == "RETARDO" || criterio == "FALTA") ? "NO APROBADA" : "" }</td>
                                <!--<td>
                                    
                                    <button class=" btn-success borrar" onclick="deleteIncidencia(${reporte.idRegistro})"><i class="fa-solid fa-trash"></i></button>
                                </td>-->
                             </tr>`
                        )
                        actualEntrada = reporte.fecha;
                    }else{
                        var criterio;
                        var horario = reporte.salida;
                        var fechaHoraCheador = new Date(reporte.fechaHora)
                        if(reporte.fecha == actualSalida){
                            var horarioSalidaEmpleado = new Date(reporte.fecha + " " + reporte.salidaDos)
                        }else{
                            var horarioSalidaEmpleado = new Date(reporte.fecha + " " + reporte.salida)
                        }
                        var diferencia = (fechaHoraCheador.getTime() - horarioSalidaEmpleado.getTime());
                        var diferenciaMins =  Math.round(((diferencia % 86400000) % 3600000) / 60000);;
                        var final = Math.abs(Math.round(diferencia));
                        var param = reporte;
                        if(diferenciaMins < 0){
                            criterio = "CORRECTO";
                        }else{
                            criterio = "SALIDA ANTES DE HORARIO";
                        }
                        $(".dataNomina").append(
                            `<tr>
                                <td>${reporte.nombreEmpleado}</td>
                                <td>${reporte.tipoChecada == 1 ? 'ENTRADA' : 'SALIDA'}</td>
                                <td>${reporte.fechaHora}</td>
                                <td>${criterio}</td>
                                <td>${reporte.comentario}</td>
                                <td class="${reporte.incidenciaStatus == 1 ? "incidencia-aprobada" : ""}">${reporte.incidenciaStatus == 1 && reporte.incidenciaStatus != "" ? "APROBADA" : reporte.incidenciaStatus == 0 && reporte.incidenciaStatus != "" ? "NO APROBADA" : "" }</td>
                                <!--<td>
                                    
                                    <button class=" btn-success borrar" onclick="deleteIncidencia(${reporte.idRegistro})"><i class="fa-solid fa-trash"></i></button>
                                </td>-->
                             </tr>`
                        )   
                        actualSalida = reporte.fecha;                         
                    }

                    
                    if(persona > 0 && (personaInfo[persona-1].checador != reporte.checador)){
                        
                    }
                    persona++;
                    




                }

                );
            }
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            console.log("not ok")
        }
    });

    jQuery.ajax({
        url: "ajax/readRecords_reporteNomina.php",
        method: 'POST',
        async: false,
        dataType: 'JSON',
        data:{
            tipoIncidenciaRevisar:2,
            idPeriodo:idPeriodo
        },
        success: function (data) {
            
            if(data[0].status == undefined){
                var actualEntrada;
                var actualSalida;
                data.forEach(reporte => {
                    if(reporte.tipoChecada == 2){
                        var criterio;
                        //var horario = horarioEmpleado(reporte.checador);
                        var fechaHoraCheador = new Date(reporte.fechaHora)
                        // if(reporte.fecha == actualEntrada){
                        //     var horarioEntradaEmpleado = new Date(reporte.fecha + " " + horario[0].entradaDos) 
                        // }else{
                        //     var horarioEntradaEmpleado = new Date(reporte.fecha + " " + horario[0].entrada) 
                        // }
                        if(reporte.tipoIncidencia != undefined && reporte.tipoIncidencia == 6){
                            var diaChecadaNombre = fechaHoraCheador.toLocaleDateString("ES", { weekday: 'long' });
                            var horaiosIncidencia = JSON.parse(reporte.motivoIncidencia)
                            switch (diaChecadaNombre){
                                case "lunes":
                                    var horarioEntradaEmpleado = new Date(reporte.fecha + " " + horaiosIncidencia[0].finLunes)
                                    break;
                                case "martes":
                                    var horarioEntradaEmpleado = new Date(reporte.fecha + " " + horaiosIncidencia[1].finMartes)
                                    break;
                                case "miércoles":
                                    var horarioEntradaEmpleado = new Date(reporte.fecha + " " + horaiosIncidencia[2].finMiercoles)
                                    break;
                                case "jueves":
                                    var horarioEntradaEmpleado = new Date(reporte.fecha + " " + horaiosIncidencia[3].finJueves)
                                    break;
                                case "viernes":
                                    var horarioEntradaEmpleado = new Date(reporte.fecha + " " + horaiosIncidencia[4].finViernes)
                                    break;
                                case "sábado":
                                    var horarioEntradaEmpleado = new Date(reporte.fecha + " " + horaiosIncidencia[5].finSabado)
                                    break;
                                case "domingo":
                                    var horarioEntradaEmpleado = new Date(reporte.fecha + " " + horaiosIncidencia[6].finDomingo)
                                    break;

                            }
                            if(horarioEntradaEmpleado.getHours() == 0){
                                if(diaChecadaNombre == "viernes"){
                                    var horarioEntradaEmpleado = new Date(reporte.fecha + " " + reporte.salidaViernes)
                                }else{
                                    if(fechaHoraCheador.getHours() >= 8 && fechaHoraCheador.getHours() < 15){
                                        var horarioEntradaEmpleado = new Date(reporte.fecha + " " + reporte.salida)
                                    }else
                                    {
                                        var horarioEntradaEmpleado = new Date(reporte.fecha + " " + reporte.salidaDos) 
                                    }
                                }
                                
                            }
                        }else{
                            var diaChecadaNombre = fechaHoraCheador.toLocaleDateString("ES", { weekday: 'long' });
                            if(diaChecadaNombre == "viernes"){
                                var horarioEntradaEmpleado = new Date(reporte.fecha + " " + reporte.salidaViernes)
                            }else{
                                if(fechaHoraCheador.getHours() >= 14 && fechaHoraCheador.getHours() < 19){
                                    var horarioEntradaEmpleado = new Date(reporte.fecha + " " + reporte.salida)
                                }else
                                {
                                    var horarioEntradaEmpleado = new Date(reporte.fecha + " " + reporte.salidaDos) 
                                }
                            }
                            
                        }
                        
                        
                        var diferencia = (fechaHoraCheador.getTime() - horarioEntradaEmpleado.getTime());
                        var diferenciaMins =  Math.round(((diferencia % 86400000) % 3600000) / 60000);;
                        var final = Math.abs(Math.round(diferencia));
                        var param = reporte;
                        if(diferenciaMins >= 0){
                            criterio = "CORRECTO";
                        }else{
                            criterio = "SALIDA ANTES DE HORARIO";
                        }
                            
                    
                        $(".dataNominaSalidas").append(
                            `<tr>
                                <td>${reporte.nombreEmpleado}</td>
                                <td>${reporte.tipoChecada == 1 ? 'ENTRADA' : 'SALIDA'}</td>
                                <td>${reporte.fechaHora}</td>
                                <td class="criteriosSalida">${criterio}</td>
                                <td>${reporte.incidenciaAsociada != "" ? "<a href='#' onclick='verIncidencia("+reporte.incidenciaAsociada+","+reporte.idRegistro+")' data-bs-toggle='modal' data-bs-target='#modalIncidencia'>Incidencia asociada</a>" : ""}</td>
                                <td class="${reporte.incidenciaStatus == 1 ? "incidencia-aprobada" : ""}">${reporte.incidenciaStatus == 1 && reporte.incidenciaStatus != "" ? "APROBADA" : reporte.incidenciaStatus == 0 && reporte.incidenciaStatus != "" ? "NO APROBADA" : "" }</td>
                                <!--<td>
                                    
                                    <button class=" btn-success borrar" onclick="deleteIncidencia(${reporte.idRegistro})"><i class="fa-solid fa-trash"></i></button>
                                </td>-->
                             </tr>`
                        )
                        actualEntrada = reporte.fecha;
                    }else{
                        var criterio;
                        //var horario = horarioEmpleado(reporte.checador);
                        var fechaHoraCheador = new Date(reporte.fechaHora)
                        if(reporte.fecha == actualSalida){
                            var horarioSalidaEmpleado = new Date(reporte.fecha + " " + reporte.salidaDos)
                        }else{
                            var horarioSalidaEmpleado = new Date(reporte.fecha + " " + reporte.salida)
                        }
                        var diferencia = (fechaHoraCheador.getTime() - horarioSalidaEmpleado.getTime());
                        var diferenciaMins =  Math.round(((diferencia % 86400000) % 3600000) / 60000);;
                        var final = Math.abs(Math.round(diferencia));
                        var param = reporte;
                        if(diferenciaMins < 0){
                            criterio = "CORRECTO";
                        }else{
                            criterio = "SALIDA ANTES DE HORARIO";
                        }
                        $(".dataNomina").append(
                            `<tr>
                                <td>${reporte.nombreEmpleado}</td>
                                <td>${reporte.tipoChecada == 1 ? 'ENTRADA' : 'SALIDA'}</td>
                                <td>${reporte.fechaHora}</td>
                                <td>${criterio}</td>
                                <td>${reporte.comentario}</td>
                                <td class="${reporte.incidenciaStatus == 1 ? "incidencia-aprobada" : ""}">${reporte.incidenciaStatus == 1 && reporte.incidenciaStatus != "" ? "APROBADA" : reporte.incidenciaStatus == 0 && reporte.incidenciaStatus != "" ? "NO APROBADA" : "" }</td>
                                <!--<td>
                                    
                                    <button class=" btn-success borrar" onclick="deleteIncidencia(${reporte.idRegistro})"><i class="fa-solid fa-trash"></i></button>
                                </td>-->
                             </tr>`
                        )   
                        actualSalida = reporte.fecha;                         
                    }

                    
                }

                );
            }
            

            
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            console.log("not ok")
        }
    });
    
    // PRUEBA DE NOMINA OPTIMIZADA
    // jQuery.ajax({
    //     url: "ajax/readRecords_empleados.php",
    //     method: 'POST',
    //     async: false,
    //     dataType: 'JSON',
    //     data:{
    //     },
    //     success: function (data) {
    //         if(data[0].status == undefined){
    //             $(".tablaNomina").children().remove()
    //                         $(".tablaNomina").append(
    //                             `
    //                             <table id="tablaNomina" class="display" style="width:100%">
    //                                 <thead>
    //                                     <tr>
    //                                         <th>Empleado</th>
    //                                         <th>Tipo registro</th>
    //                                         <th>fecha y hora</th>
    //                                         <th>Criterio</th>
    //                                         <th>Comentario</th>
    //                                         <!--<th>Acciones</th>-->
    //                                     </tr>
    //                                 </thead>
    //                                 <tbody class="dataNomina">
    //                                 </tbody>
    //                             </table>
    //                             `
    //                         );
    //                         $(".tablaNominaSalidas").children().remove()
    //                         $(".tablaNominaSalidas").append(
    //                             `
    //                             <table id="tablaNominaSalidas" class="display" style="width:100%">
    //                                 <thead>
    //                                     <tr>
    //                                         <th>Empleado</th>
    //                                         <th>Tipo registro</th>
    //                                         <th>fecha y hora</th>
    //                                         <th>Criterio</th>
    //                                         <th>Comentario</th>
    //                                         <!--<th>Acciones</th>-->
    //                                     </tr>
    //                                 </thead>
    //                                 <tbody class="dataNominaSalidas">
    //                                 </tbody>
    //                             </table>
    //                             `
    //                         );
    //             data.forEach(empleadoBarrido => {
    //                 var empleadoActual = empleadoBarrido.idChecador;
    //                 var retardosPrueba = 0;
    //                 var correctoPrueba = 0;
    //                 var faltaPrueba =0;

    //                 jQuery.ajax({
    //                     url: "ajax/readRecords_reporteNomina.php",
    //                     method: 'POST',
    //                     async: false,
    //                     dataType: 'JSON',
    //                     data:{
    //                         empleadoActual:empleadoActual,
    //                         tipoIncidenciaRevisar:1
    //                     },
    //                     success: function (data) {
                            
    //                         if(data[0].status == undefined){
    //                             var actualEntrada;
    //                             var actualSalida;
    //                             data.forEach(reporte => {
    //                                 if(reporte.tipoChecada == 1){
    //                                     var criterio;
    //                                     var horario = horarioEmpleado(reporte.checador);
    //                                     var fechaHoraCheador = new Date(reporte.fechaHora)
    //                                     // if(reporte.fecha == actualEntrada){
    //                                     //     var horarioEntradaEmpleado = new Date(reporte.fecha + " " + horario[0].entradaDos) 
    //                                     // }else{
    //                                     //     var horarioEntradaEmpleado = new Date(reporte.fecha + " " + horario[0].entrada) 
    //                                     // }
    //                                     if(fechaHoraCheador.getHours() >= 8 && fechaHoraCheador.getHours() < 15){
    //                                         var horarioEntradaEmpleado = new Date(reporte.fecha + " " + horario[0].entrada)
    //                                     }else
    //                                     {
    //                                         var horarioEntradaEmpleado = new Date(reporte.fecha + " " + horario[0].entradaDos) 
    //                                     }
                                        
    //                                     var diferencia = (fechaHoraCheador.getTime() - horarioEntradaEmpleado.getTime());
    //                                     var diferenciaMins =  Math.round(((diferencia % 86400000) % 3600000) / 60000);;
    //                                     var final = Math.abs(Math.round(diferencia));
    //                                     var param = reporte;
    //                                     if(diferenciaMins <= 0 || diferenciaMins < 10){
    //                                         criterio = "CORRECTO";
    //                                         correctoPrueba++;
    //                                     }else{
    //                                         if(diferenciaMins < 20){
    //                                             criterio = "RETARDO";
    //                                             retardosPrueba++;
    //                                         }else{
    //                                             criterio = "FALTA";
    //                                             faltaPrueba++;
            
    //                                         }
                                            
    //                                     }
    //                                     $(".dataNomina").append(
    //                                         `<tr>
    //                                             <td>${reporte.nombreEmpleado}</td>
    //                                             <td>${reporte.tipoChecada == 1 ? 'ENTRADA' : 'SALIDA'}</td>
    //                                             <td>${reporte.fechaHora}</td>
    //                                             <td class="criteriosEntrada">${criterio}</td>
    //                                             <td>${reporte.comentario}</td>
    //                                             <!--<td>
                                                    
    //                                                 <button class=" btn-success borrar" onclick="deleteIncidencia(${reporte.idRegistro})"><i class="fa-solid fa-trash"></i></button>
    //                                             </td>-->
    //                                          </tr>`
    //                                     )
    //                                     actualEntrada = reporte.fecha;
    //                                 }else{
    //                                     var criterio;
    //                                     var horario = horarioEmpleado(reporte.checador);
    //                                     var fechaHoraCheador = new Date(reporte.fechaHora)
    //                                     if(reporte.fecha == actualSalida){
    //                                         var horarioSalidaEmpleado = new Date(reporte.fecha + " " + horario[0].salidaDos)
    //                                     }else{
    //                                         var horarioSalidaEmpleado = new Date(reporte.fecha + " " + horario[0].salida)
    //                                     }
    //                                     var diferencia = (fechaHoraCheador.getTime() - horarioSalidaEmpleado.getTime());
    //                                     var diferenciaMins =  Math.round(((diferencia % 86400000) % 3600000) / 60000);;
    //                                     var final = Math.abs(Math.round(diferencia));
    //                                     var param = reporte;
    //                                     if(diferenciaMins < 0){
    //                                         criterio = "CORRECTO";
    //                                     }else{
    //                                         criterio = "SALIDA ANTES DE HORARIO";
    //                                     }
    //                                     $(".dataNomina").append(
    //                                         `<tr>
    //                                             <td>${reporte.nombreEmpleado}</td>
    //                                             <td>${reporte.tipoChecada == 1 ? 'ENTRADA' : 'SALIDA'}</td>
    //                                             <td>${reporte.fechaHora}</td>
    //                                             <td>${criterio}</td>
    //                                             <td>${reporte.comentario}</td>
    //                                             <!--<td>
                                                    
    //                                                 <button class=" btn-success borrar" onclick="deleteIncidencia(${reporte.idRegistro})"><i class="fa-solid fa-trash"></i></button>
    //                                             </td>-->
    //                                          </tr>`
    //                                     )   
    //                                     actualSalida = reporte.fecha;                         
    //                                 }
            
                                    
    //                             }
                
    //                             );
    //                         }
                            
            
                            
    //                     },
    //                     error: function (XMLHttpRequest, textStatus, errorThrown) {
    //                         console.log("not ok")
    //                     }
    //                 });
    //                 $(".pruebaRetardos").append(
    //                     `
    //                     <tr>
    //                         <td>${empleadoBarrido.apellido_p} ${empleadoBarrido.apellido_m} ${empleadoBarrido.Nombre} ${empleadoBarrido.SegundoNombre}</td>
    //                         <td>${correctoPrueba}</td>
    //                         <td>${retardosPrueba}</td>
    //                         <td>${faltaPrueba}</td>
    //                     </tr>`
    //                 )
                    

    //             });
    //             data.forEach(empleadoBarrido => {
    //                 var empleadoActual = empleadoBarrido.idChecador;

    //                 jQuery.ajax({
    //                     url: "ajax/readRecords_reporteNomina.php",
    //                     method: 'POST',
    //                     async: false,
    //                     dataType: 'JSON',
    //                     data:{
    //                         empleadoActual:empleadoActual,
    //                         tipoIncidenciaRevisar:2
    //                     },
    //                     success: function (data) {
                            
    //                         if(data[0].status == undefined){
    //                             var actualEntrada;
    //                             var actualSalida;
    //                             data.forEach(reporte => {
    //                                 if(reporte.tipoChecada == 2){
    //                                     var criterio;
    //                                     var horario = horarioEmpleado(reporte.checador);
    //                                     var fechaHoraCheador = new Date(reporte.fechaHora)
    //                                     // if(reporte.fecha == actualEntrada){
    //                                     //     var horarioEntradaEmpleado = new Date(reporte.fecha + " " + horario[0].entradaDos) 
    //                                     // }else{
    //                                     //     var horarioEntradaEmpleado = new Date(reporte.fecha + " " + horario[0].entrada) 
    //                                     // }
    //                                     if(fechaHoraCheador.getHours() >= 14 && fechaHoraCheador.getHours() < 19){
    //                                         var horarioEntradaEmpleado = new Date(reporte.fecha + " " + horario[0].salida)
    //                                     }else
    //                                     {
    //                                         var horarioEntradaEmpleado = new Date(reporte.fecha + " " + horario[0].salidaDos) 
    //                                     }
                                        
    //                                     var diferencia = (fechaHoraCheador.getTime() - horarioEntradaEmpleado.getTime());
    //                                     var diferenciaMins =  Math.round(((diferencia % 86400000) % 3600000) / 60000);;
    //                                     var final = Math.abs(Math.round(diferencia));
    //                                     var param = reporte;
    //                                     if(diferenciaMins >= 0){
    //                                         criterio = "CORRECTO";
    //                                     }else{
    //                                         criterio = "SALIDA ANTES DE HORARIO";
    //                                     }
                                            
                                    
    //                                     $(".dataNominaSalidas").append(
    //                                         `<tr>
    //                                             <td>${reporte.nombreEmpleado}</td>
    //                                             <td>${reporte.tipoChecada == 1 ? 'ENTRADA' : 'SALIDA'}</td>
    //                                             <td>${reporte.fechaHora}</td>
    //                                             <td class="criteriosSalida">${criterio}</td>
    //                                             <td>${reporte.comentario}</td>
    //                                             <!--<td>
                                                    
    //                                                 <button class=" btn-success borrar" onclick="deleteIncidencia(${reporte.idRegistro})"><i class="fa-solid fa-trash"></i></button>
    //                                             </td>-->
    //                                          </tr>`
    //                                     )
    //                                     actualEntrada = reporte.fecha;
    //                                 }else{
    //                                     var criterio;
    //                                     var horario = horarioEmpleado(reporte.checador);
    //                                     var fechaHoraCheador = new Date(reporte.fechaHora)
    //                                     if(reporte.fecha == actualSalida){
    //                                         var horarioSalidaEmpleado = new Date(reporte.fecha + " " + horario[0].salidaDos)
    //                                     }else{
    //                                         var horarioSalidaEmpleado = new Date(reporte.fecha + " " + horario[0].salida)
    //                                     }
    //                                     var diferencia = (fechaHoraCheador.getTime() - horarioSalidaEmpleado.getTime());
    //                                     var diferenciaMins =  Math.round(((diferencia % 86400000) % 3600000) / 60000);;
    //                                     var final = Math.abs(Math.round(diferencia));
    //                                     var param = reporte;
    //                                     if(diferenciaMins < 0){
    //                                         criterio = "CORRECTO";
    //                                     }else{
    //                                         criterio = "SALIDA ANTES DE HORARIO";
    //                                     }
    //                                     $(".dataNomina").append(
    //                                         `<tr>
    //                                             <td>${reporte.nombreEmpleado}</td>
    //                                             <td>${reporte.tipoChecada == 1 ? 'ENTRADA' : 'SALIDA'}</td>
    //                                             <td>${reporte.fechaHora}</td>
    //                                             <td>${criterio}</td>
    //                                             <td>${reporte.comentario}</td>
    //                                             <!--<td>
                                                    
    //                                                 <button class=" btn-success borrar" onclick="deleteIncidencia(${reporte.idRegistro})"><i class="fa-solid fa-trash"></i></button>
    //                                             </td>-->
    //                                          </tr>`
    //                                     )   
    //                                     actualSalida = reporte.fecha;                         
    //                                 }
            
                                    
    //                             }
                
    //                             );
    //                         }
                            
            
                            
    //                     },
    //                     error: function (XMLHttpRequest, textStatus, errorThrown) {
    //                         console.log("not ok")
    //                     }
    //                 });


    //             });
    //         }
            

            
    //     },
    //     error: function (XMLHttpRequest, textStatus, errorThrown) {
    //         console.log("not ok")
    //     }
    // });


    var retardos = 0;
    var correctos = 0;
    var faltas = 0;
    $( "td.criteriosEntrada" ).each(function( index ) {
        if($( this ).text() == "RETARDO"){
            retardos++;
        }
        if($( this ).text() == "CORRECTO"){
            correctos++;
        }
        if($( this ).text() == "FALTA"){
            faltas++;
        }
        var c = $(this).children();
      });
      $(".correctos").text(correctos)
      $(".retardos").text(retardos)
      $(".faltas").text(faltas)
}

function horarioEmpleado(idChecador) {
    var resultado;
        jQuery.ajax({
            url: "ajax/readRecords_horarioEmpleado.php",
            method: 'POST',
            async: false,
            dataType: 'JSON',
            data:{
                idChecador:idChecador
            },
            success: function (data) {
                resultado = data;
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                console.log("not ok")
            }
        });
        return resultado;
}
function UploadProcess() {
    let inicioPeriodo = $("#txtInicioPeriodo").val();
    let finPeriodo = $("#txtFinPeriodo").val();
    if(inicioPeriodo == "" || finPeriodo == ""){
        swal("Las fechas de inicio y fin no pueden ir vacíos.", "", "info");
        return 0;
    }
    let dateInicio = new Date(inicioPeriodo);
    dateInicio.setDate(dateInicio.getDate()+1)
    let dateInicioParaAgregar = dateInicio.getFullYear() + "-" + ((dateInicio.getMonth()+1) > 9 ? dateInicio.getMonth()+1 : "0"+(dateInicio.getMonth()+1)) + "-" + dateInicio.getDate();;

    let dateFin = new Date(finPeriodo);
    dateFin.setDate(dateFin.getDate()+1)
    let dateFinParaAgregar = dateFin.getFullYear() + "-" + ((dateFin.getMonth()+1) > 9 ? dateFin.getMonth()+1 : "0"+(dateFin.getMonth()+1)) + "-" + dateFin.getDate();;

    

    let diff = dateFin.getTime() - dateInicio.getTime();
    let diffDays = Math.ceil(diff / (1000 * 3600 * 24));
    let arrayFechas = [];
    let dateToPush;
    dateToPush = dateInicio.getFullYear() + "-" + ((dateInicio.getMonth()+1) > 9 ? dateInicio.getMonth()+1 : "0"+(dateInicio.getMonth()+1)) + "-" + dateInicio.getDate();
    arrayFechas.push(dateToPush)
    for (let x = 1; x <= diffDays; x++){
        dateInicio.setDate(dateInicio.getDate() + 1);
        dateToPush = dateInicio.getFullYear() + "-" + ((dateInicio.getMonth()+1) > 9 ? dateInicio.getMonth()+1 : "0"+(dateInicio.getMonth()+1)) + "-" + dateInicio.getDate();
        arrayFechas.push(dateToPush)
    }

    let idPeriodo = agregaNuevoPeriodo(arrayFechas,dateInicioParaAgregar,dateFinParaAgregar);

    //Reference the FileUpload element.
    var fileUpload = document.getElementById("fileUpload");

    //Validate whether File is valid Excel file.
    var regex = /^([a-zA-Z0-9\s_\\.\-:])+(.xls|.xlsx)$/;
    if (regex.test(fileUpload.value.toLowerCase())) {
        if (typeof (FileReader) != "undefined") {
            var reader = new FileReader();

            //For Browsers other than IE.
            if (reader.readAsBinaryString) {
                reader.onload = function (e) {
                    GetTableFromExcel(e.target.result, idPeriodo);
                };
                reader.readAsBinaryString(fileUpload.files[0]);
            } else {
                //For IE Browser.
                reader.onload = function (e) {
                    var data = "";
                    var bytes = new Uint8Array(e.target.result);
                    for (var i = 0; i < bytes.byteLength; i++) {
                        data += String.fromCharCode(bytes[i]);
                    }
                    GetTableFromExcel(data, idPeriodo);
                };
                reader.readAsArrayBuffer(fileUpload.files[0]);
            }
        } else {
            alert("This browser does not support HTML5.");
        }
    } else {
        alert("Please upload a valid Excel file.");
    }
};

function agregaNuevoPeriodo(arrayFechas, fechaInicio, fechaFin){
    let idPeriodo;
    jQuery.ajax({
        url: "ajax/agrega_periodo.php",
        method: 'POST',
        async: false,
        dataType: 'JSON',
        data:{
            fechas:arrayFechas,
            fechaInicio:fechaInicio,
            fechaFin:fechaFin
        },
        success: function (data) {
            idPeriodo = data;
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            console.log(XMLHttpRequest.responseText)
        }
    });
    return idPeriodo;
}
function GetTableFromExcel(data, idPeriodo) {
    $("#modalCarga").modal("show");
    //Read the Excel File data in binary
    var workbook = XLSX.read(data, {
        type: 'binary'
    });

    //get the name of First Sheet.
    var Sheet = workbook.SheetNames[0];

    //Read all rows from First Sheet into an JSON array.
    var excelRows = XLSX.utils.sheet_to_row_object_array(workbook.Sheets[Sheet]);

    //Create a HTML Table element.
    var myTable  = document.createElement("table");
    myTable.border = "1";

    //Add the header row.
    var row = myTable.insertRow(-1);

    //Add the header cells.
    var headerCell = document.createElement("TH");
    headerCell.innerHTML = "Id";
    row.appendChild(headerCell);

    headerCell = document.createElement("TH");
    headerCell.innerHTML = "Name";
    row.appendChild(headerCell);

    headerCell = document.createElement("TH");
    headerCell.innerHTML = "Country";
    row.appendChild(headerCell);
    
    headerCell = document.createElement("TH");
    headerCell.innerHTML = "Age";
    row.appendChild(headerCell);
    
    headerCell = document.createElement("TH");
    headerCell.innerHTML = "Date";
    row.appendChild(headerCell);
     
     headerCell = document.createElement("TH");
    headerCell.innerHTML = "Gender";
    row.appendChild(headerCell);


    //Add the data rows from Excel file.
    var registro = [];
    for (var i = 0; i < excelRows.length; i++) {
        registro.push([excelRows[i].idChecador,excelRows[i].tipoChecada,excelRows[i].fechaHora,'',excelRows[i].checador,idPeriodo])
        
    }
    var aEnviar = JSON.stringify(registro);
    jQuery.ajax({
        url: "ajax/cargaReporte.php",
        method: 'POST',
        async: false,
        dataType: 'JSON',
        data:({aEnviar : aEnviar }),
        success: function (data) {
            swal("Reporte importado correctamente, espere mientras se calculan los reportes", "", "success");
            $("#modalChecador").modal("hide");
            setTimeout(function(){
                location.reload();
            }, 4000);
            

        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            console.log(XMLHttpRequest.responseText)
        }
    });
    

    $("#modalCarga").modal("hide");
};
function verIncidencia(idIncidencia, idRegistroNomina){
    $("#infoIncidenciaForm").trigger("reset");
    jQuery.ajax({
        url: "ajax/readRecords_incidencias.php",
        method: 'POST',
        async: false,
        dataType: 'JSON',
        data:{
            idIncidencia : idIncidencia,
            idRegistroNomina : idRegistroNomina 
        },
        success: function (data) {
            //var dataDesc = data.descriptions.find(el => el.language === languageCalendar);
            var incidenciaNomina = data.find(x => x.idPase === idIncidencia.toString());
            $("#txtIdPase").val(incidenciaNomina.idPase);
            $("#txt_fecha").val(incidenciaNomina.fechaPase);
            $("#txt_empleado").val(incidenciaNomina.nombreEmpleado);
            $("#txt_area").val(incidenciaNomina.departamento);
            $("#txt_entrada").val(incidenciaNomina.entrada);
            $("#txt_salida").val(incidenciaNomina.salida);
            var nombreIncidencia;
            switch(incidenciaNomina.tipoIncidencia){
                case "1":
                    nombreIncidencia = "SALIDA ANTICIPADA";
                break;
                case "2":
                    nombreIncidencia = "LLEGADA TARDE";
                break;
                case "3":
                    nombreIncidencia = "FALTA POR COMISIÓN";
                break;
                case "31":
                    nombreIncidencia = "DAY OFF";
                break;
                case "32":
                    nombreIncidencia = "INCAPACIDAD";
                break;
                case "4":
                    nombreIncidencia = "NO CHECAR ENTRADA";
                break;
                case "5":
                    nombreIncidencia = "NO CHECAR SALIDA";
                break;
                case "6":
                    nombreIncidencia = "CAMBIO FIJO";
                break;
            }
            $("#txt_tipo").val(nombreIncidencia);
            if(incidenciaNomina.tipoIncidencia == "6"){
                document.getElementById("muestraCambioFijos").innerHTML = "";
                $(".motivoInc").addClass("d-none");
                $(".showHorarios").removeClass("d-none");
                let horariosJson = JSON.parse(incidenciaNomina.motivo);
                let horariosStr =`<div class="dataHorario" style="white-space: pre;">
                Lunes : ${horariosJson[0].inicioLunes} - ${horariosJson[0].finLunes}
                Martes : ${horariosJson[1].inicioMartes} - ${horariosJson[1].finMartes}
                Miércoles : ${horariosJson[2].inicioMiercoles} - ${horariosJson[2].finMiercoles}
                Jueves : ${horariosJson[3].inicioJueves} - ${horariosJson[3].finJueves}
                Viernes : ${horariosJson[4].inicioViernes} - ${horariosJson[4].finViernes}
                Sábado : ${horariosJson[5].inicioSabado} - ${horariosJson[5].finSabado}
                Domingo : ${horariosJson[6].inicioDomingo} - ${horariosJson[6].finDomingo}
                </div>
                `;
                $("#muestraCambioFijos").append(horariosStr)

            }else{
                $(".motivoInc").removeClass("d-none");
                $(".showHorarios").addClass("d-none");
                $("#txt_motivo").val(incidenciaNomina.motivo);
                document.getElementById("muestraCambioFijos").innerHTML = "";
            }
            
            $("#txt_fechaRegistro").val(incidenciaNomina.fechaRegistro);
            if(incidenciaNomina.estado == 1){
                $("#txtStatus").val("APROBADA");
                $("#apruebaIncidencia").hide()
            }else{
                $("#txtStatus").val("NO APROBADA");
                $("#apruebaIncidencia").show()
            }
            
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            console.log(XMLHttpRequest.responseText)
        }
    });
}
function muestraPeriodosNomina(){
    
            jQuery.ajax({
                url: "ajax/readRecords_periodosNomina.php",
                method: 'POST',
                async: false,
                dataType: 'JSON',
                data:{
                },
                success: function (data) {
                    data.forEach(periodo => {
                        $(".nominaReporte").append(
                            `<option value="${periodo.periodo}">Periodo #${periodo.periodo} : ${periodo.inicio} - ${periodo.fin}</option>`
                        )
                    }
    
                    );
    
                    
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    console.log("not ok")
                }
            });
}
/* NOMINA FUNCIONES */

/* VACACIONES FUNCIONES */
function actualizaVacaciones(){
    
}
function muestraVacaciones(permiso,idEmpleado){
    if(permiso == 1 || permiso == 2){
        $("#agregaVacaciones").remove()
        $("#actualizaProceVacaciones").remove()
    }
    jQuery.ajax({
        url: "ajax/vacaciones.php",
        method: 'POST',
        async: false,
        dataType: 'JSON',
        data:{
            accion:1,
            permiso:permiso,
            idEmpleado:idEmpleado
        },
        success: function (data) {
            $(".tablaVacaciones").children().remove()
            $(".tablaVacaciones").append(
                `
                <table id="tablaVacaciones" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th>Empleado</th>
                            <th>Dias vacaciones disponibles utilizables</th>
                            <th>Dias vacaciones disponibles no utilizables</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="dataVacaciones">
                    </tbody>
                </table>
                `
            );
            if(data[0].status == undefined){
                var registros = data;
                var contador = 0;
                var contadorActivos = 0;
                var contadorInactivos = 0;
                var utilizables = 0;
                var utilizablesActivos = 0;
                var utilizablesInactivos = 0;
                var noUtilizables = 0;
                var noUtilizablesActivos = 0;
                var noUtilizablesInactivos = 0;
                data.forEach(reporte => {
                    contador++;
                    if(registros[contador] != undefined && registros[contador].NombreEmpleado == reporte.NombreEmpleado){
                        if(reporte.utilizables == 1){
                            utilizables = utilizables + parseInt(reporte.diasPendientes);
                        }else{
                            noUtilizables = noUtilizables + parseInt(reporte.diasPendientes);
                        }
                    }else{
                        if(registros[contador-2] != undefined && registros[contador-2].NombreEmpleado == reporte.NombreEmpleado){
                            if(reporte.utilizables == 1){
                                utilizables = utilizables + parseInt(reporte.diasPendientes);
                            }else{
                                noUtilizables = noUtilizables + parseInt(reporte.diasPendientes);
                            }
                            $(".dataVacaciones").append(
                                `<tr>
                                    <td>${reporte.NombreEmpleado}</td>
                                    <td>${utilizables}</td>
                                    <td>${noUtilizables}</td>
                                    <td><button onclick="infoVacaciones(${reporte.idChecador})">Detalles</button></td>
                                 </tr>`
                            )
                        }else{
                            $(".dataVacaciones").append(
                                `<tr>
                                    <td>${reporte.NombreEmpleado}</td>
                                    <td>${reporte.utilizables == 0 ? '0' : reporte.diasPendientes}</td>
                                    <td>${reporte.utilizables == 0 ? reporte.diasPendientes : '0'}</td>
                                    <td><button onclick="infoVacaciones(${reporte.idChecador})">Detalles</button></td>
                                 </tr>`
                            )
                        }
                        utilizables = 0;
                        noUtilizables = 0;
                    }
                     
                });
                if(permiso == 3){
                    var inactivos = data.filter( empleadoIna => empleadoIna.activo == 0)
                    var activos = data.filter( empleadoIna => empleadoIna.activo == 1)
                    var registrosAct = activos;
                    var registrosInac = inactivos;

                    $(".tablaVacacionesActivos").children().remove()
                    $(".tablaVacacionesActivos").append(
                        `
                        <table id="tablaVacacionesActivos" class="display" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Empleado</th>
                                    <th>Dias vacaciones disponibles utilizables</th>
                                    <th>Dias vacaciones disponibles no utilizables</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="dataVacacionesActivos">
                            </tbody>
                        </table>
                        `
                    );
                    activos.forEach(reporte => {
                        contadorActivos++;
                        if(registrosAct[contadorActivos] != undefined && registrosAct[contadorActivos].NombreEmpleado == reporte.NombreEmpleado){
                            if(reporte.utilizables == 1){
                                utilizablesActivos = utilizablesActivos + parseInt(reporte.diasPendientes);
                            }else{
                                noUtilizablesActivos = noUtilizablesActivos + parseInt(reporte.diasPendientes);
                            }
                        }else{
                            if(registrosAct[contadorActivos-2] != undefined && registrosAct[contadorActivos-2].NombreEmpleado == reporte.NombreEmpleado){
                                if(reporte.utilizables == 1){
                                    utilizablesActivos = utilizablesActivos + parseInt(reporte.diasPendientes);
                                }else{
                                    noUtilizablesActivos = noUtilizablesActivos + parseInt(reporte.diasPendientes);
                                }
                                $(".dataVacacionesActivos").append(
                                    `<tr>
                                        <td>${reporte.NombreEmpleado}</td>
                                        <td>${utilizablesActivos}</td>
                                        <td>${noUtilizablesActivos}</td>
                                        <td><button onclick="infoVacaciones(${reporte.idChecador})">Detalles</button></td>
                                     </tr>`
                                )
                            }else{
                                $(".dataVacacionesActivos").append(
                                    `<tr>
                                        <td>${reporte.NombreEmpleado}</td>
                                        <td>${reporte.utilizables == 0 ? '0' : reporte.diasPendientes}</td>
                                        <td>${reporte.utilizables == 0 ? reporte.diasPendientes : '0'}</td>
                                        <td><button onclick="infoVacaciones(${reporte.idChecador})">Detalles</button></td>
                                     </tr>`
                                )
                            }
                            utilizablesActivos = 0; 
                            noUtilizablesActivos = 0;
                        }
                         
                    });

                    $(".tablaVacacionesInactivos").children().remove()
                    $(".tablaVacacionesInactivos").append(
                        `
                        <table id="tablaVacacionesInactivos" class="display" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Empleado</th>
                                    <th>Dias vacaciones disponibles utilizables</th>
                                    <th>Dias vacaciones disponibles no utilizables</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="dataVacacionesInactivos">
                            </tbody>
                        </table>
                        `
                    );
                    inactivos.forEach(reporte => {
                        contadorInactivos++;
                        if(registrosInac[contadorInactivos] != undefined && registrosInac[contadorInactivos].NombreEmpleado == reporte.NombreEmpleado){
                            if(reporte.utilizables == 1){
                                utilizablesInactivos = utilizablesInactivos + parseInt(reporte.diasPendientes);
                            }else{
                                noUtilizablesInactivos = noUtilizablesInactivos + parseInt(reporte.diasPendientes);
                            }
                        }else{
                            if(registrosInac[contadorInactivos-2] != undefined && registrosInac[contadorInactivos-2].NombreEmpleado == reporte.NombreEmpleado){
                                if(reporte.utilizables == 1){
                                    utilizablesInactivos = utilizablesInactivos + parseInt(reporte.diasPendientes);
                                }else{
                                    noUtilizablesInactivos = noUtilizablesInactivos + parseInt(reporte.diasPendientes);
                                }
                                $(".dataVacacionesInactivos").append(
                                    `<tr>
                                        <td>${reporte.NombreEmpleado}</td>
                                        <td>${utilizablesInactivos}</td>
                                        <td>${noUtilizablesInactivos}</td>
                                        <td><button onclick="infoVacaciones(${reporte.idChecador})">Detalles</button></td>
                                     </tr>`
                                )
                            }else{
                                $(".dataVacacionesInactivos").append(
                                    `<tr>
                                        <td>${reporte.NombreEmpleado}</td>
                                        <td>${reporte.utilizables == 0 ? '0' : reporte.diasPendientes}</td>
                                        <td>${reporte.utilizables == 0 ? reporte.diasPendientes : '0'}</td>
                                        <td><button onclick="infoVacaciones(${reporte.idChecador})">Detalles</button></td>
                                     </tr>`
                                )
                            }
                            utilizablesInactivos = 0; 
                            noUtilizablesInactivos = 0;
                        }
                         
                    });
                }
            }else{
                
            }
            
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            console.log("not ok")
        }
    });
}
function infoVacaciones(idChecador){
    
    
    $("#modalVacasInfo").modal("show")
    $(".InfoVacas").children().remove()
    $(".InfoVacas").append(
        `<table id="tablaVacacionesInfo" class="display table table-bordered" style="width:100%">
        <thead>
            <tr>
                <th># de días</th>
                <th>Año</th>
                <th>¿Utilizables?</th>
            </tr>
        </thead>
        <tbody class="dataVacacionesInfo">
        </tbody>
    </table>`
    )
    jQuery.ajax({
        url: "ajax/infoVacaciones.php",
        method: 'POST',
        async: false,
        dataType: 'JSON',
        data:{idChecador : idChecador },
        success: function (data) {
            data.forEach(infoVacaciones => {
                $(".dataVacacionesInfo").append(
                    `<tr>
                        <td>${infoVacaciones.diasPendientes}</td>
                        <td>${infoVacaciones.anio}</td>
                        <td>${infoVacaciones.utilizables == 0 ? 'NO' : 'SI'}</td>
                    </tr>` 
                )
            });
            
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            console.log(XMLHttpRequest.responseText)
        }
    });


    
}
function getEmpleadoIngreso(idEmpleado,anio){
    var returnEmpleado;
    jQuery.ajax({
        url: "ajax/getRecord_empleados.php",
        method: 'POST',
        async: false,
        data:{
            idEmpleado:idEmpleado
        },
        success: function (data) {
            empleadoInfo = JSON.parse(data)
            returnEmpleadoStr = empleadoInfo[0].Ingreso;
            dateIngresoFull = returnEmpleadoStr + " 00:00:00"
            dateIngreso = new Date(dateIngresoFull)
            dateIngreso.setFullYear(anio)
            dateIngresoAnio = dateIngreso.getFullYear()
            dateIngresoMes = dateIngreso.getMonth()+1
            if(dateIngresoMes < 10){
                dateIngresoMes = "0" + dateIngresoMes;
            }
            dateIngresoDia = dateIngreso.getDate();
            if(dateIngresoDia < 10){
                dateIngresoDia = "0" + dateIngresoDia;
            }
            returnEmpleado = dateIngresoAnio + "-" + dateIngresoMes + "-" + dateIngresoDia; 
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            console.log(XMLHttpRequest.responseText)
        }
    });
    return returnEmpleado;
}

function actualizaDiasConFecha(){
    var fechaDiasActualizaInicio = $("#txtFechasActualizarInicio").val();
    var fechaDiasActualizaFin = $("#txtFechasActualizarFin").val();

    const fechaInicio = new Date(fechaDiasActualizaInicio + " 00:00:00");
    const fechaFin = new Date(fechaDiasActualizaFin + " 00:00:00");
    if(isNaN(fechaInicio.getTime()) || isNaN(fechaFin.getTime())){
        swal("Por favor ingrese fechas válidas", "", "info");
        return;
    }

    let fechaActual = new Date(fechaInicio);
    while (fechaActual <= fechaFin){
        const yyyy = fechaActual.getFullYear();
        const mm = String(fechaActual.getMonth() + 1).padStart(2,'0');
        const dd = String(fechaActual.getDate()).padStart(2,'0');
        let fechaDiasActualiza = yyyy + "-" + mm + "-" + dd;
        $.post("ajax/vacacionesActualizaFecha.php", {
            fechaDiasActualiza:fechaDiasActualiza
        }, function (data, status) {
            swal("Vacaciones actualizadas correctamente", "", "success");
            $("#txtFechasActualizarInicio").val("");
            $("#txtFechasActualizarFin").val("");
            $("#modalAgregaActualiza").modal("hide");
        })
        fechaActual.setDate(fechaActual.getDate() + 1);

    }
}
function addDiasVacaciones(){
    
    var empleado = $("#txtEmpleadoNombre").val();
    var empleadoDatos = empleado.split(",");
    var empleadoChecador = empleadoDatos[1];
    var empleadoId = empleadoDatos[0];
    var diasAgregar = $("#txtDiasAgregar").val();
    var utilizables = $("#txtUtilizables").val()
    var anio = $("#txtAnio").val()
    var anioVacaciones = getEmpleadoIngreso(empleadoId,anio)
    if(empleado == "" || diasAgregar == "" || anio == ""){
        swal("Por favor llena todos los campos", "", "info");
    }else{
        $.post("ajax/vacaciones.php", {
            empleadoChecador:empleadoChecador,
            empleadoId:empleadoId,
            diasAgregar:diasAgregar,
            utilizables:utilizables,
            accion:3,
            anio:anio,
            anioVacaciones:anioVacaciones
        }, function (data, status) {
            swal("Vacaciones agregadas correctamente", "", "success");
            //$('#my_table').DataTable().clear();
            $("#agregaVacacionesForm").trigger("reset");
            $("#modalAgrega").modal("hide");
            readRecords(3);
            let misPermisos = JSON.parse(Cookies.get('permisos'))
            muestraVacaciones(misPermisos[3].nivelAcceso,Cookies.get('idEmpleado'))
            $('#tablaVacaciones').DataTable({
                fixedColumns: true,
                "scrollX": true,
                "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json",
                },
                dom: "Bfrtip",
                "lengthMenu": [[10, 25, 50, -1], ["Mostrar 10", "Mostrar 25", "Mostrar 50", "Mostrar Todo"]],
                buttons: [ {
                  extend: "excel",
                  title: "VACACIONES DE EMPLEADOS",
                  filename: "VACACIONES_EMPLEADOS",
                  text: "Descargar Excel"
                },
                "pageLength",
                ]
              });
              $('#tablaVacacionesActivos').DataTable({
                fixedColumns: true,
                "scrollX": true,
                "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json",
                },
                dom: "Bfrtip",
                "lengthMenu": [[10, 25, 50, -1], ["Mostrar 10", "Mostrar 25", "Mostrar 50", "Mostrar Todo"]],
                buttons: [ {
                  extend: "excel",
                  title: "VACACIONES DE EMPLEADOS",
                  filename: "VACACIONES_EMPLEADOS",
                  text: "Descargar Excel"
                },
                "pageLength",
                ]
              });
    
              $('#tablaVacacionesInactivos').DataTable({
                fixedColumns: true,
                "scrollX": true,
                "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json",
                },
                dom: "Bfrtip",
                "lengthMenu": [[10, 25, 50, -1], ["Mostrar 10", "Mostrar 25", "Mostrar 50", "Mostrar Todo"]],
                buttons: [ {
                  extend: "excel",
                  title: "VACACIONES DE EMPLEADOS",
                  filename: "VACACIONES_EMPLEADOS",
                  text: "Descargar Excel"
                },
                "pageLength",
                ]
              });
              $("#agregaVacacionesForm").trigger("reset");
            
                
        });
    }

    
}

function solicitudVacaciones(){
    let diasPedidos = $("#txtDiasSolicitaDos").val()
    let diasSplit = diasPedidos.split(",");
    let cantidad = diasSplit.length;
    let disponibles = getDiasDisponibles();
    if(cantidad <= disponibles){
        jQuery.ajax({
            url: "ajax/solicitudVacaciones.php",
            method: 'POST',
            async: false,
            data:{
                cantidad:cantidad,
                dias:diasSplit.toString(),
                accion:1
            },
            success: function (data) {
                swal("Solicitud creada correctamente", "", "success");
                $("#modalSolicita").modal("hide");
                $("#solicitaVacacionesForm").trigger("reset");
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                console.log(XMLHttpRequest.responseText)
            }
        });
    }else{
        swal("No cuentas con la cantidad de días de vacaciones suficientes para esta solicitud", "", "info");
    }
    
}

function getDiasDisponibles(){
    var disponibles;
    jQuery.ajax({
        url: "ajax/vacacionesDisponibles.php",
        method: 'POST',
        async: false,
        dataType: 'JSON',
        data:{
        },
        success: function (data) {
            disponibles = data[0].disponibles;
            if(disponibles == null){
                disponibles = 0;
            }
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            console.log(XMLHttpRequest.responseText)
        }
    });
    return disponibles;
    
}

function muestraSolicitudes(permiso,empleadoActual){
    
    jQuery.ajax({
        url: "ajax/solicitudVacaciones.php",
        method: 'POST',
        async: false,
        dataType: 'JSON',
        data:{
            accion:2,
            permiso:permiso
        },
        success: function (data) {
            $(".tablaSolicitudes").children().remove()
            $(".tablaSolicitudes").append(
                `
                <table id="tablaSolicitudes" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th>Folio solicitud</th>
                            <th>Empleado</th>
                            <th># días solicitados</th>
                            <th>Días solicitados</th>
                            <th>Fecha registro</th>
                            <th>Estatus solicitud</th>
                            <th>Fecha aceptación</th>
                            <th>Formato</th>
                            <th class='vacacionesRH'>Acciones</th>
                            <th class='vacacionesRH'>Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="dataSolicitudes">
                    </tbody>
                </table>
                `
            );
            data.forEach(solicitud => {
                let folio = solicitud.folio;
                let empleadoFolio = solicitud.empleado;
                let autoriza = "SI";
                if(empleadoFolio == empleadoActual && permiso != 3){
                    autoriza = "NO";
                }
                let apruebaVacas = `<button class="btn btn-success" onclick="aprobarSolicitud(${solicitud.folio},${solicitud.numDias},1)">Aprobar</button>`;
                let rechazavacas = `<button class="btn btn-success" onclick="aprobarSolicitud(${solicitud.folio},${solicitud.numDias},3)">Rechazar</button>`;
                if(solicitud.activa == 1){
                    $(".dataSolicitudes").append(
                        `<tr>
                            <td>${solicitud.folio}</td>
                            <td>${solicitud.nombreEmp}</td>
                            <td>${solicitud.numDias}</td>
                            <td>${solicitud.nameDias}</td>
                            <td>${solicitud.fechaRegistro}</td>
                            <td>${solicitud.activa == '1' ? 'NO APROBADA' : solicitud.activa == '3' ? 'RECHAZADA' : 'APROBADA'}</td>
                            <td>${solicitud.fechaAceptacion == '0000-00-00 00:00:00' ? '-' : solicitud.fechaAceptacion}</td>
                            <td><a href="vacaciones.php?folio=${folio}" target="_blank">VER</a></td>
                            <td class="vacacionesRH">${autoriza == "SI" ? apruebaVacas : ''}</td>
                            <td class="vacacionesRH">${autoriza == "SI" ? rechazavacas : ''}</td>
                         </tr>`
                    )
                }else{
                    $(".dataSolicitudes").append(
                        `<tr>
                            <td>${solicitud.folio}</td>
                            <td>${solicitud.nombreEmp}</td>
                            <td>${solicitud.numDias}</td>
                            <td>${solicitud.nameDias}</td>
                            <td>${solicitud.fechaRegistro}</td>
                            <td>${solicitud.activa == '1' ? 'NO APROBADA' : solicitud.activa == '3' ? 'RECHAZADA' : 'APROBADA'}</td>
                            <td>${solicitud.fechaAceptacion == '0000-00-00 00:00:00' ? '-' : solicitud.fechaAceptacion}</td>
                            <td><a href="vacaciones.php?folio=${folio}" target="_blank">VER</a></td>
                            <td class="vacacionesRH"></td>
                            <td class="vacacionesRH"></td>
                         </tr>`
                    )
                }
                
                 
            });
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            console.log("not ok")
        }
    });
    if(permiso == 1){
        $(".vacacionesRH").remove()
    }
    
}
function aprobarSolicitud(folio,numDias,accion){
    swal({
        title: "¿Está seguro de que desea ejecutar esta acción?",
        text: "",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
            jQuery.ajax({
                url: "ajax/aprueba_vacaciones.php",
                method: 'POST',
                async: false,
                dataType: 'JSON',
                data:{
                    folio : folio,
                    numDias:numDias,
                    accion:accion
                },
                success: function (data) {
                    swal("Solicitud aprobada correctamente", "", "success");
                    setTimeout(function(){
                        window.location.reload();
                     }, 3000);
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    console.log(XMLHttpRequest.responseText)
                }
            });
        }
      }); 
}
function paraverPrimero(){
    $("#activosDiv").hide()
                  $("#inactivosDiv").hide()
    
}

function dataTablesCarga(){
    $('#tablaSolicitudes').DataTable({
        fixedColumns: true,
        "scrollX": true,
        "language": {
        "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json",
        },
        dom: "Bfrtip",
        "lengthMenu": [[10, 25, 50, -1], ["Mostrar 10", "Mostrar 25", "Mostrar 50", "Mostrar Todo"]],
        buttons: [ {
          extend: "excel",
          title: "VACACIONES DE EMPLEADOS",
          filename: "VACACIONES_EMPLEADOS",
          text: "Descargar Excel"
        },
        "pageLength",
        ]
      });

      
}
/* VACACIONES FUNCIONES */

/* ACCESO APLICACIONES */
function addAccessoApp(){
    var idEmpleado = $("#txtEmpleadoNombre").val()
    var mailEmp = $("#txtEmail").val()
    var nominaPer = $("#nomina").val()
    var personalPer = $("#personal").val()
    var vacacionesPer = $("#vacaciones").val()
    var incidenciasPer = $("#incidencias").val()
    var registraFijos = $("#incidenciasFijos").val()
    var passwordEmpleado = $("#passwordEpleado").val()
    var politicasPer = $("#politicas").val()
    if(registraFijos == 2 && incidenciasPer == 2){
        incidenciasPer = 4;
    }

    if(idEmpleado == "" || mailEmp =="" || passwordEmpleado == ""){
        swal("Uno o más campos no pueden ir vacíos", "", "info");
    }else{
 
        jQuery.ajax({
            url: "ajax/aplicaciones.php",
            method: 'POST',
            async: false,
            dataType: 'JSON',
            data:{
                idEmpleado:idEmpleado,
                mailEmp:mailEmp,
                nominaPer:nominaPer,
                personalPer:personalPer,
                vacacionesPer:vacacionesPer,
                incidenciasPer:incidenciasPer,
                accion:1,
                passwordEmpleado:passwordEmpleado,
                politicasPer:politicasPer
            },
            success: function (data) {
                swal("Acción realizada correctamente", "", "success");
                $("#modalAgregaCuenta").modal("hide");
                muestraAccesosEmpleados()
                $('#tablaAccesos').DataTable({
                    fixedColumns: true,
                    "scrollX": true,
                    "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json",
                    },
                    dom: "Bfrtip",
                    "lengthMenu": [[10, 25, 50, -1], ["Mostrar 10", "Mostrar 25", "Mostrar 50", "Mostrar Todo"]],
                    buttons: [ {
                    extend: "excel",
                    title: "VACACIONES DE EMPLEADOS",
                    filename: "VACACIONES_EMPLEADOS",
                    text: "Descargar Excel"
                    },
                    "pageLength",
                    ]
                });
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                swal("Este usuario ya tiene accesos", "", "info");
            }
        });



    }
    
}

function muestraAccesosEmpleados() {
    var resultado;
        jQuery.ajax({
            url: "ajax/sistemas_accesos.php",
            method: 'POST',
            async: false,
            dataType: 'JSON',
            data:{
            },
            success: function (data) {
                $(".tablaAccesos").children().remove()
                $(".tablaAccesos").append(
                    `
                    <table id="tablaAccesos" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th>Nombre empleado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="dataAccesos">
                        </tbody>
                    </table>
                    `
                );
                data.forEach(aplicacion => {
                    $(".dataAccesos").append(
                        `<tr>
                            <td>${aplicacion.nombreEmpleado}</td>
                            <td> 
                                <button class=" btn-success editar" data-bs-toggle="modal" data-bs-target="#modalAgregaCuenta" onclick="ModalAccesos(${aplicacion.idEmpleado})"><i class="fa-solid fa-user-pen"> VER ACCESOS</i></button>
                            </td>
                         </tr>`
                    )
                }

                );

                
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                console.log("not ok")
            }
        });
        return resultado;
}
function ModalAccesos(idEmpleado){
    $("#agregaAccesoForm").trigger("reset");
    $("#txtEmpleadoNombre").val(idEmpleado);
    $( "#txtEmpleadoNombre" ).change()
        jQuery.ajax({
            url: "ajax/sistemas_accesos.php",
            method: 'POST',
            async: false,
            dataType: 'JSON',
            data:{
                empleado:idEmpleado,
                accion:1
            },
            success: function (data) {
                data.forEach(aplicacion => {
                    if(aplicacion.idApp == 1){
                        $("#personal").val(aplicacion.nivelAcceso)
                    }
                    if(aplicacion.idApp == 2){
                        
                        $("#nomina").val(aplicacion.nivelAcceso)
                    }
                    if(aplicacion.idApp == 3){
                        if(aplicacion.nivelAcceso == 4){
                            $("#incidencias").val(2)
                        }else{
                            $("#incidencias").val(aplicacion.nivelAcceso)
                        }
                        
                        if(aplicacion.nivelAcceso == 4){
                            $("#incidenciasFijos").val(2)
                            $(".fijosOpcion").removeClass("d-none")
                        }else{
                            $("#incidenciasFijos").val(1)
                        }
                        
                    }
                    if(aplicacion.idApp == 4){
                        
                        $("#vacaciones").val(aplicacion.nivelAcceso)
                    }
                    if(aplicacion.idApp == 5){
                        $("#politicas").val(aplicacion.nivelAcceso)
                    }
                    
                }

                

                );
                $(".brindaAcceso").addClass("d-none")
                $(".modificaAcceso").removeClass("d-none") 
                
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                console.log("not ok")
            }
        });
}
function saveAccessoApp(){
    var idEmpleado = $("#txtEmpleadoNombre").val()
    var mailEmp = $("#txtEmail").val()
    var nominaPer = $("#nomina").val()
    var personalPer = $("#personal").val()
    var vacacionesPer = $("#vacaciones").val()
    var incidenciasPer = $("#incidencias").val()
    var politicasPer = $("#politicas").val()
    var registraFijos = $("#incidenciasFijos").val()
    if(registraFijos == 2 && incidenciasPer == 2){
        incidenciasPer = 4;
    }
    jQuery.ajax({
        url: "ajax/sistemas_accesos.php",
        method: 'POST',
        async: false,
        dataType: 'JSON',
        data:{
            empleado:idEmpleado,
            accion:2,
            nominaPer:nominaPer,
            personalPer:personalPer,
            vacacionesPer:vacacionesPer,
            incidenciasPer:incidenciasPer,
            politicasPer:politicasPer
        },
        success: function (data) {
            swal("Accesos actualizados", "", "success");
            $("#agregaAccesoForm").trigger("reset");
            $("#modalAgregaCuenta").modal("hide")
            muestraAccesosEmpleados()
            $('#tablaAccesos').DataTable({
                fixedColumns: true,
                "scrollX": true,
                "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json",
                },
                dom: "Bfrtip",
                "lengthMenu": [[10, 25, 50, -1], ["Mostrar 10", "Mostrar 25", "Mostrar 50", "Mostrar Todo"]],
                buttons: [ {
                extend: "excel",
                title: "VACACIONES DE EMPLEADOS",
                filename: "VACACIONES_EMPLEADOS",
                text: "Descargar Excel"
                },
                "pageLength",
                ]
            });
            
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            console.log("not ok")
        }
    });
}
/* ACCESO APLICACIONES */

/* FUNCIONES PARA PRUEBAS */
function revisarSesion(){
    jQuery.ajax({
        url: "ajax/sesionVariables.php",
        method: 'POST',
        async: false,
        data:{},
        success: function (data) {
            console.log(data);
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            console.log(XMLHttpRequest.responseText)
        }
    });
}
/* FUNCIONES PARA PRUEBAS */

function muestraEvidencia(evidencia){
    $(".imagePreview").html("<img src='ajax/img/"+evidencia+"' class='img-fluid'>")
    $("#modalEvidencia").modal("show");
}

function borraImagen(){
    $(".imagePreview").html("")
}

//Cargar archivos
function uploadFile() {
    var fileEvidencia = $("#file").prop("files")[0];
    var tituloArchivo = $("#tituloToShow").val();
    if(fileEvidencia != undefined && tituloArchivo != ""){
        var nameFile = fileEvidencia.name;
        var form = new FormData();
        form.append("image", fileEvidencia);
        form.append("nombreToShow",tituloArchivo);
        $.ajax({
            url: "ajax/uploadArchivo.php",
            type: "POST",
            data:  form,
            contentType: false,
            processData:false,
            success: function(result){
                swal("archivo subido correctamente", "", "success");
                archivosCargados()
                $('#tablaArchivosSubidos').DataTable({
                    fixedColumns: true,
                    "scrollX": true
                });
                $("#archivoFormAgregar").trigger("reset");
                
            }
        });
    }else{
        if(tituloArchivo == ""){
            $(".txtTituloForm").removeClass("d-none");
            $("#tituloToShow").addClass("input-required");
        }else{
            $(".txtTituloForm").addClass("d-none");
            $("#tituloToShow").removeClass("input-required");
        }
        if(fileEvidencia == undefined) {
            $(".txtFileForm").removeClass("d-none");
            $("#file").addClass("input-required");
        }else{
            $(".txtFileForm").addClass("d-none");
            $("#file").removeClass("input-required");
        }  
        swal("Por favor llena todos los campos", "", "info");
    }
 
 }

function archivosCargados(){
    var resultado;
    jQuery.ajax({
        url: "ajax/readRecords_archivos.php",
        method: 'POST',
        async: false,
        dataType: 'JSON',
        data:{
        },
        success: function (data) {
            $(".tablaArchivosSubidos").children().remove()
            $(".tablaArchivosSubidos").append(
                `
                <table id="tablaArchivosSubidos" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th>Folio</th>
                            <th>Titulo para mostrar</th>
                            <th>Archivo</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="dataArchivosSubidos">
                    </tbody>
                </table>
                `
            );
            data.forEach(archivo => {
                $(".dataArchivosSubidos").append(
                    `<tr data-archivo="archivo_${archivo.idArchivo}">
                        <td>${archivo.idArchivo}</td>
                        <td>${archivo.titulo}</td>
                        <td><a href="upload/${archivo.url}">${archivo.url}</a></td>
                        <td>
                            
                            <button class=" btn-success editar" data-bs-toggle="modal" data-bs-target="#ArchivoModal" onclick="modalArchivo(${archivo.idArchivo})"><i class="fa-solid fa-user-pen"></i></button>
                            <button class=" btn-success borrar" onclick="deleteRecordArchivo(${archivo.idArchivo})"><i class="fa-solid fa-trash"></i></button>
                        </td>
                     </tr>`
                )
            }

            );
            
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            console.log("not ok")
        }
    });
    return resultado;
}

function modalArchivo(idArchivo){
    $("#txtTitulo").removeClass("input-required")
    let accion = "ver";
    jQuery.ajax({
        url: "ajax/operaciones_archivos.php",
        method: 'POST',
        async: false,
        dataType: 'JSON',
        data:{
            idArchivo:idArchivo,
            accion:accion
        },
        success: function (data) {
            
            $("#txtIdArchivo").val(idArchivo);
            $("#txtTitulo").val(data[0].titulo);
            
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            console.log("not ok")
        }
    });
}

function deleteRecordArchivo(idArchivo){
    let accion = "borrar";

    swal({
        title: "¿Está seguro de que deseas borrar esta política?",
        text: "",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
            jQuery.ajax({
                url: "ajax/operaciones_archivos.php",
                method: 'POST',
                async: false,
                dataType: 'JSON',
                data:{
                    idArchivo:idArchivo,
                    accion:accion
                },
                success: function (data) {
                    $("#archivoForm").trigger("reset");
                    $("#ArchivoModal").modal("hide")
                    swal("Política borrada correctamente", "", "success");

                    archivosCargados()
                    $('#tablaArchivosSubidos').DataTable({
                        fixedColumns: true,
                        "scrollX": true
                    });
                    
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    console.log("not ok")
                }
            });
        }
      });
    
}
function editaPolitica(){
    
    let idArchivo = $("#txtIdArchivo").val();
    let accion = "editar";
    let titulo = $("#txtTitulo").val();
    let fileEvidencia = $("#fileActualiza").prop("files")[0];
    if (fileEvidencia != undefined) {
        let nameFile = fileEvidencia.name;
        var form = new FormData();
        form.append("image", fileEvidencia);
        form.append("titulo", titulo);
        form.append("idArchivo", idArchivo);
        form.append("accion", accion);
        jQuery.ajax({
            url: "ajax/operaciones_archivos.php",
            method: 'POST',
            async: false,
            contentType: false,
            data: form,
            processData: false,
            success: function (data) {

                $("#archivoForm").trigger("reset");
                $("#ArchivoModal").modal("hide")
                swal("Política actualizada correctamente", "", "success");
                archivosCargados()
                $('#tablaArchivosSubidos').DataTable({
                    fixedColumns: true,
                    "scrollX": true
                });

            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                console.log("not ok")
            }
        });
    }else{
        if(titulo != ""){
            accion = "editarSinArchivo";
            jQuery.ajax({
                url: "ajax/operaciones_archivos.php",
                method: 'POST',
                async: false,
                dataType: 'JSON',
                data:{
                    idArchivo:idArchivo,
                    accion:accion,
                    titulo:titulo
                },
                success: function (data) {
                    
                    $("#archivoForm").trigger("reset");
                    $("#ArchivoModal").modal("hide")
                    swal("Política actualizada correctamente", "", "success");
                    archivosCargados()
                    $('#tablaArchivosSubidos').DataTable({
                        fixedColumns: true,
                        "scrollX": true
                    });
                    
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    console.log("not ok")
                }
            });
        }else{
            $("#txtTitulo").addClass("input-required")
            swal("Este campo no puede ir vacío", "", "info");
        }
        
    }
    
    
}

function cargaPoliticas(){
    let accion = "desplegar";
    let idArchivo = 0;
    jQuery.ajax({
        url: "ajax/operaciones_archivos.php",
        method: 'POST',
        async: false,
        dataType: 'JSON',
        data:{
            accion:accion,
            idArchivo:idArchivo
        },
        success: function (data) {
            
            //$(".tablaArchivosSubidos").children().remove()
        
            data.forEach(archivo => {
                $(".divPoliticas").append(
                    `<div class="col-sm-3" style="padding-top: 20px;">
                        <div class="card" style="width: 18rem;">
                            <div class="card-body">
                            <h5 class="card-title">${archivo.titulo}</h5>
                            <h6 class="card-subtitle mb-2 text-muted"></h6>
                            <p class="card-text"></p>
                            <a data-url="upload/${archivo.url}" class="card-link" onclick=showFileModal(this) style="cursor: pointer">Ver</a>
                            </div>
                        </div>
                    </div>`
                )
            }

            );
            
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            console.log("not ok")
        }
    }); 
}

function showFileModal(url){
    let urlShow = $(url).attr("data-url")
    let ultimoPunto = urlShow.lastIndexOf('.');
    let after = urlShow.slice(ultimoPunto + 1);
    $("#staticBackdrop").modal("show")
    if(after.includes("pdf")){
        $("#verIframeModal").attr("src",urlShow);
        $("#verIframeModal").removeClass("d-none");
        $("#verImageModal").addClass("d-none");
        $("#modal-body-ver").addClass("ratio-21x9")
        $("#modal-body-ver").addClass("ratio")
        
    }else{
        $("#verImageModal").attr("src",urlShow)
        $("#verImageModal").removeClass("d-none")
        $("#verIframeModal").addClass("d-none")
        $("#modal-body-ver").removeClass("ratio-21x9")
        $("#modal-body-ver").removeClass("ratio")
    }
}

//Cargar archivos