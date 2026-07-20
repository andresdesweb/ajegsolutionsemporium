    function checkUser(userLogin, passwordLogin){
        var resultado;
        jQuery.ajax({
            url: "ajax/checkUserLogin_login.php",
            method: 'POST',
            async: false,
            dataType: 'JSON',
            data:{
                userLogin:userLogin,    
                passwordLogin:passwordLogin
            },
            success: function (data) {
                if(data[0].status == "success"){
                    //alert("BIEN");
                    var inFifteenMinutes = new Date(new Date().getTime() + 300 * 60 * 1000);
                    Cookies.set('tokenSession', data[0].token,
                    {
                        expires: inFifteenMinutes
                    });
                    Cookies.set('idEmpleado', data[0].emp,
                    {
                        expires: inFifteenMinutes
                    });
                    resultado = true;
                    
                }else{
                    swal("Usuario o contraseña incorrecto", "", "warning");
                    resultado = false;
                    //mostrar alerta
                }
                
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                swal("Usuario o contraseña incorrecto", "", "warning");
                resultado = false;
                //mostrar alerta
            }
        });
        return resultado;
    }    
