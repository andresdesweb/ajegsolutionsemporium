function formRegistro(){
    $("#add_new_record_modal").modal("show");
}
// Add Record
function addRecord() {
    // get values
    var add_nombre = $("#txtNombre").val();
    var add_departamento = $("#txtDepartamento").val();
    var add_ingreso = $("#txtIngreso").val();
    var add_mail = $("#txtMail").val();
    var add_entrada = $("#txtEntrada").val();
    var add_salida = $("#txtSalida").val();
    var add_puesto = $("#txtPuesto").val();

    // Add record
    $.post("ajax/addRecord_empleados.php", {
        add_nombre:add_nombre,        
        add_departamento:add_departamento,
        add_ingreso:add_ingreso,
        add_mail:add_mail,
        add_entrada:add_entrada,
        add_salida:add_salida,
        add_puesto:add_puesto
    }, function (data, status) {
        // close the popup
        alert("bien")
    });
}

// READ records
function readRecords() {
    var resultado;
        jQuery.ajax({
            url: "ajax/readRecords_empleados.php",
            method: 'POST',
            async: false,
            dataType: 'JSON',
            data:{
            },
            success: function (data) {
                data.forEach(empleado => {
                    $(".empleadosRegistros").append(`
					<tr>
                        <td>${empleado.idEmpleado}</td>
                        <td>${empleado.Nombre}</td>
                        <td>${empleado.Ingreso}</td>
                    </tr>`)
                }

                )
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                console.log("not ok")
            }
        });
        return resultado;
}


function DeleteUser(id) {
    /*var conf = confirm("Are you sure, do you really want to delete User?");
    if (conf == true) {
        $.post("ajax/deleteUser_empleados.php", {
                id: id
            },
            function (data, status) {
                // reload Users by using readRecords();
                readRecords();
            }
        );
    }*/
swal({
  title: "¿Estás seguro que deseas eliminar a este empleado?",
  text: "No se podrá recuperar",
  icon: "warning",
  buttons: true,
  dangerMode: true,
})
.then((willDelete) => {
  if (willDelete) {
     $.post("ajax/deleteUser_empleados.php", {
                id: id
            },
            function (data, status) {
                // reload Users by using readRecords();
                readRecords();
            }
        );
    swal("Empleado eliminado correctamente", {
      icon: "success",
    });
  }
});
}

function GetUserDetails(id) {
    // Add User ID to the hidden field for furture usage
    $("#hidden_user_id").val(id);
    $.post("ajax/readUserDetails_empleados.php", {
            id: id
        },
        function (data, status) {
            // PARSE json data
            var empleado = JSON.parse(data);
            // Assing existing values to the modal popup fields
            $("#update_lunesin").val(empleado.entrada);
            $("#update_lunesout").val(empleado.salida);
            $("#update_martesin").val(empleado.entradamartes);
            $("#update_martesout").val(empleado.salidamartes);
            $("#update_miercin").val(empleado.entradamierc);
            $("#update_miercout").val(empleado.salidamierc);
            $("#update_juevesin").val(empleado.entradajueves);
            $("#update_juevesout").val(empleado.salidajueves);
            $("#update_viernesin").val(empleado.entradaviernes);
            $("#update_viernesout").val(empleado.salidaviernes);
            $("#update_sabadoin").val(empleado.sabadoin);
            $("#update_sabadoout").val(empleado.sabadoout);
            $("#update_checadas").val(empleado.checadas);
            $("#update_empleado").val(empleado.nombreemp);
            $("#lastupd").val(empleado.lastupd);
            $("#update_id").val(empleado.idempleado);
            $("#update_departamento").val(empleado.idArea);

            //$("#update_email").val(user.email);
        }
    );
    // Open modal popup
    //$("#update_user_modal").modal("show");
    $("#update_user_modal").modal();
}


function ComboAreas() {
    // Add User ID to the hidden field for furture usage
    $.post("ajax/comboArea_empleados.php", {
        },
        function (data, status) {
            $(".comboArea").html(data);
        }
    );
    // Open modal popup
    //$("#update_user_modal").modal("show");
    //$("#update_user_modal").modal();
}

function UpdateUserDetails() {
    // get values
    var entrada = $("#update_lunesin").val();
    var salida = $("#update_lunesout").val();
    var entradamartes = $("#update_martesin").val();   
    var salidamartes = $("#update_martesout").val();
    var entradamierc = $("#update_miercin").val();
    var salidamierc = $("#update_miercout").val();
    var entradajueves = $("#update_juevesin").val();
    var salidajueves = $("#update_juevesout").val();
    var entradaviernes = $("#update_viernesin").val();
    var salidaviernes = $("#update_viernesout").val();
    var sabadoin = $("#update_sabadoin").val();
    var sabadoout = $("#update_sabadoout").val();
    var checadas = $("#update_checadas").val();
    var nombreemp = $("#update_empleado").val();
    var idempleado = $("#update_id").val();
    var departamento = $("#update_departamento").val();
    //ComboAreas();






    // get hidden field value
    var id = $("#hidden_user_id").val();

    // Update the details by requesting to the server using ajax
    $.post("ajax/updateUserDetails_empleados.php", {
        id: id,
        entrada: entrada,
        salida: salida,
        entradamartes: entradamartes,
        salidamartes: salidamartes,
        entradamierc: entradamierc,
        salidamierc: salidamierc,
        entradajueves: entradajueves,
        salidajueves: salidajueves,
        entradaviernes: entradaviernes,
        salidaviernes: salidaviernes,
        sabadoin: sabadoin,
        sabadoout: sabadoout,
        checadas: checadas,
        nombreemp: nombreemp,
        idempleado: idempleado,
        departamento: departamento
            
        },
        function (data, status) {
            // hide modal popup
            $("#update_user_modal").modal("hide");
            swal("Horario actualizado", "", "success");
            // reload Users by using readRecords();
            readRecords();
        }
    );
}

$(document).ready(function () {
    // READ recods on page load
    readRecords(); // calling function
    ComboAreas();
    
    
});
