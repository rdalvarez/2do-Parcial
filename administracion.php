<?php//require_once("verificar_sesion.php");//require_once("verificar_sesion.php");session_start();require_once 'clases/Usuario.php';require_once 'clases/Producto.php';$objUser = json_decode($_SESSION['Usuario']);$queMuestro = isset($_POST['queMuestro']) ? $_POST['queMuestro'] : NULL;switch ($queMuestro) {        case "ENUNCIADO":                require_once("enunciado.php");                break;        case "MOSTRAR_GRILLA":        $obj = new stdClass();        $obj->html = "";                //var_dump($objUser);        $arrProductos = Producto::TraerTodosLosProductos();         $obj->html.='<script type="text/javascript"> var arr = '.json_encode($arrProductos).'</script>';        $obj->html.='<table class="table">';        //CABEZA        $obj->html.="<thead>";        $obj->html.="<tr>";        $obj->html.='<th>ID</th><th>Nombre</th><th>Porcentaje</th><th class="text-center">Seleccion</th>';        $obj->html.="</tr>";        $obj->html.="</thead>";        //CUERPO        $obj->html.="<tbody>";        for ($i=0; $i < count($arrProductos); $i++) {              $obj->html .= '<tr>';                $obj->html.='<td>'.$arrProductos[$i]->id.'</td>';                $obj->html.='<td>'.$arrProductos[$i]->nombre.'</td>';                $obj->html.='<td>'.$arrProductos[$i]->porcentaje.'</td>';                $obj->html.='<td class="text-center">';                if ($objUser->perfil != "comprador")                $obj->html.='<a class="btn btn-danger" onclick="Borrar('.$arrProductos[$i]->id.')"> <span class="glyphicon glyphicon-trash"></span></a>';                $obj->html.='</td>';            $obj->html.='</tr>';        }        $obj->html.="</tbody>";        $obj->html.="</table>";        echo json_encode($obj);        break;    case "FORM"://MUESTRA FORM ALTA-MODIFICACION USUARIO        $obj = new stdClass();    $obj->html = '    <div id="divFrm" class="animated bounceInLeft" style="height:330px;overflow:auto;margin-top:0px;border-style:solid">                <input type="text" placeholder="Nombre" id="txtNombre"/>        <input type="text" placeholder="Porcentaje" id="txtPorcentaje"/>';        $obj->html .='<br/><br/>                <input type="button" class="MiBotonUTN" onclick="AgregarProducto()" value="Agregar Producto"/>        </div>';        echo json_encode($obj,JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);        break;    case "ALTA_PRODUCTO":        $obj = new stdClass();        $obj->Exito = TRUE;        $obj->Mensaje = "SE AGREGO CORRECTAMENTE";                //VALIDACION CAMPOS VACIOS        if (empty($_POST['nombre']) && empty($_POST['porcentaje'])) {                        $obj->Exito = FALSE;            $obj->Mensaje = "SE NECESITAN TODOS LOS CAMPOS";            echo json_encode($obj);            break;        }        //--------------------------------------------------//        $producto = new Producto();        $producto->nombre = $_POST['nombre'];        $producto->porcentaje = $_POST['porcentaje'];        //ALTA DE producto        if (!Producto::Agregar($producto)) {            $obj->Exito = FALSE;            $obj->Mensaje = "OCURRIO UN ERROR INESPERADO NO SE PUDO AGREGAR EL NUEVO USUARIO";            echo json_encode($obj);            break;        }        //--------------------------------------------------//        echo json_encode($obj);        break;    case "MODIFICAR_USUARIO":                //var_dump($_POST);        $obj = new stdClass();        $obj->Exito = TRUE;        $obj->Mensaje = "SE LOGRO MODIFICAR AL USUARIO";        $modificacionUsuario = $_POST['usuario']; //VALORES A MODIFICAR        //VALIDACION NO DUPLICAR        $arr = Usuario::TraerTodosLosUsuarios(); // TRAIGO TODOS Y COMPARO        $bandera = TRUE;        foreach ($arr as $user) {            if ($user->id != $modificacionUsuario['id']) { //SI EL ID ES DISTINTO COMPARAME EL NOMBRE                                if ($user->email == $modificacionUsuario['email']) { //SI OTRO USUARIO TIENE EL MISMO NOMBRE => NO                                     $bandera = FALSE;                }            }        }        if (!$bandera) {                          $obj->Exito = FALSE;            $obj->Mensaje = "LO SENTIMOS YA DR ENCUENTRA UNA CUENTA CREADA COMO: ".$modificacionUsuario['email'];            echo json_encode($obj);            break;        }        //--------------------------------------------------//        //MODIFICANDO        $objUser = new Usuario($modificacionUsuario['id']); //TRAEME EL DE LA BASE DE DATOS        // SOLO REMPLAZO LOS CAMPOS QUE ESTEN COMPLETOS        if (!empty($modificacionUsuario['nombre'])) $objUser->nombre = $modificacionUsuario['nombre'];        if (!empty($modificacionUsuario['email'])) $objUser->email = $modificacionUsuario['email'];        if (!empty($modificacionUsuario['perfil'])) $objUser->perfil = $modificacionUsuario['perfil'];        if (!empty($modificacionUsuario['foto'])) $objUser->foto = $modificacionUsuario['foto'];        if (!empty($modificacionUsuario['password'])) $objUser->password = $modificacionUsuario['password'];        //var_dump($objUser);        if (!Usuario::Modificar($objUser)) {            $obj->Exito = FALSE;            $obj->Mensaje = "OCURRIO UN ERROR INESPERADO NO SE PUDO MODIFICAR EL USUARIO";            echo json_encode($obj);            break;        }        //implementar...        echo json_encode($obj);        break;            case "ELIMINAR_PRODUCTO":        $obj = new stdClass();        $obj->Exito = TRUE;        $obj->Mensaje = "SE BORRO SATISFACTORIAMENTE EL PRODUCTO";        $id = $_POST['producto']['id'];        if (!Producto::Borrar($id)) {            $obj->Exito = FALSE;            $obj->Mensaje = "OCURRIO UN ERROR INESPERADO NO SE PUDO BORRAR EL PRODUCTO";        }        //implementar...        echo json_encode($obj);        break;    case "LOGOUT":        //implementar...           if (isset($_COOKIE)) {            setcookie("user", "", time() - 3600);        }        $_SESSION['Usuario'] = NULL;        session_destroy();        break;    case "TRAER_CDS":    require_once('clases/lib/nusoap.php');    $obj = new stdClass();    $obj->Exito = TRUE;    $obj->Mensaje = "LOGRE TRAER LOS CDS";    $host = 'http://localhost/php/SERVIDOR/wscds.php';    $client = new nusoap_client($host.'?wsdl');    $err = $client->getError();        if ($err) {            $obj->Mensaje='ERROR EN LA CONSTRUCCION DEL WS: ' . $err;            die();        }    $arrUsuarios = $client->call('ObtenerTodosLosCds', array());    if ($client->fault) {            $obj->Mensaje='ERROR AL INVOCAR METODO: '. print_r($arrUsuarios);    } else {        $err = $client->getError();        if ($err) {            $obj->Mensaje='ERROR EN EL CLIENTE: '. $err;        }else        {            $obj->Exito = FALSE;            $obj->html = '<table class="table">';            //CABEZA            $obj->html.="<thead>";            $obj->html.="<tr>";            $obj->html.='<th>ID</th><th>Interprete</th><th>Año</th><th>Titulo</th>';            $obj->html.="</tr>";            $obj->html.="</thead>";            //CUERPO            $obj->html.="<tbody>";            foreach ($arrUsuarios as $usuario) {                $obj->html .= '<tr>';                    $obj->html.='<td>'.$usuario['id'].'</td>';                    $obj->html.='<td>'.$usuario['interpret'].'</td>';                    $obj->html.='<td>'.$usuario['jahr'].'</td>';                    $obj->html.='<td>'.$usuario['titel'].'</td>';                $obj->html .= '</tr>';            }            $obj->html.="</tbody>";            $obj->html.="</table>";        }    }    echo json_encode($obj);        break;    case "SET_COOKIE":         $cookie_nombre = 'Usuario';        $cookie_valor = json_encode(json_decode($_SESSION['Usuario']));        setcookie($cookie_nombre,$cookie_valor, time() + 30, "/");        break;    default:        echo ":(";}?>