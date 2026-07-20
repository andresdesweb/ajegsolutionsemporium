$(document).ready(function () {
    // READ recods on page load
    usuarioActualSistema();
    var sessionChecked = checkSession(Cookies.get('tokenSession'));
    var idApp = $("#txtApp").val();
    var permisos;
    panIntegral(Cookies.get('idEmpleado'));
    if(sessionChecked){
        switch (idApp){
          case "departamentos":
            muestraDepartamentos()
            muestraDirecciones()
            $('#tablaDepartamentos').DataTable({
              fixedColumns: true
            });
            $('#tablaDirecciones').DataTable({
              fixedColumns: true
            });
          break;

          case "empleados":
            if(permisos[0].nivelAcceso != 0){
              readRecords(1); // calling function
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
              $( ".guardarEmpleado" ).click(function() {
                editaEmpleado()
              });
              comboDepartamentos();
              comboDireccion();
              comboJefesDirectos();
              $( "#statusEmpleados" ).change(function() {
                  let paraVer = $("#statusEmpleados").val();
                  if(paraVer == 1){
                    $(".tablaEmpleados").removeClass("d-none")
                    $(".tablaEmpleadosNoActivos").addClass("d-none")
                    $(".tablaEmpleadosTodos").addClass("d-none")
                  }else if(paraVer == 0){
                    $(".dataTables_scrollHeadInner").attr("style", "")
                  $(".display.dataTable.no-footer").attr("style", "")
                    $(".tablaEmpleados").addClass("d-none")
                    $(".tablaEmpleadosNoActivos").removeClass("d-none")
                    $(".tablaEmpleadosTodos").addClass("d-none")
                  }else{
                    $(".dataTables_scrollHeadInner").attr("style", "")
                  $(".display.dataTable.no-footer").attr("style", "")
                    $(".tablaEmpleados").addClass("d-none")
                    $(".tablaEmpleadosNoActivos").addClass("d-none")
                    $(".tablaEmpleadosTodos").removeClass("d-none")
                  }
              });
            }else{
              window.location.href = "principal.html";
            }
            
          break;

          case "incidencias":
            muestraBorraIncidencias(permisos[2].nivelAcceso,Cookies.get('idEmpleado'))
            if(permisos[2].nivelAcceso != 0){
              muestraPeriodosNomina();
              muestraIncidencias(); // calling function
              comboDepartamentosIncidencias()
              //comboDepartamentos();
              readRecords_incidencias()
              $(".incidenciaHorarios").hide()
              if(permisos[2].nivelAcceso == 0 || permisos[2].nivelAcceso == 1){
                $(".aprobarIncidencia").remove()
              }
              //readRecords(2);
              $( "#nominaReporte" ).change(function() {
                $('#tablaIncidencias').DataTable().clear();
                $('#tablaIncidencias').DataTable().destroy();

                $('#tablaIncidenciasNoAprobadas').DataTable().clear();
                $('#tablaIncidenciasNoAprobadas').DataTable().destroy();
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
                    filename: "Reporte de Incidencias",
                    text: "Descargar Excel"
                  },
                  "pageLength",
                  ]
              });
              $( "#txtEmpleadoNombre" ).change(function() {
                datosIncidenciaEmpleado()
              });
              
              $( "#filtroFecha, #filtroDepartamento, #filtroTipo, #filtroFechaRegistro" ).change(function() {
                filtroIncidencias()   
              });
              primeraVezSelect()
              $( "#txtIncidencia" ).change(function() {
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
                  case "31":
                  case "32":
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
                // if(tipoIncidencia == 6){
                //   $(".cambioFijo").show();
                //   $(".incidenciaHorarios").show()
                //   $(".agregarEmpleadoNormal").hide()
                //   $(".horariosEntradaSalida").hide()
                // }else{
                //   $(".cambioFijo").hide()
                //   $(".incidenciaHorarios").hide()
                //   $(".agregarEmpleadoNormal").show()
                //   $(".horariosEntradaSalida").show()
                // }
                var idEmpleadoApp = $("#txtEmpleadoNombre").val()
                getRecord(idEmpleadoApp,2)
              });

              
              
              $( ".verCambioFijo" ).click(function() {
                let text = $(this).next().html();
                a = text.replace(/<br>/g,'')
                swal($(this).next().html(), "");
                $(".swal-title").css("white-space", "pre")
            });
              // $( ".guardarEmpleado" ).click(function() {
              //   editaEmpleado()
              // });
              // comboDepartamentos();
              // comboDireccion();
              // comboJefesDirectos();
              let dateToday = new Date();
              let dateTodayYear = dateToday.getFullYear();
              let dateTodayMonth = dateToday.getMonth() + 1;
              let dateTodayYearLater = dateTodayYear;
              let dateTodayMonthLater;
              if(dateTodayMonth == 12){
                dateTodayMonthLater = 2;
                dateTodayYearLater = dateToday.getFullYear() + 1;
              }else{
                dateTodayMonthLater = dateToday.getMonth() + 2;
              }
              if(dateTodayMonthLater < 10){
                dateTodayMonthLater = "0"+dateTodayMonthLater;
              }
              if(dateTodayMonthLater > 12){
                dateTodayMonthLater = "01";
              }
              if(dateTodayMonth < 10){
                dateTodayMonth = "0"+dateTodayMonth;
              }
              let dateTodayDay = dateToday.getDate()-1;
              if(dateTodayDay < 10){
                dateTodayDay = "0"+dateTodayDay;
              }
              let newDateToday = dateTodayYear + "-" + dateTodayMonth + "-" + dateTodayDay;
              let newDateTodayMonth = dateTodayYearLater + "-" + dateTodayMonthLater + "-" + dateTodayDay;
              $("#txtFechaInicio").attr("min", newDateToday)
              $("#txtFechaFin").attr("min", newDateToday)

              $("#txtFechaInicio").attr("max", newDateTodayMonth)
              $("#txtFechaFin").attr("max", newDateTodayMonth)
              
              
            }else{
              window.location.href = "principal.html";
            }
            
          break;
          case "nomina":
            if(permisos[1].nivelAcceso != 0){
              muestraPeriodosNomina();
              muestraNomina();
              $( "#nominaReporte" ).change(function() {
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
                
              });
              // muestraIncidencias();
              // comboDepartamentos();
              // readRecords(2);
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
              
              // $( "#txtEmpleadoNombre" ).change(function() {
              //   datosIncidenciaEmpleado()
              // });
              // $( "#filtroFecha, #filtroDepartamento, #filtroTipo, #filtroFechaRegistro" ).change(function() {
              //   filtroIncidencias()   
              // });
              // $( ".guardarEmpleado" ).click(function() {
              //   editaEmpleado()
              // });
              // comboDepartamentos();
              // comboDireccion();
              // comboJefesDirectos();
            }else{
              window.location.href = "principal.html";
            }
            
          break;
          case "vacaciones":
            if(permisos[3].nivelAcceso != 0){
              //actualizaVacaciones()
              $("#modalMensaje").modal("show");
              readRecords(3);
              muestraVacaciones(permisos[3].nivelAcceso,Cookies.get('idEmpleado'))
              muestraSolicitudes(permisos[3].nivelAcceso,Cookies.get('idEmpleado'))
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
              paraverPrimero()
              $( "#vacacionesVer" ).change(function() {
                let paraVer = $("#vacacionesVer").val();
                if(paraVer == 1){
                  $("#todosDiv").show()
                  $("#activosDiv").hide()
                  $("#inactivosDiv").hide()
                }
                if(paraVer == 2){
                  $(".dataTables_scrollHeadInner").attr("style", "")
                  $(".display.dataTable.no-footer").attr("style", "")
                  $("#todosDiv").hide()
                  $("#activosDiv").show()
                  $("#inactivosDiv").hide()
                }
                if(paraVer == 3){
                  $(".dataTables_scrollHeadInner").attr("style", "")
                  $(".display.dataTable.no-footer").attr("style", "")
                  $("#todosDiv").hide()
                  $("#activosDiv").hide()
                  $("#inactivosDiv").show()
                }
            });
              $( ".reiniciaSolicitud" ).click(function() {
                $("#txtDiasSolicitaDos").val("")
              });
            }else{
              window.location.href = "principal.html";
            }
            
            

          break;
          case "sistemas":
            //actualizaVacaciones()
            readRecords(2);
            muestraAccesosEmpleados();
            
            
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
            $( "#txtEmpleadoNombre" ).change(function() {
              var idEmpleadoApp = $("#txtEmpleadoNombre").val()
              getRecord(idEmpleadoApp,2)
            });
            $( ".editaAcceso" ).click(function() {
                $(".brindaAcceso").removeClass("d-none")
                $(".modificaAcceso").addClass("d-none")
                $("#agregaAccesoForm").trigger("reset");
            });
            $( "#incidencias" ).change(function() {
              let seleccionado = $("#incidencias").val()
              if(seleccionado == 2){
                $(".fijosOpcion").removeClass("d-none")
              }else{
                $(".fijosOpcion").addClass("d-none")
              }
            });
            

          break;
          case "politicas":
            if(permisos[4].nivelAcceso != 0){
              //Cargar archivos
            archivosCargados()
            $('#tablaArchivosSubidos').DataTable({
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

            cargaPoliticas()
            //Cargar archivos
            }else{
              window.location.href = "principal.html";
            }
            

          break;

          case "politicasVer":
              //Cargar archivos
            archivosCargados()
            $('#tablaArchivosSubidos').DataTable({
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

            cargaPoliticas()
            //Cargar archivos
            

          break;
        }
      
    }
    function panIntegral(emp){
      jQuery.ajax({
        url: "ajax/aplicaciones.php",
        method: 'POST',
        async: false,
        dataType: 'JSON',
        data:{
          emp:emp,
          accion:2
        },
        success: function (data) {
          permisos = data;

          let inFifteenMinutes = new Date(new Date().getTime() + 300 * 60 * 1000);
          let dataTostr = JSON.stringify(data)
          Cookies.set('permisos', dataTostr,
          {
              expires: inFifteenMinutes
          });
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            //mostrar alerta
        }
    });

    }
    
});

