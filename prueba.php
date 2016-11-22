<?php 
require_once 'clases/Usuario.php';
require_once 'clases/Producto.php';



$r = Producto::TraerTodosLosProductos();
var_dump($r);
 ?>