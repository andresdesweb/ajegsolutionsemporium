$(document).ready(function () {
	jQuery.ajax({
        url: "ajax/myApps.php",
        method: 'POST',
        async: false,
		dataType: 'JSON',
        data:{
			accion:1
		},
        success: function (data) {
            data.forEach(apps=> {
				if(apps.nivelAcceso != 0){
					switch(apps.idApp) {
						case "1":
						  var icon = "fa-solid fa-user";
						  break;
						case "2":
							var icon = "fa-solid fa-clock";
							break;
						case "3":
							var icon = "fa-solid fa-calendar-plus";
							break;
						case "4":
							var icon = "fa-solid fa-umbrella-beach";
							break;
              			case "5":
                			var icon = "fa-solid fa-user";
                			break;
						default:
						  // code block
					  } 
					$(".appsDespliegue").append(
						
					`
					<div class="col-md-3 col-sm-6 mb-4">
                        <a href="${apps.url}" class="modern-card">
                            <h5 class="card-title fw-bold" style="color: #2c3e50; min-height: 48px; display: flex; align-items: center; justify-content: center;">${apps.nombreAplicacion}</h5>
                            <div class="mt-4" style="color: #b02a2a">
                                <i class="${icon} fa-4x"></i>
                            </div>
                        </a>
                    </div>
						`
					);	
				}
			});
      $(".appsDespliegue").append(
						
        `
        <div class="col-md-3 col-sm-6 mb-4">
            <a href="politicas.html" class="modern-card">
                <h5 class="card-title fw-bold" style="color: #2c3e50; min-height: 48px; display: flex; align-items: center; justify-content: center;">Politicas</h5>
                <div class="mt-4" style="color: #b02a2a">
                    <i class="fa-solid fa-file-contract fa-4x"></i>
                </div>
            </a>
        </div>
        <div class="col-md-3 col-sm-6 mb-4">
            <a href="calendario.html" class="modern-card">
                <h5 class="card-title fw-bold" style="color: #2c3e50; min-height: 48px; display: flex; align-items: center; justify-content: center;">Calendario</h5>
                <div class="mt-4" style="color: #b02a2a">
                    <i class="fa-solid fa-calendar fa-4x"></i>
                </div>
            </a>
        </div>
          `
        );	
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            console.log(XMLHttpRequest.responseText)
        }
    });

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
	
});
