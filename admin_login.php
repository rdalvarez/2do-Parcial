<?php
	require_once('clases/lib/nusoap.php');

    $usuario = isset($_POST['usuario']) ? json_decode(json_encode($_POST['usuario'])) : NULL;

    $obj = new stdClass();
    $obj->Exito = FALSE;
    $obj->Mensaje = "ERROR EN LOGIN";

//IMPLEMENTAR...

    $host = 'http://maxineiner.tuars.com/webservice/ws_segundo_parcial.php';

    $client = new nusoap_client($host.'?wsdl');

    $err = $client->getError();
		if ($err) {
			$obj->Mensaje='ERROR EN LA CONSTRUCCION DEL WS: ' . $err;
			die();
		}

	$ObjUsuario = $client->call('LoginWS', array($usuario));

	if ($client->fault) {
			$obj->Mensaje='ERROR AL INVOCAR METODO: '. print_r($ObjUsuario);
			//print_r($ObjUsuario);
	} else {
		$err = $client->getError();
		if ($err) {
			$obj->Mensaje='ERROR EN EL CLIENTE: '. $err;
		}else
		{
			//var_dump($ObjUsuario); = array[0][id] [nombre] [email] [perfil]     SOLO ADMITE LOS 3 PRIMEROS PERFILES (OSEA ES SU BASE)
			if (!empty($ObjUsuario)) {
    			$obj->Exito = TRUE;
	    		$obj->Mensaje = "PUDO LOGUEARSE EXITOSAMENTE";
	    		session_start();
				$_SESSION['Usuario'] = json_encode($ObjUsuario[0]);
			}
		}
	}


    echo json_encode($obj);