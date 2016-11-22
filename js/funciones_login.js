function Login() {

    var pagina = "./admin_login.php";

    var usuario = { Nombre: $("#nombre").val(), Email: $("#email").val(), Password: $("#password").val()};
    //console.log($("#nombre").val());

    $.ajax({
        type: 'POST',
        url: pagina,
        dataType: "json",
        data: {
            usuario: usuario
        },
        async: true
    })
    .done(function (objJson) {
        console.log(objJson);
        if (!objJson.Exito) {
            alert(objJson.Mensaje);
            return;
        }
        window.location.href = "index.php";

    })
    .fail(function (jqXHR, textStatus, errorThrown) {
        alert(jqXHR.responseText + "\n" + textStatus + "\n" + errorThrown);
    });

}

function usuarios(num){

if (num == 1) {
    $("#nombre").val("juan");
    $("#email").val("admin@admin.com");
    $("#password").val("123456");
}
if (num == 2) {
    $("#nombre").val("pepe");
    $("#email").val("user@user.com");
    $("#password").val("123456");
}
if (num == 3) {
    $("#nombre").val("pedro");
    $("#email").val("invitado@invitado.com");
    $("#password").val("123456");
}

}