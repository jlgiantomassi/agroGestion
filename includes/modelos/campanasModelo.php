<?php
include_once($raiz."conexion/BaseDatos.php");

class campanasModel 
{
    private $bd;
    public function __construct()
    {
        $this->bd = new BaseDatos();
    }

    public function campanaById($id)  //returno un array asociativo con el usuario pasado por id
    {
        $sql="SELECT * FROM campanas WHERE idcampana = ".$id;
        return $this->bd->sql($sql);

    }
    public function listarCampanas()
    {
        $sql="SELECT * FROM campanas ORDER BY campana ASC";
        return $this->bd->sql($sql);
    }
}   
?>