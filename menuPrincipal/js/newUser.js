$(document).ready(function () {
	jQuery.ajax({
        url: "ajax/primeravezPass.php",
        method: 'POST',
        async: false,
		dataType: 'JSON',
        data:{
			accion:1
		},
        success: function (data) {
            if(data == 0){
				$("#cambiaContrasena").modal("show");
			}
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            console.log(XMLHttpRequest.responseText)
        }
    });

	
	
});
function cambiaContrasena(){
	antiguaContra = $("#antiguaContra").val()
	nuevaContra = $("#nuevaContra").val()
	confNuevaContra = $("#confNuevaContra").val()

	if(nuevaContra == confNuevaContra && antiguaContra == "emporium_123"){
		jQuery.ajax({
			url: "ajax/primeravezPass.php",
			method: 'POST',
			async: false,
			data:{
				accion:2,
				nuevaContra:nuevaContra,
			},
			success: function (data) {
				swal("Cambiada correctamente, por favor inicia sesión de nuevo", "", "success");
				setTimeout(function(){
					window.location.href = "index.html";
				}, 5000);
				
			},
			error: function (XMLHttpRequest, textStatus, errorThrown) {
				console.log(XMLHttpRequest.responseText)
			}
		});
	}else{
		swal("tu contraseña nueva no coincide con la confirmación o la contraseña antigua es incorrecta", "", "warning");
	}
}

function mostrarPassword(){
	var x = document.getElementById("confNuevaContra");
	var y = document.getElementById("antiguaContra");
	var z = document.getElementById("nuevaContra");
	if (x.type === "password") {
	  x.type = "text";
	  y.type = "text";
	  z.type = "text";
	} else {
	  x.type = "password";
	  y.type = "password";
	  z.type = "password";
	}
}