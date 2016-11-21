<?php
//require_once("verificar_sesion.php");

require_once("clases/AccesoDatos.php");
require_once("clases/Usuario.php");

if (!isset($usuario)) {//alta
    $nombre = "";
    $email = "";
    $id = "";
    $botonClick = "AgregarUsuario()";
    $botonTitulo = "Guardar";
} else {
    $nombre = $usuario->nombre;
    $email = $usuario->email;
    $id = $usuario->id;
    
    if(isset($usuario->accion)){
        $botonClick = $usuario->accion == "Modificar" ? "ModificarUsuario()" : "EliminarUsuario()";    
        $botonTitulo = $usuario->accion;
    }
    else {
        $botonClick = "ModificarUsuario()";    
        $botonTitulo = "Editar Perfil";        
    }
}

$perfiles = Usuario::TraerTodosLosPerfiles();

?>
<div id="divFrm" class="animated bounceInLeft" style="height:330px;overflow:auto;margin-top:0px;border-style:solid">
    <input type="hidden" id="hdnIdUsuario" value="<?php echo $id; ?>" />
    <input type="text" placeholder="Nombre" id="txtNombre" value="<?php echo $nombre; ?>" />
    <input type="text" placeholder="E-mail" id="txtEmail" value="<?php echo $email; ?>" />
    <input type="password" placeholder="Password" id="txtPassword" value="" />

    <span>Perfil</span>
    <select id="cboPerfiles" >
        <?php
        foreach ($perfiles AS $p) {
            $miPerfil = isset($usuario->perfil) ? $usuario->perfil : "";
            $selected = $miPerfil == $p["perfil"] ? "selected" : "";
            echo "<option value='" . $p["perfil"] . "' " . $selected . ">" . $p["perfil"] . "</option>";
        }
        ?>	
    </select>
    <br/><br/>
    
    <input type="button" class="MiBotonUTN" onclick="<?php echo $botonClick; ?>" value="<?php echo $botonTitulo; ?>"  />
    <input type="hidden" id="hdnQueHago" value="agregar" />
    <input type="hidden" id="hdnFotoSubir" value="foto" />
</div>