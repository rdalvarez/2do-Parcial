function Enunciado() {

    var pagina = "./enunciado.php";

    $.ajax({
        type: 'POST',
        url: pagina,
        dataType: "html",
        async: true
    })
    .done(function (grilla) {

        $("#divGrilla").html(grilla);

        var pagina = "./puntaje.php";

        $.ajax({
            type: 'POST',
            url: pagina,
            dataType: "html",
            async: true
        })
        .done(function (grilla) {

            $("#divAbm").html(grilla);

        })
        .fail(function (jqXHR, textStatus, errorThrown) {
            alert(jqXHR.responseText + "\n" + textStatus + "\n" + errorThrown);
        });

    })
    .fail(function (jqXHR, textStatus, errorThrown) {
        alert(jqXHR.responseText + "\n" + textStatus + "\n" + errorThrown);
    });
}
function MostrarGrilla() {

 var pagina = "./administracion.php";

    $.ajax({
        type: 'POST',
        url: pagina,
        dataType: "html",
        data: {
            queMuestro: "MOSTRAR_GRILLA"
        },
        async: true
    })
    .done(function (html) {
        $("#divGrilla").html(html);
        //console.log(html);
    })
    .fail(function (jqXHR, textStatus, errorThrown) {
        alert(jqXHR.responseText + "\n" + textStatus + "\n" + errorThrown);
    });

}
function CargarFormUsuario() {

    var pagina = "./administracion.php";

    $.ajax({
        type: 'POST',
        url: pagina,
        dataType: "html",
        data: {
            queMuestro: "FORM"
        },
        async: true
    })
    .done(function (html) {
        //console.log(html);
        $("#divAbm").html(html);
        $('#cboPerfiles > option[value="usuario"]').attr('selected', 'selected');
    })
    .fail(function (jqXHR, textStatus, errorThrown) {
        alert(jqXHR.responseText + "\n" + textStatus + "\n" + errorThrown);
    });

}
function AgregarUsuario() {

    var id = $("#hdnIdUsuario").val();
    var nombre = $("#txtNombre").val();
    var email = $("#txtEmail").val();
    var password = $("#txtPassword").val();
    var perfil = $("#cboPerfiles").val();
    var foto = $("#hdnFotoSubir").val();

    //console.log(id+nombre+email+password+perfil);


    var pagina = "./administracion.php"

    $.ajax({
        type: 'POST',
        url: pagina,
        dataType: "json",
        data: {
            queMuestro: "ALTA_USUARIO",
            id: id,
            nombre: nombre,
            email: email,
            password: password,
            perfil: perfil,
            foto: foto
        },
        async: true
    })
    .done(function (json) {

        //console.log(json);

        if (!json.Exito) {
            alert(json.Mensaje);
            return;
        }
       
        $("#divAbm").html(json);
        
    })
    .fail(function (jqXHR, textStatus, errorThrown) {
        alert(jqXHR.responseText + "\n" + textStatus + "\n" + errorThrown);
    });
}
function EditarUsuario(obj) {//#sin case

    var pagina = "./administracion.php";

    $.ajax({
        type: 'POST',
        url: pagina,
        dataType: "html",
        data: {
            queMuestro: "FORM",
            usuario: obj
        },
        async: true
    })
    .done(function (html) {
        //console.log(html);
        $("#divAbm").html(html);        
    })
    .fail(function (jqXHR, textStatus, errorThrown) {
        alert(jqXHR.responseText + "\n" + textStatus + "\n" + errorThrown);
    });
}
function ModificarUsuario() {//#3a
    //implementar...
    if (!confirm("Modificar USUARIO?")) {
        return;
    }

    var pagina = "./administracion.php";

    var id = $("#hdnIdUsuario").val();
    var foto = $("#hdnFotoSubir").val();

    var usuario = {};
    usuario.id = id;
    usuario.nombre = $("#txtNombre").val();
    usuario.email = $("#txtEmail").val();
    usuario.password = $("#txtPassword").val();
    usuario.foto = foto; //Cuando lo paso no lo veo si no esta definido
    usuario.perfil = $("#cboPerfiles").val();

    console.log(usuario);

    $.ajax({
        type: 'POST',
        url: pagina,
        dataType: "json",
        data: {
            queMuestro: "MODIFICAR_USUARIO",
            usuario: usuario
        },
        async: true
    })
    .done(function (objJson) {

        if (!objJson.Exito) {
            alert(objJson.Mensaje);
            return;
        }

        alert(objJson.Mensaje);

        $("#divAbm").html("");
        MostrarGrilla();

    })
    .fail(function (jqXHR, textStatus, errorThrown) {
        alert(jqXHR.responseText + "\n" + textStatus + "\n" + errorThrown);
    });

}
function EliminarUsuario() {//#3b

    if (!confirm("Eliminar USUARIO?")) {
        return;
    }

    var pagina = "./administracion.php";

    var id = $("#hdnIdUsuario").val();
    var foto = $("#hdnFotoSubir").val();

    //alert("DATOS:"+id+foto);

    var usuario = {};
    usuario.id = id;

    $.ajax({
        type: 'POST',
        url: pagina,
        dataType: "json",
        data: {
            queMuestro: "ELIMINAR_USUARIO",
            usuario: usuario
        },
        async: true
    })
    .done(function (objJson) {

        if (!objJson.Exito) {
            alert(objJson.Mensaje);
            return;
        }

        alert(objJson.Mensaje);

        $("#divAbm").html("");
        MostrarGrilla();

    })
    .fail(function (jqXHR, textStatus, errorThrown) {
        alert(jqXHR.responseText + "\n" + textStatus + "\n" + errorThrown);
    });

}
function Logout() {//#5

    var pagina = "./administracion.php";

    $.ajax({
        type: 'POST',
        url: pagina,
        dataType: "html",
        data: {
            queMuestro: "LOGOUT"
        },
        async: true
    })
    .done(function (html) {

        window.location.href = "login.php?uss=1";

    })
    .fail(function (jqXHR, textStatus, errorThrown) {
        alert(jqXHR.responseText + "\n" + textStatus + "\n" + errorThrown);
    });

}
function traerCdsConWS(){
    
    var pagina = "./administracion.php";

    $.ajax({
        type: 'POST',
        url: pagina,
        dataType: "json",
        data: {
            queMuestro: "TRAER_CDS"
        },
        async: true
    })
    .done(function (json) {
        if (json.Exito) {
            alert(json.Mensaje);
        }
        console.log(json.Mensaje);
        $("#divGrilla").html(json.html);
    })
    .fail(function (jqXHR, textStatus, errorThrown) {
        alert(jqXHR.responseText + "\n" + textStatus + "\n" + errorThrown);
    });

}

function SetCookie(){
    var pagina = "./administracion.php";

    $.ajax({
        type: 'POST',
        url: pagina,
        data: {
            queMuestro: "SET_COOKIE"
        },
        async: true
    })
    .done(function (respuesta) {
        alert("Cookie Seteada");
        location.reload();        
    })
    .fail(function (jqXHR, textStatus, errorThrown) {
        alert(jqXHR.responseText + "\n" + textStatus + "\n" + errorThrown);
    });

}
