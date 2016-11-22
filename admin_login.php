<?php
session_start();
	require_once('clases/Usuario.php');
	$obj = new stdClass();
	$obj->Exito = TRUE;
	$obj->Mensaje = "";

	//var_dump($_POST);

	$user = new stdClass();
	$user->nombre = $_POST['usuario']['Nombre'];
	$user->password = $_POST['usuario']['Password'];
	$user->email = $_POST['usuario']['Email'];



	$objDB = Usuario::TraerUsuarioLogueado($user);

	if (!$objDB) {
		$obj->Exito = FALSE;
		$obj->Mensaje = "No se encontro el usuario";
		echo json_encode($obj);	
		return;
	}
/*	else{
		if ($objDB->nombre == $user->nombre) {
			$obj->Exito = FALSE;
			$obj->Mensaje = "No se encontro el usuario";
		}
	}*/

	$_SESSION['Usuario'] = json_encode($objDB);
	$cookie_nombre = 'Usuario';
    $cookie_valor = json_encode(json_decode($_SESSION['Usuario']));

    setcookie($cookie_nombre,$cookie_valor, time() + 30, "/");

	echo json_encode($obj);

?>