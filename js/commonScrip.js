$(document).ready(function () {
    $( ".CierraSesion" ).click(function() {
        jQuery.ajax({
            url: "ajax/cierraSession_login.php",
            method: 'POST',
            async: false,
            dataType: 'JSON',
            data:{
                token:Cookies.get('tokenSession'),
            },
            success: function (data) {
                Cookies.remove('tokenSession');
                window.location.href = 'index.html';
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {

            }
        });
    });
});