<?php 
require_once 'AccesoDatos.php';
/**
* 
*/
class Producto
{
	public $id;
	public $nombre;
	public $porcentaje; 
	
    public function __construct($id = NULL) {
        if ($id !== NULL) {
            $obj = Usuario::TraerUnProductoPorId($id);
            $this->id = $obj->id;
            $this->nombre = $obj->nombre;
            $this->proncentaje = $obj->email;
        }
    }


     public static function TraerUnProductoPorId($id) {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        
        $sql = "SELECT U.id, U.nombre, U.procentaje
                FROM productos U 
                WHERE U.id = :id ";
        
        $consulta = $objetoAccesoDato->RetornarConsulta($sql);
        $consulta->bindValue(':id', $id, PDO::PARAM_INT);
        $consulta->execute();

        $productoBuscado = $consulta->fetchObject('Producto');

        return $productoBuscado;
    }

    public static function Agregar($obj) {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        
        $sql = "INSERT INTO productos (nombre, porcentaje) 
                VALUES (:nombre, :porcentaje)";
        
        $consulta = $objetoAccesoDato->RetornarConsulta($sql);
        $consulta->bindValue(':nombre', $obj->nombre, PDO::PARAM_STR);
        $consulta->bindValue(':porcentaje', $obj->porcentaje, PDO::PARAM_STR);
        $consulta->execute();

        return $objetoAccesoDato->RetornarUltimoIdInsertado();
    }

     public static function TraerTodosLosProductos() {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();

        $sql = "SELECT U.id, U.nombre, U.porcentaje
                FROM productos U";

        $consulta = $objetoAccesoDato->RetornarConsulta($sql);
        $consulta->execute();

        return $consulta->fetchall(PDO::FETCH_CLASS, "Producto");
    }

        public static function Borrar($id) {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("DELETE FROM productos WHERE id = :id");
        $consulta->bindValue(':id', $id, PDO::PARAM_INT);
        $consulta->execute();
        return $consulta->rowCount();
    }
}
 ?>