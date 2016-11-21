function Login() {

    var pagina = "./admin_login.php";

    var usuario = {Email: $("#email").val(), Password: $("#password").val()};
    console.log(usuario);

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