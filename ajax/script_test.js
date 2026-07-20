// Add Record

function addRecord() {
    // get values
    var first_name = $("#first_name").val();
    var last_name = $("#last_name").val();
    var email = $("#email").val();

    // Add record
    $.post("ajax/addRecord.php", {
        first_name: first_name,
        last_name: last_name,
        email: email
    }, function (data, status) {
        // close the popup
        $("#add_new_record_modal").modal("hide");

        // read records again
        readRecords();

        // clear fields from the popup
        $("#first_name").val("");
        $("#last_name").val("");
        $("#email").val("");
    });
}

// READ records
function readRecords() {
    $.get("ajax/readRecord_test.php", {}, function (data, status) {
        $(".records_content").html(data);
    });
}

function justificacionFaltas() { 
    $.get("ajax/JustificacionFaltas_test.php", {}, function (data, status) {
        //$(".records_content").html(data);
        swal("Acción realizada correctamente", {
            icon: "success",
        }); 
    });
}

function justificacionEntradasSalidas() { 
    $.get("ajax/justificacionEntradasSalidas_test.php", {}, function (data, status) {
        //$(".records_content").html(data);
        swal("Acción realizada correctamente", {
            icon: "success",
        }); 
    });
}

function justificacionSalidas() { 
    $.get("ajax/justificacionSalidas_test.php", {}, function (data, status) {
        //$(".records_content").html(data);
        swal("Acción realizada correctamente", {
            icon: "success",
        }); 
    });
}
function justificacionCambiosHorarios() { 
    $.get("ajax/justificacionCambioshorarios_test.php", {}, function (data, status) {
        //$(".records_content").html(data);
        console.log(data);
        swal("Acción realizada correctamente", {
            icon: "success",
        }); 
    });
}
function justificacionCambiosHorariosSalidas() { 
    $.get("ajax/justificacionCambioshorariosSalidas_test.php", {}, function (data, status) {
        //$(".records_content").html(data);
        console.log(data);
        swal("Acción realizada correctamente", {
            icon: "success",
        }); 
    });
}

function DeleteUser(id) {
    var conf = confirm("Are you sure, do you really want to delete User?");
    if (conf == true) {
        $.post("ajax/deleteUser.php", {
                id: id
            },
            function (data, status) {
                // reload Users by using readRecords();
                readRecords();
            }
        );
    }
}

function RegistrarIncidencias(){
   $.post("ajax/RegistraIncidencia_test.php", {}, function (data, status) {
    readRecords();
  });
   swal("Incidencias cargadas correctamente", {
      icon: "success",
    }); 
}

function JustificarIncidencias(){
    $.post("ajax/JustificarIncidencia_test.php", {}, function (data, status) {
    //readRecords();
  });
   swal("Incidencias justificadas correctamente", {
      icon: "success",
    });
}

function ActualizarNomina(){
   $.post("ajax/ActualizarNomina_test.php", {}, function (data, status) {
    readRecords();
  });
   swal("Nómina actualizada", {
      icon: "success",
    }); 
   readRecords();  
}

function GetUserDetails(id) {
    // Add User ID to the hidden field for furture usage

    $("#hidden_user_id").val(id);
    $.post("ajax/readUserDetails_test.php", {
            id: id
        },
        function (data, status) {
            // PARSE json data
            var checada = JSON.parse(data);
            // Assing existing values to the modal popup fields
            $("#update_name").val(checada.nombreemp);
            $("#update_fechahora").val(checada.fechahora);
            $("#update_comentarios").val(checada.comentario);
        }
    );
    // Open modal popup
    $("#update_user_modal").modal("show");
}

function UpdateUserDetails() {
    // get values
    var fechahora = $("#update_fechahora").val();
    var comentario = $("#update_comentarios").val();


    // get hidden field value
    var id = $("#hidden_user_id").val();

    // Update the details by requesting to the server using ajax
    $.post("ajax/updateUserDetails_test.php", {
            id: id,
            fechahora: fechahora,
            comentario: comentario
        },
        function (data, status) {
            // hide modal popup
            $("#update_user_modal").modal("hide");
            swal("Justificado", "", "success");
            // reload Users by using readRecords();
            //readRecords();
        }
    );
}
function ModalInasistencias(){
  $("#justifica_inasistencia").modal("show");  
}
function combo_empleados() {
    $.get("ajax/comboempleados_test.php", {}, function (data, status) {
        $(".empleados").html(data);
    });
}
function JustificaInasistencia(){
    var empleado = $("#empleadojustifica").val();
    var fechaincidencia = $("#fechajustifica").val();
    var fechaincidenciafin = $("#fechajustificafin").val();
    //console.log(fechaincidenciafin);
    $.post("ajax/justificaInasistencia_test.php", {empleado:empleado,fechaincidencia:fechaincidencia,fechaincidenciafin:fechaincidenciafin}, function (data, status) {
        //$(".empleados").html(data);
        swal("Justificado", "", "success");
        $("#justifica_inasistencia").modal("hide"); 
        $("#fechajustifica").val("");
    });
}
$(document).ready(function () {
    // READ recods on page load
    readRecords(); // calling function
    combo_empleados();
});